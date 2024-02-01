<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\Department;
use App\Repository\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function deletedDepartments()
    {
        try {
            return $this->model->onlyTrashed()->get();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function getDepartments()
    {
        return $this->model
            ->select('id', 'identifier', 'name')
            ->where('interconnect', '=', '1')
            ->get();
    }

}
