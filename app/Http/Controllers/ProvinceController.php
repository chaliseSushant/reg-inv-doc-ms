<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\ProvinceStoreRequest;
use App\Http\Requests\ProvinceUpdateRequest;
use App\Http\Resources\ProvinceResource;
use App\Repository\Interfaces\ProvinceRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProvinceController extends Controller
{
    use SuccessMessage;

    private $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function index()
    {
        $provinces = $this->provinceRepository->all();
        return ProvinceResource::collection($provinces);
    }

    public function store(ProvinceStoreRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
        ];

        try {
            DB::beginTransaction();
            $data = $this->provinceRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added Province '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('Province'),201);
        } catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function update(ProvinceUpdateRequest $request)
    {
        $fillable_array = [
            'identifier' => $request->identifier,
            'name' => ucwords($request->name),
        ];

        try {
            DB::beginTransaction();
            $this->provinceRepository->update( $request->id , $fillable_array );
            LogActivityFacade::addToLog('Updated Province '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)).' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Province'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function trashedProvinces()
    {
        $provinces = $this->provinceRepository->deletedProvinces();
        return ProvinceResource::collection($provinces);
    }

    public function destroy($id)
    {
        $this->provinceRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted Province '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Province'),202);
    }
}
