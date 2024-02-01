<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\FiscalYearStoreRequest;
use App\Http\Requests\FiscalYearUpdateRequest;
use App\Http\Resources\FiscalYearResource;
use App\Repository\Interfaces\FiscalYearRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FiscalYearController extends Controller
{
    use SuccessMessage;

    private $fiscalyearRepository;

    public function __construct(FiscalYearRepositoryInterface $fiscalyearRepository)
    {
        $this->fiscalyearRepository = $fiscalyearRepository;
    }


    public function index()
    {
        $fiscalyears = $this->fiscalyearRepository->getAllFiscalYear();
        return FiscalYearResource::collection($fiscalyears);
    }

    public function store(FiscalYearStoreRequest $request)
    {
        $active = isset($request->active)?1:0;

        $fillable_array = [
            'year' => $request->year,
            'active' => $active,
        ];

        try {
            DB::beginTransaction();

            $data = $this->fiscalyearRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added Fiscal Year '. $data->year.' '. '"'.$data->id.'"');

            DB::commit();
            return response()->json($this->getSuccessMessage('Fiscal Year'),201);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function update(FiscalYearUpdateRequest $request)
    {
        $active = isset($request->active)?1:0;

        $fillable_array = [
            'year' => $request->year,
            'active' => $active,
        ];

        try {
            DB::beginTransaction();

            $this->fiscalyearRepository->update( $request->id , $fillable_array );
            LogActivityFacade::addToLog('Updated Fiscal Year '. $request->year.' '. '"'.$request->id.'"');

            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Fiscal Year'),202);

        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function destroy($id)
    {
        $this->fiscalyearRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted Fiscal Year '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Fiscal Year'),202);
    }
}
