<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\DistrictStoreRequest;
use App\Http\Resources\DepartmentListResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\InterserverDepartmentsResource;
use App\Http\Resources\InterserverUsersResource;
use App\Models\Department;
use App\Repository\Interfaces\DepartmentRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    use SuccessMessage;

    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $departments = $this->departmentRepository->all();
        return DepartmentResource::collection($departments);
    }

    public function departmentList()
    {
        $departments = $this->departmentRepository->all(['id','name']);
        return DepartmentListResource::collection($departments);
    }

    public function store(DepartmentStoreRequest $request)
    {
        $interconnect = isset($request->interconnect)?1:0;

        $fillable_array = [
            'identifier' => $request->identifier,
            'interconnect' => $interconnect,
            'name' => $request->name,
        ];

        try {
            DB::beginTransaction();
            $data = $this->departmentRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added Department '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('Department'),201);

        } catch(\Exception $exp) {
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }

    }

    public function update(DepartmentUpdateRequest $request)
    {
        $interconnect = isset($request->interconnect)?1:0;

        $fillable_array = [
            'identifier' => $request->identifier,
            'interconnect' => $interconnect,
            'name' => $request->name,
        ];

        try{
            DB::beginTransaction();
            $this->departmentRepository->update( $request->id , $fillable_array );
            LogActivityFacade::
            addToLog('Updated Department '. $request->name.' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Department'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function trashedDepartments()
    {
        $departments = $this->departmentRepository->deletedDepartments();
        return DepartmentResource::collection($departments);
    }

    public function destroy($id)
    {
        $this->departmentRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted District '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Department'),202);
    }

}
