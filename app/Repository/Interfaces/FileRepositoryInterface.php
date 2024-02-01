<?php

namespace App\Repository\Interfaces;

interface FileRepositoryInterface
{
    public function createRegistrationRevision($document_id, $files, $fileName);
    public function removeFilesRevisions($document_id);
    public function getFileRevision($file_id);
}
