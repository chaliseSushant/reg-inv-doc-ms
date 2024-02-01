<?php

namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Models\Revision;
use App\Repository\Interfaces\RevisionRepositoryInterface;

class RevisionRepository extends BaseRepository implements RevisionRepositoryInterface
{
    public function __construct(Revision $model)
    {
        parent::__construct($model);
    }

    public function removeRevision($revision)
    {
        try
        {
            unlink(storage_path(str_replace("storage", "app/public", $revision->url)));
            return $this->destroy($revision->id);
        }
        catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function getRevision($revision_id)
    {
        return $this->findByName('id', $revision_id)->first();
    }

    public function getAllFileRevision($file_id)
    {
        return $this->findByName('file_id', $file_id);
    }

    public function getLatestRevisionFile($file_id){
        return $this->model->where('file_id', $file_id)->orderBy('created_at','DESC')->first();
    }

}
