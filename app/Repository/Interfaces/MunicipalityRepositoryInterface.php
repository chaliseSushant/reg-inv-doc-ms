<?php


namespace App\Repository\Interfaces;


interface MunicipalityRepositoryInterface
{
    public function getAllMunicipality();
    //public function getMunicipalityDetails($id);
    public function getDistrictMunicipalities($district_id);
}
