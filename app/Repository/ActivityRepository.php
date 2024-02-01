<?php

namespace App\Repository;

use App\Models\Activity;
use App\Repository\Interfaces\ActivityRepositoryInterface;

class ActivityRepository extends BaseRepository implements ActivityRepositoryInterface
{
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }

}
