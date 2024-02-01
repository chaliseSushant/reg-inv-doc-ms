<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\District;
use App\Repository\Interfaces\DistrictRepositoryInterface;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    public function __construct(District $model)
    {
        parent::__construct($model);
    }

    public function getAllDistrict($paginator)
    {
        try {
            return $this->model->with('province')->orderBy('name', 'ASC')->paginate($paginator);
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    /*public function getAllDistrictASC()
    {
        try {
            return $this->model->orderBy('name', 'ASC')->get();
        } catch(\Exception $ex){
            return view('dashboard.pages.errors');
        }
    }*/

    public function getProvinceDistricts($province_id)
    {
        if($this->model->where('province_id',$province_id)->exists()) {
            return $this->model->where('province_id',$province_id)->orderBy('name','ASC')->get();
        } else {
            throw new ErrorPageException();
        }
    }

    public function deletedDistricts()
    {
        try {
            return $this->model
                ->with(array('province' => function($query) {$query->withTrashed();}))
                ->onlyTrashed()
                ->get();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }


}
