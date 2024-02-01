<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\UserRoleStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\InterserverDepartmentUsersResource;
use App\Http\Resources\InterserverUsersResource;
use App\Http\Resources\UserListResource;
use App\Http\Resources\UserResource;
use App\Repository\Interfaces\RoleRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use SuccessMessage;
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return UserResource::collection($users);
    }

    public function userList()
    {
        $users = $this->userRepository->all(['id','name']);
        return UserListResource::collection($users);
    }

    public function store(UserStoreRequest $request)
    {

        $fillable_array = [
            'name'=> preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
            'email'=> strtolower($request->email),
            'password'=> Hash::make($request->password),
            'role_id' => $request->role_id,
            'department_id' => $request->department_id
        ];

        try {
            DB::beginTransaction();
            $data = $this->userRepository->create($fillable_array);
            LogActivityFacade::addToLog('Added User '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('User'),201);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function role_update(UserRoleStoreRequest $request)
    {
        $fillable_array = [
            'role_id' => $request->role_id
        ];

        try {
            DB::beginTransaction();
            $data = $this->userRepository->update( $request->id , $fillable_array );
            LogActivityFacade::addToLog('Updated Role for User '. $data->name.' '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('User Role'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function destroy($id)
    {
        if(Auth::guard('api')->id() == $id){
            return response()->json(['error' => 'Cannot delete this user'],422);
        }
        else {
            $this->userRepository->destroy($id);
            LogActivityFacade::addToLog('Deleted User '. '"'.$id.'"');
            return response()->json($this->getDestroySuccessMessage('User'),202);
        }
    }

    public function test($department_id){
        $users = $this->userRepository->getDepartmentUsers($department_id);
        return InterserverDepartmentUsersResource::collection($users);
    }

}
