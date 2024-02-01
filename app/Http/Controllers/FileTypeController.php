<?php

namespace App\Http\Controllers;

use App\Facade\LogActivityFacade;
use App\Http\Requests\FileTypeStoreRequest;
use App\Http\Requests\FileTypeUpdateRequest;
use App\Http\Resources\FileTypeResource;
use App\Repository\Interfaces\FileTypeRepositoryInterface;
use App\Traits\SuccessMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileTypeController extends Controller
{
    use SuccessMessage;
    private $fileTypeRepository;

    public function __construct(FileTypeRepositoryInterface $fileTypeRepository)
    {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    public function index()
    {
        $file_types = $this->fileTypeRepository->all(['name']);
        return FileTypeResource::collection($file_types);
    }

    public function store(FileTypeStoreRequest $request)
    {
        $fillable_array = [
            'name' => preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)),
        ];

        try {
            DB::beginTransaction();
            $data = $this->fileTypeRepository->create( $fillable_array );
            LogActivityFacade::addToLog('Added File Type '. '"'.$data->id.'"');
            DB::commit();
            return response()->json($this->getSuccessMessage('File Type'),201);
        } catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }


    public function update(FileTypeUpdateRequest $request)
    {
        $fillable_array = [
            'name' => ucwords($request->name),
        ];

        try {
            DB::beginTransaction();
            $this->fileTypeRepository->update( $request->id , $fillable_array );
            LogActivityFacade::addToLog('Updated File Type '. preg_replace('/[\s$@_*]+/', ' ', ucwords($request->name)).' '. '"'.$request->id.'"');
            DB::commit();
            return response()->json($this->getUpdateSuccessMessage('File Type'),202);
        }catch(\Exception $exp){
            DB::rollBack();
            Log::error($exp->getMessage());
            return response()->json($this->getErrorMessage('Something Went wrong !!!'),201);
        }
    }

    public function destroy($id)
    {
        $this->fileTypeRepository->destroy($id);
        LogActivityFacade::addToLog('Deleted File Type '. '"'.$id.'"');
        return response()->json($this->getDestroySuccessMessage('File Type'),202);
    }
}
