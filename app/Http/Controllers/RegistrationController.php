<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\AssignStoreRequest;
use App\Http\Requests\RegistrationStoreRequest;
use App\Http\Resources\AssignsDocumentResource;
use App\Http\Resources\DocumentRegistrationResource;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\ViewRegistrationResource;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\SuccessMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationController extends Controller
{
    use SuccessMessage;

    private $registrationRepository;
    private $fiscalYearRepository;
    private $documentRepository;
    private $fileRepository;
    private $revisionRepository;
    private $userRepository;

    public function __construct(RegistrationRepositoryInterface $registrationRepository,
                                FiscalYearRepositoryInterface $fiscalYearRepository,
                                DocumentRepositoryInterface $documentRepository,
                                FileRepositoryInterface $fileRepository,
                                RevisionRepositoryInterface $revisionRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->registrationRepository = $registrationRepository;
        $this->fiscalYearRepository = $fiscalYearRepository;
        $this->documentRepository = $documentRepository;
        $this->fileRepository = $fileRepository;
        $this->revisionRepository = $revisionRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $registrations = $this->registrationRepository->getAllRegistrations(10);
        return RegistrationResource::collection($registrations);
    }

    public function store(RegistrationStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $fiscal_year_id = $this->fiscalYearRepository->getFiscalYearActive();

            $user_id = Auth::guard('api')->id();

            switch ($request->urgency) {
                case 'important':
                    $attribute = '1-';
                    break;
                case 'very_important':
                    $attribute = '2-';
                    break;
                case 'urgent':
                    $attribute = '3-';
                    break;
                default:
                    $attribute = '0-';
            }

            switch ($request->secrecy) {
                case 'confidential':
                    $attribute .= '1';
                    break;
                case 'top_secret':
                    $attribute .= '2';
                    break;
                default:
                    $attribute .= '0';
            }

            $fillable_array_registration = [
                'sender' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->sender)),
                'medium' => 1, // manual = 1, interserver = 2
                'registration_number' => $request->registration_number,
                'user_id' => $user_id,
                'registration_date' => $request->registration_date,
                'fiscal_year_id' => $fiscal_year_id,
                'service_id' => $request->service_id,
                'invoice_number'=> $request->invoice_number,
                'letter_number' => $request->letter_number,
                'invoice_date' => $request->invoice_date,
                'subject' => $request->subject,
                'remarks' => $request->registration_remarks,
                'complete' => 0,
                //draft = 0 , processing = 1 , completed = 2
            ];
            $dataRegistration = $this->registrationRepository->create( $fillable_array_registration );

            if ($request->hasFile('attachments'))
            {
                $dataDocument = $this->documentRepository->
                createRegistrationDocument($request->subject, $request->letter_number, null, $attribute, $fiscal_year_id);

                $this->fileRepository->createRegistrationRevision($dataDocument->id, $request->file('attachments'), $request->files_name);
            }

            $this->registrationRepository->createRegistrationDocumentable($dataDocument->id, $dataRegistration->id);

            $this->documentRepository->createAssignableRegistrationSelf($user_id, $dataDocument->id);

            LogActivityFacade::addToLog('Created Registration '.'"'.$dataRegistration->id.'"');

            DB::commit();

            $response = ["success" => "Registration created successfully." ,
                'registration' => $dataRegistration,
                'document' => $dataDocument];

            return response()->json($response,201);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function assignRegistration(AssignStoreRequest $request)
    {
        $user_id = Auth::guard('api')->id();
        $document_id = $this->registrationRepository->findById($request->registration_id)->documents()->first()->id;
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignDocument = $this->documentRepository->getCheckAssignRegistration($latestAssign, $request->assign_type, $request->assign_id, $user_id);

        if(array_key_exists("success", $assignDocument))
        {
            try{

                $status = $this->registrationRepository->getStatusRegistration($request->registration_id);

                if($status < 2)
                {
                    DB::beginTransaction();
                    $this->registrationRepository->update($request->registration_id, ['complete' => 1]);

                    //assign_type for App/Models/User = 'user' and App/Models/Department = 'department'
                    //assign_id either user id or department id
                    //transfer_type value forward , approve , disapprove = forward, approve & forward, disapprove & forward respectively
                    $this->documentRepository->createAssignableRegistrationOthers($latestAssign, $user_id,$request->assign_type,
                        $request->assign_id, $document_id, $request->assign_remarks, $request->transfer_type);

                    LogActivityFacade::addToLog('Registration Forwarded by user '.'"'.$user_id .'"'.' Registration ' .'"'.$request->registration_id.'"'. ' to ' .
                        $request->assign_type.' '. '"'.$request->assign_id.'"');

                    $subject = $this->registrationRepository->getRegistrationSubject($request->registration_id);

                    $this->documentRepository->sendRegistrationNotification
                    ($request->assign_id, $request->assign_type, $request->assign_remarks, $request->registration_id, $subject);

                    DB::commit();

                    return response()->json(["success" => 'Registration Forwarded Successfully '],201);

                } else {
                    return response()->json(["error" => 'Cannot Forward this Registration '],201);
                }
            }catch(\Exception $exp){
                DB::rollBack();
                Log::error($exp->getMessage());
                return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
            }
        }
        else{
            return response()->json($assignDocument,201);
        }

    }


    public function viewRegistration($registration_id)
    {
        $registration = $this->registrationRepository->getRegistration($registration_id);
        return new ViewRegistrationResource($registration);
    }

    public function  assignsRegistration($registration_id)
    {
        $document_id = $this->registrationRepository->findById($registration_id)->documents->first()->pivot->document_id;
        $assigns = $this->documentRepository->getAssigns($document_id);
        return AssignsDocumentResource::collection($assigns);
    }

    public function destroyDraft($registration_id)
    {
        try{
            DB::beginTransaction();
            $complete = $this->registrationRepository->getStatusRegistration($registration_id);

            if($complete == 0)
            {
                $assign = $this->documentRepository->getAssigns($registration_id);
                if(Auth::guard('api')->id() == $assign->first()->id){
                    $registration = $this->registrationRepository->findById($registration_id);
                    $document_id = $registration->documents()->sync([]);
                    $document_id = ($document_id['detached'])[0];
                    $document = $this->documentRepository->findById($document_id);
                    $document->users()->sync([]);
                    $this->fileRepository->removeFilesRevisions($document_id);
                    $this->documentRepository->destroy($document_id);
                    $this->registrationRepository->destroy($registration_id);

                    LogActivityFacade::addToLog('Draft Registration Deleted ' .'"'.$registration_id.'"' );

                    DB::commit();
                    return response()->json($this->getDestroySuccessMessage('Registration'),202);
                } else {
                    return response()->json(["error" => 'Unauthorised to remove this Registration '],201);
                }
            } else {
                return response()->json(["error" => 'Cannot remove this Registration '],201);
            }
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function viewDocument($registration_id)
    {
        $document_id = $this->registrationRepository->findById($registration_id)->documents->first()->pivot->document_id;
        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        if(!$assignPermission)
        {
            return response()->json($this->getErrorMessage('Not authorised for this action '),JsonResponse::HTTP_UNAUTHORIZED);
        } else {
            $document = $this->documentRepository->getFileDocument($document_id);
            return new DocumentRegistrationResource($document);
        }
    }

    /*public function assignedRegistrations(){
        $registrations = Auth::guard('api')->user()->allRegistrations(10);
        return RegistrationResource::collection($registrations);
    }*/

    public function assignedRegistrationsCurrentMonth()
    {
        $registrations = Auth::guard('api')->user()->allRegistrations(10);
        return RegistrationResource::collection($registrations);
    }
    public function assignedRegistrationsLastMonth()
    {
        $from = Carbon::now()->subMonths(2);
        $to = Carbon::now()->subMonth();
        $registrations = Auth::guard('api')->user()->allRegistrations(10,$from,$to);
        return RegistrationResource::collection($registrations);
    }

    public function assignedRegistrationsCustomRange($from,$to)
    {
        $registrations = Auth::guard('api')->user()->allRegistrations(10, $from,$to);
        return RegistrationResource::collection($registrations);
    }
}
