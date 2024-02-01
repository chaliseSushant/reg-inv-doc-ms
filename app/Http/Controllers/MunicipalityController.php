<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\MunicipalityStoreRequest;
use App\Http\Requests\MunicipalityUpdateRequest;
use App\Http\Resources\DistrictMunicipalitiesResource;
use App\Http\Resources\MunicipalityDetailsResource;
use App\Http\Resources\MunicipalityResource;
use App\Repository\Interfaces\DistrictRepositoryInterface;
use App\Repository\Interfaces\MunicipalityRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MunicipalityController extends Controller
{
    use SuccessMessage;

    private $municipalityRepository;
    private $districtRepository;

    public function __construct(MunicipalityRepositoryInterface $municipalityRepository,
                                DistrictRepositoryInterface $districtRepository)
    {
        $this->municipalityRepository = $municipalityRepository;
        $this->districtRepository = $districtRepository;
    }

    public function index()
    {
        $municipalities = $this->municipalityRepository->getAllMunicipality();
        return MunicipalityResource::collection($municipalities);
    }

    public function store(MunicipalityStoreRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'district_id' => $request->district_id,
        ];

        try {
            DB::beginTransaction();
            $data = $this->municipalityRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added Municipality '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('Municipality'),201);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }


    public function update(MunicipalityUpdateRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'district_id' => $request->district_id,
        ];

        try {
            DB::beginTransaction();
            $this->municipalityRepository->update( $request->id , $fillable_array );
            LogActivityFacade::addToLog('Updated Municipality '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)).' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Municipality'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function trashedMunicipalities()
    {
        $municipalities = $this->municipalityRepository->deletedMunicipalities();
        return MunicipalityResource::collection($municipalities);
    }

    /*public function municipalityDetails($id)
    {
        $municipality = $this->municipalityRepository->getMunicipalityDetails($id);
        //dd($municipality);
        return MunicipalityDetailsResource::collection($municipality);
    }*/

    public function districtMunicipalities($district_id)
    {
        $municipalities = $this->municipalityRepository->getDistrictMunicipalities($district_id);
        return DistrictMunicipalitiesResource::collection($municipalities);
    }

    public function destroy($id)
    {
        $this->municipalityRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted Municipality '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Municipality'),202);
    }
}
