<?php

namespace App\Repository\Interfaces;

interface RevisionRepositoryInterface
{
    public function removeRevision($revision);
    public function getRevision($revision_id);
    public function getAllFileRevision($file_id);
}
