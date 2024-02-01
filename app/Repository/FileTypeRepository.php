<?php

namespace App\Repository;

use App\Models\FileType;
use App\Repository\Interfaces\FileTypeRepositoryInterface;

class FileTypeRepository extends BaseRepository implements FileTypeRepositoryInterface
{
    public function __construct(FileType $model)
    {
        parent::__construct($model);
    }

}
