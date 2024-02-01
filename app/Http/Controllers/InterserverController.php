<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Resources\InterserverDepartmentsResource;
use App\Http\Resources\InterserverDepartmentUsersResource;
use App\Http\Resources\InterserverUsersResource;
use App\Repository\FiscalYearRepository;
use App\Repository\Interfaces\DepartmentRepositoryInterface;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class InterserverController extends Controller
{
    use SuccessMessage;

    public function __construct(private UserRepositoryInterface $userRepository,
                                private DepartmentRepositoryInterface $departmentRepository,
                                private FiscalYearRepository $fiscalYearRepository,
    private RegistrationRepositoryInterface $registrationRepository,
    private DocumentRepositoryInterface $documentRepository,
    private  FileRepositoryInterface $fileRepository)
    {

    }

    public function invokableGet(Request $request){
        if ($request->hasHeader('Interconnect-Request')) {
            if ($request->header('Interconnect-Request') == 'A') {
                return $this->interserverUsers();
            } elseif ($request->header('Interconnect-Request') == 'AB') {
                return $this->interserverDepartments();
            } elseif ($request->header('Interconnect-Request') == 'AC'){
                if($request->header('Interconnect-Data')){
                    return $this->interserverDepartmentUsers($request->header('Interconnect-Data'));
                }
            }
            else
            {
                return response()->json(['error'=> 'Request source not allowed. Request not validated.'],401);
            }
        }
        else
        {
            return response()->json(['error'=> 'Request source not allowed. Request not allowed.'],401);
        }
    }

    public function invokablePost(Request $request){
        if ($request->hasHeader('Interconnect-Request')) {
            if ($request->header('Interconnect-Request') == 'AD') {
                return $this->interserverInvoice($request);
            }
            else
            {
                return response()->json(['error'=> 'Request source not allowed. Request not validated.'],401);
            }
        }
        else
        {
            return response()->json(['error'=> 'Request source not allowed. Request not allowed.'],401);
        }
    }


    private function interserverUsers(){
        $users = $this->userRepository->getUsers();
        return InterserverUsersResource::collection($users);
    }

    private function interserverDepartments(){
        $departments = $this->departmentRepository->getDepartments();
        return InterserverDepartmentsResource::collection($departments);
    }

    private function interserverDepartmentUsers($department_id){
        $users = $this->userRepository->getDepartmentUsers($department_id);
        return InterserverDepartmentUsersResource::collection($users);
    }

    private function interserverInvoice($request) //receiver
    {
        $fiscal_year_id = $this->fiscalYearRepository->getFiscalYearActive();

        $fillable_array_registration = [
            'sender' => $request->sender,
            'medium' => 2, // manual = 1, interserver = 2
            'fiscal_year_id' => $fiscal_year_id,
            //'service_id' => $request->service_id,
            'invoice_number'=> $request->invoice_number,
            //'letter_number' => $request->letter_number,
            'invoice_date' => $request->invoice_date,
            'subject' => $request->subject,
            'remarks' => $request->remarks,
            'complete' => 3,
            //draft = 0 , processing = 1 , completed = 2, received through interconnect = 3, approved for registration = 4,
            //rejected by user = 5
        ];

        try {
            DB::beginTransaction();

            $dataRegistration = $this->registrationRepository->create( $fillable_array_registration );

            if ($request->hasFile('attachments'))
            {
                $dataDocument = $this->documentRepository->
                createRegistrationDocument($request->subject, null, null, $request->attribute, $fiscal_year_id);

                $this->fileRepository->createRegistrationRevisionInterconnect($dataDocument->id, $request->file('attachments'));
            }

            $this->registrationRepository->createRegistrationDocumentable($dataDocument->id, $dataRegistration->id);

            $this->documentRepository->
            createAssignableRegistrationInterconnect($request->sent_to, $request->receiver_id, $dataDocument->id);

            $this->documentRepository->sendInterserverRegistrationNotification
            ($request->receiver_id, $request->sent_to, $request->remarks, $dataRegistration->id, $request->subject);

            LogActivityFacade::addToLog('Created Registration Interconnect '.'"'.$dataRegistration->id.'"');
            DB::commit();

            return response()->json(['success' => 'Registration Received'],JsonResponse::HTTP_ACCEPTED);

        } catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

}
