<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Resources\ServiceResource;
use App\Repository\Interfaces\ServiceRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    use SuccessMessage;

    private $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $services = $this->serviceRepository->all();
        return ServiceResource::collection($services);
    }


    public function store(ServiceStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $this->serviceRepository->create( [
                'title' => $request->title,
            ] );
            LogActivityFacade::addToLog('Added Service '. $data->title.' '. '"'.$data->id.'"');

            DB::commit();
            return response()->json($this->getSuccessMessage('Service'),201);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }


    public function update(ServiceUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->serviceRepository->update($request->id, [
                'title' => $request->title,
            ] );
            LogActivityFacade::
            addToLog('Updated Service '. $request->title.' '. '"'.$request->id.'"');

            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Service'),202);
        }catch (\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function destroy($id)
    {
        $this->serviceRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted Service '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Service'),202);
    }
}
