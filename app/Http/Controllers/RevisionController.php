<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\AddLatestRevisionDocumentStoreRequest;
use App\Http\Requests\AddLatestRevisionRegistrationStoreRequest;
use App\Http\Requests\AddLatestRevisionStoreRequest;
use App\Http\Resources\AllRevisionResource;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\SuccessMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RevisionController extends Controller
{
    use SuccessMessage;

    public function __construct(private RegistrationRepositoryInterface $registrationRepository,
                                private DocumentRepositoryInterface $documentRepository,
                                private FileRepositoryInterface $fileRepository,
                                private RevisionRepositoryInterface $revisionRepository,
                                private UserRepositoryInterface $userRepository)
    {
    }


    public function destroyLatestRevision($file_id)
    {
        $revisionCount = $this->revisionRepository->getAllFileRevision($file_id)->count();
        $document_id = $this->fileRepository->getFile($file_id)->get()->pluck('document_id')[0];
        $revision = $this->revisionRepository->getLatestRevisionFile($file_id);

        $registration_id = $this->registrationRepository->getDocumentRegistration($document_id);

        if($registration_id != null){
            $status = $this->registrationRepository->getStatusRegistration($registration_id);
            if($status == 2){
                return response()->json(["error" => 'Cannot add file to this Registration !!!'],201);
            }
        }

        $user_id = Auth::guard('api')->id();

        if($user_id != $revision->user_id){
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        }
        else {
            $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
            $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);
        }
        if(!$assignPermission){
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        } else {
            try
            {
                DB::beginTransaction();

                if($revisionCount > 1){
                    $this->revisionRepository->removeRevision($revision);
                } else {
                    $this->revisionRepository->removeRevision($revision);
                    $this->fileRepository->destroy($revision->file_id);
                }

                if($registration_id != null){
                    LogActivityFacade::addToLog('Removed Revision '.'"'.$revision->id.'" from registration '.'"'
                        .$registration_id.'"');
                } else {
                    LogActivityFacade::addToLog('Removed Revision '.'"'.$revision->id.'" from document '.'"'
                        .$document_id.'"');
                }

                DB::commit();
                return response()->json($this->getDestroySuccessMessage('Revision'),201);

            } catch(\Exception $exp){
                DB::rollBack();
                Log::error($exp->getMessage());
                return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
            }

        }

    }

    public function addLatestRevision(AddLatestRevisionStoreRequest $request)
    {
        $document_id = $this->fileRepository->getFile($request->file_id)->pluck('document_id')[0];

        $registration_id = $this->registrationRepository->getDocumentRegistration($document_id);

        if($registration_id != null){
            $status = $this->registrationRepository->getStatusRegistration($registration_id);
            if($status == 2){
                return response()->json(["error" => 'Cannot add file to this Registration !!!'],201);
            }
        }

        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        try
        {
            if(!$assignPermission){
                return response()->json($this->getErrorMessage('Not authorised for this action '),201);
            } else{
                if ($request->hasFile('attachment'))
                {
                    DB::beginTransaction();

                    $fileName = $this->fileRepository->addAttachment($request->file('attachment'));

                    $fillable_array_revisions = [
                        'file_id' => $request->file_id,
                        'url' => Storage::url(Carbon::now()->format('Y-m') .'/'. $fileName),
                        'user_id' => $user_id,
                    ];
                    $revision = $this->revisionRepository->create( $fillable_array_revisions );


                    if($registration_id != null){
                        LogActivityFacade::addToLog('Added Revision '.'"'.$revision->id.'" to registration '.'"'
                            .$registration_id.'"');
                    } else {
                        LogActivityFacade::addToLog('Added Revision '.'"'.$revision->id.'" to document '.'"'
                            .$document_id.'"');
                    }

                    DB::commit();
                    return response()->json($this->getSuccessMessage('Revision'),201);
                }
            }

        } catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function allRevision($file_id)
    {
        $document_id = $this->fileRepository->getFile($file_id)->first()->document_id;
        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        if(!$assignPermission){
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        } else {
            $revisions = $this->revisionRepository->getAllFileRevision($file_id)->orderBy('created_at', 'ASC')->get();
            return AllRevisionResource::collection($revisions);
        }
    }

}
