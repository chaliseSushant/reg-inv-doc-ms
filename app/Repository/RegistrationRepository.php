<?php


namespace App\Repository;


use App\Exceptions\ErrorPageException;
use App\Models\Registration;
use App\Repository\Interfaces\DocumentRepositoryInterface;
use App\Repository\Interfaces\RegistrationRepositoryInterface;

class RegistrationRepository extends BaseRepository implements RegistrationRepositoryInterface
{
    private $documentRepository;

    public function __construct(Registration $model,
                                DocumentRepositoryInterface $documentRepository)
    {
        parent::__construct($model);
        $this->documentRepository = $documentRepository;
    }

    public function getAllRegistrations($paginate)
    {
        try {
            return $this->model
                ->with('service')
                ->with(['documents'=> function($q){$q->select('id','attribute');}])
                ->orderBy('created_at', 'DESC')->paginate($paginate);
        } catch(\Exception $ex){
            throw new ErrorPageException();
        }
    }

    public function getRegistration($registration_id)
    {
        if($this->model->where('id', $registration_id)->exists()) {
            return $this->model
                //->with('service','documents', 'documents.files', 'documents.files.latest_revision')
                ->where('id',$registration_id)
                ->first();
        } else {
            throw new ErrorPageException();
        }
    }

    public function createRegistrationDocumentable($document_id, $registration_id)
    {
        return $this->findById($registration_id)->documents()->attach($this->documentRepository->findById($document_id));
    }

    public function getStatusRegistration($registration_id)
    {
        if($this->model->where('id', $registration_id)->exists()) {
            return $this->model->select('complete')->where('id', $registration_id)->get()
                ->pluck('complete')[0];
        } else {
            throw new ErrorPageException();
        }
    }

    public function getDocumentRegistration($document_id){
        try{
            $registration_id = $this->documentRepository->findById($document_id)->registrations()
                ->first()->pivot->documentable_id;
        } catch (\ErrorException $exc){
            $registration_id = null;
        }
        return $registration_id;
    }

    public function getRegistrationSubject($registration_id)
    {
        return $this->model->select('subject')->where('id', $registration_id)->get()->pluck('subject')[0];
    }

}
