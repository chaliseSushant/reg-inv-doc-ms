<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\DistrictStoreRequest;
use App\Http\Requests\DistrictUpdateRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\provinceDistrictsResource;
use App\Repository\Interfaces\DistrictRepositoryInterface;
use App\Repository\Interfaces\ProvinceRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DistrictController extends Controller
{
    use SuccessMessage;

    private $provinceRepository;
    private $districtRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository,
                                DistrictRepositoryInterface $districtRepository)
    {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }

    public function index()
    {
        $districts = $this->districtRepository->getAllDistrict(10);
        return DistrictResource::collection($districts);
    }


    public function store(DistrictStoreRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'province_id' => $request->province_id,
        ];

        try {
            DB::beginTransaction();

            $data = $this->districtRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added District '. $data->name.' '. '"'.$data->id.'"');

            DB::commit();
            return response()->json($this->getSuccessMessage('District'),201);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }


    public function update(DistrictUpdateRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'province_id' => $request->province_id,
        ];

        try {
            DB::beginTransaction();

            $this->districtRepository->update( $request->id , $fillable_array );
            LogActivityFacade::
            addToLog('Updated District '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)).' '. '"'.$request->id.'"');

            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('District'),202);
        }catch (\Exception $ex){
            DB::rollBack();
            Log::error($ex->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function trashedDistricts()
    {
        $districts = $this->districtRepository->deletedDistricts();
        return DistrictResource::collection($districts);
    }

    public function provinceDistricts($province_id)
    {
        $districts = $this->districtRepository->getProvinceDistricts($province_id);
        return provinceDistrictsResource::collection($districts);
    }


    public function destroy($id)
    {
        $this->districtRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted District '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('District'),202);
    }
}
