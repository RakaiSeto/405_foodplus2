<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Donation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller
{

    // public static function middleware() {
    //     return [
    //         new Middleware("auth:sanctum")
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resto = User::where('id', $request->id)->withCount('comments')->withCount('likes')->first();

        $comments = Comment::with('user')->with('transaction')->whereHas('transaction', function ($query) use ($request) {
            $query->leftJoin('donations', 'transactions.donation_id', '=', 'donations.id');
            $query->where('donations.user_id', $request->id);
        })->orderBy('created_at', 'desc')->get();

        $averageRating = round($comments->avg('rating'));

        $donations = Transaction::with('donation')->whereHas('donation', function ($query) use ($request) {
            $query->where('user_id', $request->id);
        })->where('receiver_id', $_COOKIE['user_id'])->get();

        // dd($donations);

        return view('donate.comment.index', compact('resto', 'comments', 'averageRating', 'donations'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "comment" => "string|min:1|required",
            "headline" => "string|min:1|required",
            "rating" => "integer|min:1|max:5|required",
            "transaction_id" => "integer|required"
        ]);
        Comment::create([
            ...$validatedData,
            "user_id" => $_COOKIE['user_id']
        ]);

        return redirect('/resto/comment/' . $request->id);
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
