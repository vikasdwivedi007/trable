<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use SerializeDate;

    public static function getNotifications()
    {
        try {
            $notifications = Auth::user()->notifications()->orderBy('created_at', 'DESC')->take(25)->get();
            $count = Auth::user()->unreadNotifications()->count();
            return [$notifications, $count];
        } catch (\Throwable $t) {
            logger($t);
            return [[], 0];
        }
    }

    public static function readAll()
    {
        try {
            Auth::user()->unreadNotifications->map->markAsRead();
            return ['success' => true];
        } catch (\Throwable $t) {
            logger($t);
            return ['success' => false];
        }
    }

    public static function readOne($notification_id)
    {
        try {
            $notification = Auth::user()->unreadNotifications()->where('id', $notification_id)->first();
            if($notification){
                $notification->markAsRead();
            }
            return ['success' => true];
        } catch (\Throwable $t) {
            logger($t);
            return ['success' => false];
        }
    }

}
