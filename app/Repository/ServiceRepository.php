<?php

namespace App\Repository;

use App\Models\Service;
use App\Repository\Interfaces\ServiceRepositoryInterface;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

}
