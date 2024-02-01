<?php


namespace App\Traits;

trait SuccessMessage
{
    public function getSuccessMessage($name)
    {
        return ['success' => $name . ' created successfully.' ];
    }

    public function getUpdateSuccessMessage($name)
    {
        return ['update' => $name . ' updated successfully.' ];
    }

    public function getDestroySuccessMessage($name)
    {
        return ['destroy' => $name . ' removed successfully.' ];
    }

    public function getErrorMessage($msg)
    {
        return ['error' => $msg ];
    }
}
