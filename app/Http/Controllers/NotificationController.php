<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    private $middlewares = ['auth'];
    private $user;

    public function __construct()
    {
        $this->middleware($this->middlewares);
        $this->user = Auth::user();
    }


    public function index()
    {
        list($notifications, $count) = Notification::getNotifications();
        return view('notifications.list', compact('notifications', 'count'));
    }

    public function readAll()
    {
        $resp = Notification::readAll();
        return response()->json($resp);
    }

    public function readOne($id)
    {
        $resp = Notification::readOne($id);
        return response()->json($resp);
    }


}
