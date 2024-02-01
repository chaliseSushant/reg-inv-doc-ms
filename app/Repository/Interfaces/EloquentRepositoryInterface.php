<?php

namespace App\Repository\Interfaces;

interface EloquentRepositoryInterface
{

    public function all(array $cols = null);

    public function create(array $attributes);

    public function update($id, array $newupdate);

    public function findById($id);

    public function findByName($name , $value);

    public function selectByName($name, $value, array $select);

    public function destroy($id);

}
