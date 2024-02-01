<?php


namespace App\Repository;


use App\Models\Role;
use App\Repository\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function syncRolePrivilege($data)
    {
        $roles = $this->all(['id']);

        foreach($roles as $role){
            $data->roles()->attach($role->id,['crud' => '0000']);
        }
    }

    public function getAllRolePermission($role_id)
    {
        return $this->model
            ->with('privileges')
            ->where('id',$role_id)
            ->get();
    }

}
