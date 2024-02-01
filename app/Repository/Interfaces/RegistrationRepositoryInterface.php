<?php


namespace App\Repository\Interfaces;


interface RegistrationRepositoryInterface
{
    public function getAllRegistrations($paginate);
    //public function getLatestRevisionRegistration($id);
    public function getRegistration($registration_id);
    public function createRegistrationDocumentable($document_id, $registration_id);
    public function getStatusRegistration($registration_id);
}
