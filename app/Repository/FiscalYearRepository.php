<?php


namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Models\FiscalYear;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;

class FiscalYearRepository extends BaseRepository implements FiscalYearRepositoryInterface
{
    public function __construct(FiscalYear $model)
    {
        parent::__construct($model);
    }

    public function getAllFiscalYear()
    {
        try {
            return $this->model->orderBy('id', 'DESC')->get();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function getFiscalYearActive()
    {
        try {
            return $this->model->select('id')->where('active',1)->pluck('id')[0];
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

}
