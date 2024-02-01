<?php

namespace App\Repository;

use App\Models\Privilege;
use App\Repository\Interfaces\PrivilegeRepositoryInterface;

class PrivilegeRepository extends BaseRepository implements PrivilegeRepositoryInterface
{
    public function __construct(Privilege $model)
    {
        parent::__construct($model);
    }

    public function syncPrivilegeRole($data)
    {
        $privileges = $this->all(['id']);

        foreach($privileges as $privilege){
            $data->privileges()->attach($privilege->id,['crud' => '0000']);
        }
    }

}
