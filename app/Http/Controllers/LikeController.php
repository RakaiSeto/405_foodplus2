<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LikeController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware("auth:sanctum")
        ];
    }

    public function index(Donation $donation)
    {
        return response()->json([
            "status" => "Success",
            "message" => "Donation liked retrieved",
            "data"
        ]);
    }


    public function store(Donation $donation, Request $request)
    {
        //
        if($request->user()->role === "penyedia" && $donation->user_id === $request->user()->id){
            return response()->json([
                "status" => "Fail",
                "message" => "Resto cannot like donation owned by itself",
            ])->setStatusCode(400);
        }
                $isAlreadyLiked = $donation->likes()->where("user_id", $request->user()->id)->exists();
        if($isAlreadyLiked) {
            return response()->json([
                "status" => "Fail",
                "message" => "Already liked this donation",
            ])->setStatusCode(400);
        }
        $donation->likes()->create([
            "user_id" => $request->user()->id,
            "donation_id" => $donation->id
        ]);
        return response()->json([
            "status" => "Success",
            "message" => "Donation liked",
        ]);
    }

    public function destroy(Donation $donation, Like $like)
    {
        //
        $like->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Donation Unliked",
        ]);
    }
}
