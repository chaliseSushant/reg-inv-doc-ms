<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Repository\FiscalYearRepository;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\InvoiceRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use App\Traits\SuccessMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\JsonResponse;

class IntraserverController extends Controller
{
    use SuccessMessage;
    public function __construct(private DocumentRepositoryInterface $documentRepository,
                                private FiscalYearRepository $fiscalYearRepository,
                                private InvoiceRepositoryInterface $invoiceRepository,
                                /*private FileRepositoryInterface $fileRepository,
                                private RevisionRepositoryInterface $revisionRepository*/)
    {
    }

    public function interserverUsers($organization_identifier)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/api/interconnect/get';
        $connection = $this->connectionCheck($configuration['base_url']);
        if(!$connection){
            return response()->json(['error' => 'Requested '.$configuration['base_url'].' Not Found'],JsonResponse::HTTP_NOT_FOUND);
        }
        $response = Http::withHeaders([
            'Interconnect-Token' => $key, 'Interconnect-Request' => 'A'
        ])->get($url);

        return json_decode($response);
    }

    public function interserverDepartments($organization_identifier)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/api/interconnect/get';
        $connection = $this->connectionCheck($configuration['base_url']);
        if(!$connection){
            return response()->json(['error' => 'Requested '.$configuration['base_url'].' Not Found'],JsonResponse::HTTP_NOT_FOUND);
        }
        $response = Http::withHeaders([
            'Interconnect-Token' => $key, 'Interconnect-Request' => 'AB'
        ])->get($url);

        return json_decode($response);
    }

    public function interserverDepartmentUsers($organization_identifier,$department_id)
    {
        $configuration = config('interconnect.keys.'.$organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/api/interconnect/get';
        $connection = $this->connectionCheck($configuration['base_url']);
        if(!$connection){
            return response()->json(['error' => 'Requested '.$configuration['base_url'].' Not Found'],JsonResponse::HTTP_NOT_FOUND);
        }
        $response = Http::withHeaders([
            'Interconnect-Token' => $key ,
            'Interconnect-Request' => 'AC' ,
            'Interconnect-Data' => $department_id
        ])->get($url);

        return json_decode($response);
    }

    public function interserverInterconnectInvoice(Request $request) //sender
    {
        //dd($request);
        $configuration = config('interconnect.keys.'.$request->organization_identifier);
        $key = $configuration['key'];
        $url = $configuration['base_url'].'/api/interconnect/post';

        $connection = $this->connectionCheck($configuration['base_url']);

        if(!$connection){
            return response()->json(['error' => 'Requested '.$configuration['base_url'].' Not Found'],JsonResponse::HTTP_NOT_FOUND);
        }

        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($request->document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign,$user_id);

        if(!$assignPermission){
            return response()->json(['error' => 'Not authorised for this action '],JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $document = $this->documentRepository->getDocument($request->document_id);

            $headers = ['Interconnect-Token' => $key , 'Interconnect-Request' => 'AD'];

            $sender = Auth::guard('api')->user()->name . ', '. Auth::guard('api')->user()->department->name . ', '. config('organization.name') .', '. config('organization.address');
            $parameter = [
                'attribute' => $document->attribute,
                'invoice_number' => $request->invoice_number,
                'sent_to' => $request->sent_to,
                'receiver_id' => $request->receiver_id,
                'sender' => $sender,
                'invoice_date' => Carbon::now(),
                'subject' => $request->subject,
                'remarks' => $request->invoice_remarks
            ];

            $fiscal_year_id = $this->fiscalYearRepository->getFiscalYearActive();
            $invoice_sender = Auth::guard('api')->user()->name . ', '. Auth::guard('api')->user()->department->name;
            $fillable_array_invoice = [
                'attender_book_number' => $request->attender_book_number,
                'sender' => $invoice_sender,
                'invoice_datetime' => Carbon::now(),
                'invoice_number' => $request->invoice_number,
                'receiver' => $request->receiver,
                'medium' => '2',
                'fiscal_year_id' => $fiscal_year_id,
                'remarks' => $request->invoice_remarks,
                'subject' => $request->subject,
            ];

            $response = Http::withHeaders($headers);

            foreach($document->files as $key => $file)
            {
                $record = url($file->latest_revision->url);
                $record_file = fopen($record, 'r');
                $extension_name = explode('.',$record);
                $response = $response->attach('attachments['.$key.']', $record_file,
                    $file->name.'.'.end($extension_name));
            }

            $response = $response->post($url, $parameter);

            fclose($record_file);

            if($response->status() == JsonResponse::HTTP_ACCEPTED){
                try {
                    DB::beginTransaction();

                    $dataInvoice = $this->invoiceRepository->createInvoice($fillable_array_invoice,$request->document_id);

                    LogActivityFacade::addToLog('Created Invoice Interconnect '.'"'.$dataInvoice->id.'"');
                    DB::commit();

                    $response = ["success" => "Invoice sent successfully."];
                    return response()->json($response,201);

                }catch(\Exception $exp){
                    DB::rollBack();
                    Log::error($exp->getMessage());
                    return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
                }

            } else return response()->json($this->getErrorMessage('Unable to send invoice to '.$request->organization_identifier.'  !!!'),201);

        } catch(\Exception $exp){
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    private function connectionCheck($url){
        $response = null;
        exec('ping -n 1 '.
            preg_replace( "#^[^:/.]*[:/]+#i", "", preg_replace( "{/$}", "", $url ) ),
            $varArray,
            $response);
        return $response == 0 ?  true : false;
    }
}
