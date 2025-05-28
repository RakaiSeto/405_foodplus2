<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller implements HasMiddleware
{

    public static function middleware() {
        return [
            new Middleware("auth:sanctum")
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Donation $donation)
    {
        return response()->json([
            "status" => "Success",
            "message" => "Comment for donation {$donation->id} retrieved",
            "data" => $donation->comments()->with("user")->get()
        ]);
   }


    public function store(Request $request, Donation $donation)
    {
        $validatedData = $request->validate([
            "comment" => "string|min:1|required"
        ]);
        $comment = $donation->comments()->create([
            ...$validatedData,
            "user_id" => $request->user()->id,
            "donation_id" => $donation->id
        ]);

        return response()->json([
            "status" => "Success",
            "message" => "Comment created",
            "data" => $comment
        ]);
    }


    public function show(Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
