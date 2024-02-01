<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Resources\RolePermissionResource;
use App\Http\Resources\RoleResource;
use App\Repository\Interfaces\PrivilegeRepositoryInterface;
use App\Repository\Interfaces\RoleRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    use SuccessMessage;

    private $roleRepository;
    private $privilegeRepository;

    public function __construct(RoleRepositoryInterface $roleRepository,
                                PrivilegeRepositoryInterface $privilegeRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->privilegeRepository = $privilegeRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return RoleResource::collection($roles);
    }

    public function store(RoleStoreRequest $request)
    {
        $fillable_array = [
            'title'=> $request->title,
            'role' => $request->role
        ];

        try {
            DB::beginTransaction();
            $data = $this->roleRepository->create($fillable_array);
            $this->privilegeRepository->syncPrivilegeRole($data);
            LogActivityFacade::addToLog('Added Role '. $data->title.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('Role'),201);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function update(RoleStoreRequest $request)
    {
        $fillable_array = [
            'title'=> $request->title,
            'role' => $request->role,
        ];

        try {
            DB::beginTransaction();
            $this->roleRepository->update( $request->id , $fillable_array );
            LogActivityFacade::
            addToLog('Updated Role '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->role)).' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('Role'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function rolePermission($role_id)
    {
        $rolePermission =  $this->roleRepository->getAllRolePermission($role_id);
        return RolePermissionResource::collection($rolePermission);
    }

    public function rolePermissionUser()
    {
        $rolePermission =  $this->roleRepository->getAllRolePermission(Auth::guard('api')->id());
        return RolePermissionResource::collection($rolePermission);
    }

    public function updatepermission(Request $request)
    {
        dd($request);
    }

    public function destroy($id)
    {
        if(Auth::guard('api')->user()->role_id == $id){
            return response()->json(['error' => 'Cannot delete this role'],422);
        }
        else {
            $this->roleRepository->destroy($id);
            LogActivityFacade::addToLog('Deleted Role '. '"'.$id.'"');
            return response()->json($this->getDestroySuccessMessage('Role'),202);
        }

    }
}
