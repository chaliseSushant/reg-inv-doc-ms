<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\DocumentAssignStoreRequest;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Resources\DocumentRegistrationInvoiceResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\FilesDocumentResource;
use App\Http\Resources\ViewDocumentResource;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Traits\SuccessMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    use SuccessMessage;


    public function __construct(private RegistrationRepositoryInterface $registrationRepository,
                                private DocumentRepositoryInterface $documentRepository,
                                private FiscalYearRepositoryInterface $fiscalYearRepository,
                                private FileRepositoryInterface $fileRepository)
    {

    }

    public function documentsCurrentMonth()
    {
        $documents = Auth::guard('api')->user()->allDocuments(10);
        return DocumentResource::collection($documents);
    }
    public function documentsLastMonth()
    {
        $from = Carbon::now()->subMonths(2);
        $to = Carbon::now()->subMonth();
        $documents = Auth::guard('api')->user()->allDocuments(10,$from,$to);
        return DocumentResource::collection($documents);
    }

    public function documentsCustomRange($from,$to)
    {
        $documents = Auth::guard('api')->user()->allDocuments(10, $from,$to);
        return DocumentResource::collection($documents);
    }


    public function viewDocument($document_id)
    {
        $document = $this->documentRepository->getDocument($document_id);
        return new ViewDocumentResource($document);
    }

    public function documentFiles($document_id)
    {
        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign,$user_id);
        if(!$assignPermission){
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        } else{

            $files = $this->fileRepository->getDocumentFiles($document_id);
            return FilesDocumentResource::collection($files);
        }
    }


    public function store(DocumentStoreRequest $request)
    {
        try{
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

            $fillable_array_document = [
                'title' => $request->document_title,
                'document_number' => $request->document_number,
                'remarks' => $request->document_remarks,
                'fiscal_year_id' => $fiscal_year_id,
                'attribute' => $attribute
            ];

            if ($request->hasFile('attachments'))
            {
                $dataDocument = $this->documentRepository->create($fillable_array_document);
                //same as creating registration revision so same method is used
                $this->fileRepository->createRegistrationRevision($dataDocument->id, $request->file('attachments'), $request->files_name);
            }

            $this->documentRepository->createAssignableRegistrationSelf($user_id, $dataDocument->id);

            LogActivityFacade::addToLog('Added Document '.'"'.$dataDocument->id.'"');

            DB::commit();

            $response = ["success" => "Document created successfully.", 'document' => $dataDocument];

            return response()->json($response,201);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function assignDocument(DocumentAssignStoreRequest $request)
    {
        //cannot assign to self
        //can assign to own department
        //can assign to self even if assigned to department
        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($request->document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign,$user_id);

        try{
            if(!$assignPermission){
                return response()->json($this->getErrorMessage('Not authorised for this action '),201);
            } else {
                if($request->assign_type == 'user' and $request->assign_id == $user_id) {
                    return response()->json($this->getErrorMessage('Cannot assign to self '),201);
                } else {
                    DB::beginTransaction();
                    $this->documentRepository->createAssignableRegistrationOthers
                    ($latestAssign, $user_id,$request->assign_type,
                        $request->assign_id, $request->document_id, $request->assign_remarks,'forward');

                    $subject = $this->documentRepository->getDocumentRemarks($request->document_id);

                    $this->documentRepository->sendDocumentNotification
                    ($request->assign_id, $request->assign_type, $request->assign_remarks, $request->document_id, $subject);

                    LogActivityFacade::addToLog
                    ('Forwarded Document '.'"'.$request->document_id.'" to '. $request->assign_type.' "'.$request->assign_id.'"');

                    DB::commit();
                    return response()->json(["success" => 'Document Forwarded Successfully '],201);
                }
            }

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function documentRegistrationInvoice($document_id)
    {
        $registrations_invoices = $this->documentRepository->getDocumentOnly($document_id);
        return new DocumentRegistrationInvoiceResource($registrations_invoices);
    }
    public function destroy($document_id)
    {
        $user_id = Auth::guard('api')->id();
        $assignsCount = $this->documentRepository->getAssigns($document_id)->count();
        if($assignsCount != 1){
            return response()->json($this->getErrorMessage('Cannot delete this document '),201);
        } else {
            $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
            $assignPermission = $this->documentRepository->getAssignPermission($latestAssign,$user_id);
            if(!$assignPermission){
                return response()->json($this->getErrorMessage('Not authorised for this action '),201);
            } else {
                $document = $this->documentRepository->findById($document_id);
                if($document->registrations()->first() != null){
                    return response()->json($this->getErrorMessage('Not authorised for this action '),201);
                } else {
                    try {

                        DB::beginTransaction();
                        $document->users()->sync([]);
                        $this->fileRepository->removeFilesRevisions($document_id);
                        $this->documentRepository->destroy($document_id);
                        LogActivityFacade::addToLog('Deleted Document '.'"'.$document_id.'"');
                        DB::commit();
                        return response()->json($this->getDestroySuccessMessage('Document'),201);

                    }catch(\Exception $exp){
                        DB::rollBack();
                        Log::error($exp->getMessage());
                        return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
                    }
                }
            }
        }
    }




}
