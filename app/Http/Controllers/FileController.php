<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\AddFileStoreRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    use SuccessMessage;

    public function __construct(private FileRepositoryInterface $fileRepository,
                                private RevisionRepositoryInterface $revisionRepository,
                                private DocumentRepositoryInterface $documentRepository,
                                private RegistrationRepositoryInterface $registrationRepository)
    {
    }

    public function fileRevision($file_id)
    {
        $fileRevision = $this->fileRepository->getFileRevision($file_id);
        return new FileResource($fileRevision);
    }

    public function addFiles(AddFileStoreRequest $request)
    {
        $registration_id = $this->registrationRepository->getDocumentRegistration($request->document_id);

        if($registration_id != null){
            $status = $this->registrationRepository->getStatusRegistration($registration_id);
            if($status == 2){
                return response()->json(["error" => 'Cannot add file to this Registration !!!'],201);
            }
        }

        $user_id = Auth::guard('api')->id();
        $latestAssign = $this->documentRepository->getLatestAssigns($request->document_id);
        $assignPermission = $this->documentRepository->getAssignPermission($latestAssign, $user_id);

        if(!$assignPermission){
            return response()->json($this->getErrorMessage('Not authorised for this action '),201);
        } else {

            try{
                DB::beginTransaction();
                if ($request->hasFile('attachments'))
                {
                    //$dataFileRevision = $this->fileRepository->addFileRegistration($request->document_id, $request->file('attachment'), $request->file_name, $user_id);
                    $this->fileRepository->createRegistrationRevision($request->document_id, $request->file('attachments'), $request->files_name);
                }

                if($registration_id != null){
                    LogActivityFacade::addToLog('File Revision added to registration ' .'"' .$registration_id.'"' );
                } else {
                    LogActivityFacade::addToLog('File Revision added to document ' .'"' .$request->document_id.'"' );
                }

                DB::commit();
                return response()->json($this->getSuccessMessage('File'),201);
            } catch(\Exception $exp){
                DB::rollBack();
                Log::error($exp->getMessage());
                return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
            }
        }
    }



    /*public function addFile($registration_id)
    {
        $status = $this->registrationRepository->getStatusRegistration($registration_id);


        if($status == 2){
            return response()->json(["error" => 'Cannot add file to this Registration !!!'],201);
        } else {
            $assignPermission = $this->documentRepository->getAssignPermission($document_id, $user_id);
        }
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
