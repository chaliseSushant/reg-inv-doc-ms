<?php

namespace App\Helpers;

use App\Repository\Interfaces\ActivityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    private $ip_address;
    private $browser;
    private $activityRepository;

    public function __construct(Request $request, ActivityRepositoryInterface $activityRepository)
    {
        $this->ip_address = $request->ip();
        $this->browser = $request->userAgent();
        $this->activityRepository = $activityRepository;
    }

    public function addToLog($description, $user_id = null)
    {
        $this->activityRepository->create([
            //'user_id' => isset($user_id) ? $user_id : Auth::guard('api')->user()->id,
            'user_id' => (int) Auth::guard('api')->id() . $user_id,
            'ip_address' => $this->ip_address,
            'browser' => $this->browser,
            'description' => $description,
        ]);
    }
}
