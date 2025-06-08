<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NotificationController extends Controller implements HasMiddleware
{
    //

    public static function middleware() {

        return [
            new Middleware("auth:sanctum", except: ["readAll"])
        ];
    }

    public function index(Request $request) {
        $notifData = $request->user()->notifications()->get();
        return response()->json([
            "status" => "Success",
            "message" => "Notifications retrieved",
            "data" => $notifData
        ]);
    }

    public function readAll(Request $request) {
        $user_id = $_COOKIE["user_id"];
        $notifications = Notification::where("notifiable_id", $user_id)->where("read_at", null)->get();
        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }
        return response()->json([
            "status" => "Success",
            "message" => "Notifications read",
        ]);
    }

}
