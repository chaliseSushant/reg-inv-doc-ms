<?php

namespace App\Repository\Interfaces;

interface DocumentRepositoryInterface
{
    public function createRegistrationDocument($document_title, $document_number, $remarks, $attribute, $fiscal_year_id);
    //public function createAssignableRegistration($user_id, $assign_type, $assign_id, $document_id, $remarks, $assigned);
    public function getAssigns($id);
    public function getFileDocument($document_id);
    public function getCheckAssignRegistration($latestAssign, $assign_type, $assign_id, $user_id);
    public function getAssignPermission($latestAssign, $user_id);
    public function createAssignableRegistrationOthers($latestAssign, $user_id ,$assign_type, $assign_id,
     $document_id, $remarks, $transfer_type);
    public function getLatestAssigns($document_id);
    public function createAssignableRegistrationSelf($assign_id, $document_id);
}
