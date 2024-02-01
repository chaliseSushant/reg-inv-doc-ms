<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getDepartmentUser($user_id)
    {
        if($this->model->where('id', $user_id)->exists()) {
            return $this->model->select('department_id')->where('id',$user_id)->get()->pluck('department_id')[0];
        } else {
            throw new ErrorPageException();
        }
    }

    public function getUsers()
    {
        return $this->model
            ->with('department')
            ->whereHas('department',  function($q) {$q
                ->select('id','name')
                ->where('interconnect', '1');}) //query on department model
            ->select('id', 'name', 'department_id')
            ->get();
    }

    public function getDepartmentUsers($department_id)
    {
        return $this->model
            ->with('department')
            ->whereHas('department',  function($q) use($department_id) {$q
                ->select('name')
                ->where('id', $department_id)
                ->where('interconnect', '1');}) //query on department model
            ->select('id', 'name')
            ->get();
    }

    public function getDepartmentAllUser($department_id)
    {
        return $this->model->where('department_id', $department_id)->get();
    }

    /*public function getAssignedRegistration(){
        return $this->model->allRegistrations(10);
    }*/

}
