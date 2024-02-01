<?php

namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Models\File;
use App\Repository\Interfaces\FileRepositoryInterface;
use App\Repository\Interfaces\RevisionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    private $revisionRepository;
    public function __construct(File $model,
                                RevisionRepositoryInterface $revisionRepository)
    {
        parent::__construct($model);
        $this->revisionRepository = $revisionRepository;
    }

    public function createRegistrationRevision($document_id, $files, $files_name)
    {
        foreach($files as $key => $attachment)
        {
            $revisionFileName = $this->addAttachment($attachment);

            $dataFile = $this->create(['document_id' => $document_id, 'name' => $files_name[$key]]);

            $fillable_array_revisions = [
                'file_id' => $dataFile->id,
                'url' => Storage::url(Carbon::now()->format('Y-m') .'/'. $revisionFileName),
                'user_id' => Auth::guard('api')->id(),
            ];
            $this->revisionRepository->create( $fillable_array_revisions );
        }
    }

    public function createRegistrationRevisionInterconnect($document_id, $files)
    {
        foreach($files as $attachment)
        {
            $revisionFileName = $this->addAttachment($attachment);

            $dataFile = $this->create(['document_id' => $document_id, 'name' => $attachment->getClientOriginalName()]);

            $fillable_array_revisions = [
                'file_id' => $dataFile->id,
                'url' => Storage::url(Carbon::now()->format('Y-m') .'/'. $revisionFileName),
                'user_id' => Auth::guard('api')->id(),
            ];
            $this->revisionRepository->create( $fillable_array_revisions );
        }
    }


    public function removeFilesRevisions($document_id)
    {
        $files = $this->model->where('document_id', $document_id)->get();
        foreach($files as $file)
        {
            $revisions = $this->revisionRepository->findByName('file_id', $file->id)->get();
            foreach($revisions as $revision)
            {
                $this->revisionRepository->removeRevision($revision);
            }
            $this->destroy($file->id);
        }
    }

    public function getFile($file_id)
    {
        return $this->findByName('id', $file_id);
    }


    /*public function addFileRegistration($document_id, $file, $file_name, $user_id)
    {
        $revisionFileName = $this->addAttachment($file);
        $dataFile = $this->create(['document_id' => $document_id, 'name' => $file_name]);

        $fillable_array_revisions = [
            'file_id' => $dataFile->id,
            'url' => Storage::url(Carbon::now()->format('Y-m') .'/'. $revisionFileName),
            'user_id' => $user_id,
        ];
        return $this->revisionRepository->create( $fillable_array_revisions );
    }*/

    public function addAttachment($attachment)
    {
        $fileName = "doc_".uniqid() . '.' . $attachment->getClientOriginalExtension();
        $temp_path = storage_path('app/public/'. Carbon::now()->format('Y-m'));

        if (!Storage::disk('public')->has(Carbon::now()->format('Y-m')))
        {
            Storage::disk('public')->makeDirectory(Carbon::now()->format('Y-m'));
        }

        try{
            $img = Image::make($attachment->getRealPath())->orientate()->interlace()->encode('jpg', 66.7);
            $img->save($temp_path.'/'.$fileName);
        }catch(NotReadableException $ex){
            $attachment->move(storage_path('app/public/'. Carbon::now()->format('Y-m')), $fileName);
        }

        return $fileName;
    }

    public function getFileRevision($file_id)
    {
        if($this->model->where('id', $file_id)->exists()) {
            return $this->model
                ->with(['revisions'=> function($q){$q->orderBy('created_at','DESC')->limit(1);}])
                ->where('id',$file_id)
                ->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function getDocumentFiles($document_id){
        if($this->model->where('id', $document_id)->exists()) {
            return $this->model
                ->where('document_id',$document_id)
                ->get();
        } else {
            throw new ErrorPageException();
        }
    }


}
