<?php


namespace App\Repository\Interfaces;


interface RoleRepositoryInterface
{
    public function syncRolePrivilege($data);
    public function getAllRolePermission($role_id);
}
