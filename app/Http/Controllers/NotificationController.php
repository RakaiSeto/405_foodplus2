<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NotificationController extends Controller implements HasMiddleware
{
    //

    public static function middleware() {

        return [
            new Middleware("auth:sanctum")
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

}
