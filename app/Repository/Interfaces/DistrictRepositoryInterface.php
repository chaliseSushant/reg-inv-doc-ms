<?php


namespace App\Repository\Interfaces;


interface DistrictRepositoryInterface
{
    public function getAllDistrict($paginator);
    public function getProvinceDistricts($province_id);
    public function deletedDistricts();
}
