<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\PrivilegeStoreRequest;
use App\Http\Requests\PrivilegeUpdateRequest;
use App\Http\Resources\PrivilegeResource;
use App\Repository\Interfaces\PrivilegeRepositoryInterface;
use App\Repository\Interfaces\RoleRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PrivilegeController extends Controller
{
    use SuccessMessage;

    private $privilegeRepository;
    private $roleRepository;

    public function __construct(PrivilegeRepositoryInterface $privilegeRepository,
                                RoleRepositoryInterface $roleRepository)
    {
        $this->privilegeRepository = $privilegeRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $privileges = $this->privilegeRepository->all();
        return PrivilegeResource::collection($privileges);

    }


    public function store(PrivilegeStoreRequest $request)
    {
        $fillable_array = [
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'identifier' => strtolower(Str::slug($request->name, "-"))
        ];

        try {
            DB::beginTransaction();
            $data = $this->privilegeRepository->create( $fillable_array );
            $this->roleRepository->syncRolePrivilege($data);
            LogActivityFacade::addToLog('Added Privilege '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('Privilege'),201);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }


    public function update(PrivilegeUpdateRequest $request)
    {
        $fillable_array = [
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'identifier' => strtolower(Str::slug($request->name, "-"))
        ];

        try {
            DB::beginTransaction();
            $this->privilegeRepository->update( $request->id, $fillable_array );
            LogActivityFacade::addToLog
            ('Updated Privilege '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)).' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Privilege'),201);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function destroy($id)
    {
        $this->privilegeRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted Privilege '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('Privilege'),202);
    }


}
