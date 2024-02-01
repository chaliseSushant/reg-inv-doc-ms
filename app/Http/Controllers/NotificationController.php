<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkRegistrationNotificationRequest;
use App\Http\Resources\ReadNotificationResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UnreadNotificationResource;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unreadNotification(){
        //$notification = Auth::guard('api')->user()->unreadNotifications;
        $notification = Auth::guard('api')->user()->notifications()->where('read_at', null )->get();
        return UnreadNotificationResource::collection($notification);
    }

    public function readNotification(){
        //$notification = Auth::guard('api')->user()->readNotifications;
        $notification = Auth::guard('api')->user()->notifications()->where('read_at','!=', null )->paginate(10);
        return ReadNotificationResource::collection($notification);
    }

    public function markNotification(MarkRegistrationNotificationRequest $request){
        $notification = Auth::guard('api')->user()->notifications()->where('id', $request->notification_id)->first();
        $notification->markAsRead();
        return response()->json(['success' => 'marked'], 201);
    }

    public function markAllNotification(){
        Auth::guard('api')->user()->notifications()->where('read_at', null )->update(['read_at' => now()]);
        return response()->json(['success' => 'marked all notifications'], 201);
    }

    public function getAllNotification(){
        $notification = Auth::guard('api')->user()->notifications()->paginate(10);
        return NotificationResource::collection($notification);
    }

}
