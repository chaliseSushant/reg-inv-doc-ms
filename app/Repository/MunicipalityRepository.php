<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\Municipality;
use App\Repository\Interfaces\MunicipalityRepositoryInterface;

class MunicipalityRepository extends BaseRepository implements MunicipalityRepositoryInterface
{
    public function __construct(Municipality $model)
    {
        parent::__construct($model);
    }

    public function getAllMunicipality()
    {
        try {
            return $this->model->with('district')->orderBy('district_id')->get();
            //return $this->model->with('district')->orderBy('district_id')->paginate($paginate);
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    /*public function getMunicipalityDetails($id)
    {
        try {
            return $this->model->with('district')->where('id',$id)->get();
        } catch(\Exception $ex){
            return view('dashboard.pages.errors');
        }

    }*/


    public function getDistrictMunicipalities($district_id)
    {
        if($this->model->where('district_id',$district_id)->exists()) {
            return  $this->model->where('district_id',$district_id)->orderBy('name','ASC')->get();
        } else {
            throw new ErrorPageException();
        }
    }

    public function deletedMunicipalities()
    {
        try {
            return $this->model
                ->with(array('district' => function($query) {$query->withTrashed();}))
                ->onlyTrashed()
                ->get();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

}
