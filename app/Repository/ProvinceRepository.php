<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\Province;
use App\Repository\Interfaces\ProvinceRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    public function __construct(Province $model)
    {
        parent::__construct($model);
    }

    public function deletedProvinces()
    {
        try {
            return $this->model->onlyTrashed()->get();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }
}
