<?php

namespace App\Repository;

use App\Exceptions\ErrorPageException;
use App\Models\Document;
use App\Notifications\DocumentNotification;
use App\Notifications\InterserverRegistrationNotification;
use App\Notifications\RegistrationNotification;
use App\Repository\Interfaces\DepartmentRepositoryInterface;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    private $userRepository;
    private $departmentRepository;

    public function __construct(Document $model,
                                UserRepositoryInterface $userRepository,
                                DepartmentRepositoryInterface $departmentRepository)
    {
        parent::__construct($model);
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function createRegistrationDocument($document_title, $document_number, $remarks, $attribute, $fiscal_year_id )
    {
        $fillable_array = [
            "title" => $document_title,
            "document_number" => $document_number,
            "remarks" => $remarks,
            "attribute" => $attribute,
            "fiscal_year_id" => $fiscal_year_id,
        ];

        return $this->create($fillable_array);
    }

    public function createAssignableRegistrationOthers
    ($latestAssign, $user_id ,$assign_type, $assign_id,
     $document_id, $remarks, $transfer_type)
    {
        $transfer_type = $transfer_type == 'forward' ? ['approved_at'=>null]
            : ($transfer_type == 'approve' ? ['approved_at'=>Carbon::now()] : ['disapproved_at'=>Carbon::now()]);

        if ($latestAssign instanceof \App\Models\User){
            $this->model->users()->newPivotStatement()
                ->where('assignable_type', $latestAssign->pivot->assignable_type)
                ->where('assignable_id', $latestAssign->pivot->assignable_id)
                ->where('document_id', $latestAssign->pivot->document_id)
                ->where('created_at', $latestAssign->pivot->created_at)
                ->where('updated_at', $latestAssign->pivot->updated_at)
                ->update(array_merge($transfer_type,['remarks'=> $remarks, 'user_id'=> $user_id, 'updated_at'=>Carbon::now()]));
        } else {
            $this->model->departments()->newPivotStatement()
                ->where('assignable_type', $latestAssign->pivot->assignable_type)
                ->where('assignable_id', $latestAssign->pivot->assignable_id)
                ->where('document_id', $latestAssign->pivot->document_id)
                ->where('created_at', $latestAssign->pivot->created_at)
                ->where('updated_at', $latestAssign->pivot->updated_at)
                ->update(array_merge($transfer_type,['remarks'=> $remarks, 'user_id'=> $user_id, 'updated_at'=>Carbon::now()]));
        }

        if ($assign_type === 'user'){
            return $this->userRepository->findById($assign_id)->documents()->attach($this->findById($document_id));
        } else{
            return $this->departmentRepository->findById($assign_id)->documents()->attach($this->findById($document_id));
        }

    }

    public function createAssignableRegistrationSelf($assign_id, $document_id)
    {
        return $this->userRepository->findById($assign_id)->documents()->attach($this->findById($document_id));
    }

    public function createAssignableRegistrationInterconnect($sent_to, $assign_id, $document_id)
    {
        if($sent_to == 'user')
            return $this->userRepository->findById($assign_id)->documents()->attach($this->findById($document_id));
        else
            return $this->departmentRepository->findById($assign_id)->documents()->attach($this->findById($document_id));
    }

    public function getAssigns($id)
    {
        if($this->model->where('id', $id)->exists()) {
            return $this->model->find($id)->assigns->sortBy('pivot.created_at');
        } else {
            throw new ErrorPageException();
        }
    }

    public function getLatestAssigns($document_id)
    {
        if($this->model->where('id', $document_id)->exists()) {
            return $this->model->find($document_id)->assigns->sortByDesc('pivot.created_at')->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function getCheckAssignRegistration($latestAssign, $assign_type, $assign_id, $user_id)
    {
        if($latestAssign instanceof \App\Models\Department){
            //check if the user is in the department
            $department_id = $this->userRepository->getDepartmentUser($user_id);
            if($latestAssign->pivot->assignable_id != $department_id){
                return ["error" => 'Not authorised for this action '];
            }else{
                if($assign_type == 'department'){
                    //cannont assign registration to same department
                    if($assign_id == $latestAssign->pivot->assignable_id){
                        return ["error" => 'Cannot forward this Registration to same Department '];
                    } else {
                        return ['success' => 'forward'];
                    }
                } else {
                    //cannot assign registration to user of same department
                    $department_id = $this->userRepository->getDepartmentUser($assign_id);
                    if($department_id == $latestAssign->pivot->assignable_id){
                        return ["error" => 'User exists in same Department '];
                    }
                    else{
                        return ['success' => 'forward'];
                    }
                }
            }
        } else {
            //check if user is assigned this document
            if($user_id != $latestAssign->pivot->assignable_id){
                return ["error" => 'Not authorised for this action '];
            } else {
                // cannot assign registration self
                if($assign_type == 'user' && $assign_id == $user_id){
                    return ["error" => 'Cannot Forward this Registration to self '];
                } else {
                    return ['success' => 'forward'];
                }
            }
        }

    }

    public function getFileDocument($document_id)
    {
        if($this->model->where('id', $document_id)->exists()) {
            return $this->model
                //->with( 'files', 'files.latest_revision')
                ->with( 'files')
                ->where('id',$document_id)
                ->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function getDocument($document_id)
    {
        if($this->model->where('id', $document_id)->exists()) {
            return $this->model
                ->with('files', 'files.latest_revision')
                //->with(['files.revisions'=> function($q){$q->orderBy('created_at','DESC')->limit(1);}])
                ->where('id',$document_id)
                ->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function getAssignPermission($latestAssign, $user_id)
    {
        //$latestAssign = $this->getLatestAssigns($document_id);

        if($latestAssign instanceof \App\Models\Department) {
            $department_id = $this->userRepository->getDepartmentUser($user_id);
            if($department_id != $latestAssign->pivot->assignable_id){
                return false;
            }else{
                return true;
            }
        } else{
            if($user_id != $latestAssign->pivot->assignable_id){
                return false;
            }else{
                return true;
            }
        }
    }

    public function getDocumentOnly($document_id)
    {
        return $this->model->find($document_id);
    }

    public function getDocumentRemarks($document_id)
    {
        return $this->model->select('remarks')->where('id', $document_id)->get()->pluck('remarks')[0];
    }

   /* public function getAssignedRegistration(){
        return $this->userRepository->model->allRegistrations(10);
    }*/

    public function sendRegistrationNotification($assign_id, $assign_type, $assign_remarks, $registration_id, $subject)
    {
        if($assign_type == 'user'){
            $user = $this->userRepository->findById($assign_id);
            Notification::send($user, new RegistrationNotification($assign_remarks,$registration_id, $subject));
        } else {
            $users = $this->userRepository->getDepartmentAllUser($assign_id);
            Notification::send($users, new RegistrationNotification($assign_remarks,$registration_id, $subject));
        }
    }

    public function sendDocumentNotification($assign_id, $assign_type, $assign_remarks, $document_id, $subject)
    {
        if($assign_type == 'user'){
            $user = $this->userRepository->findById($assign_id);
            Notification::send($user, new DocumentNotification($assign_remarks,$document_id, $subject));
        } else {
            $users = $this->userRepository->getDepartmentAllUser($assign_id);
            Notification::send($users, new DocumentNotification($assign_remarks,$document_id, $subject));
        }
    }

    public function sendInterserverRegistrationNotification($assign_id, $assign_type, $assign_remarks, $registration_id, $subject)
    {
        if($assign_type == 'user'){
            $user = $this->userRepository->findById($assign_id);
            Notification::send($user, new InterserverRegistrationNotification($assign_remarks,$registration_id, $subject));
        } else {
            $users = $this->userRepository->getDepartmentAllUser($assign_id);
            Notification::send($users, new InterserverRegistrationNotification($assign_remarks,$registration_id, $subject));
        }
    }
}
