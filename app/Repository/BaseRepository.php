<?php


namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        if(!$model){
            throw new ErrorPageException();
        } else {
            $this->model = $model;
        }
    }

    public function all(array $cols = null)
    {
        try {
            return isset($cols) ? $this->model->all($cols) : $this->model->all();
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $newupdate)
    {
        if($this->model->where('id', $id)->exists()) {
            return $this->model->where('id',$id)->update($newupdate);
        } else {
            throw new ErrorPageException();
        }
    }

    public function findById($id)
    {
        if($this->model->where('id', $id)->exists()) {
            return $this->model->find($id);
        } else {
            throw new ErrorPageException();
        }
    }

    public function fieldExists($fieldName, $fieldValue)
    {
        if($this->model->where($fieldName, $fieldValue)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public function findByName($name, $value)
    {
        if($this->model->where($name, $value)->exists()) {
            return $this->model->where($name, $value);
        } else {
            throw new ErrorPageException();
        }
    }

    public function selectByName($name, $value, array $select)
    {
        if($this->model->where($name, $value)->exists()) {
            return $this->model->select($select)->where($name, $value);
        } else {
            throw new ErrorPageException();
        }
    }

    public function destroy($id)
    {
        if($this->model->where('id', $id)->exists()) {
            return $this->model->find($id)->delete();
        } else {
            throw new ErrorPageException();
        }
    }
}
