<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class DonationRequestController extends Controller implements HasMiddleware
{

    public static function middleware() {
        return [
            new Middleware("auth:sanctum", except: ["show", "history"])
        ];
    }

    public function index(Request $request)
    {
        $subscriptions = Subscription::where("receiver_id", $request->user()->id)->where("donor_id", $request->donation)->count();
        $donation = Donation::where("user_id", $request->donation)->with("user")->withCount("likes")->withCount("comments")->get();
        return view("request donasi.request", compact("subscriptions", "donation"));
    }

    public function store(Request $request, Donation $donation)
    {
        $validatedData = $request->validate([
            "quantity" => "integer|min:1|max:{$donation->quantity}"
        ]);
        $newRequest = $request->user()->transactions()->create([
            "quantity" => $validatedData["quantity"],
            "donor_id" => $donation->user_id,
            "donation_id" => $donation->id
        ]);
        $donation->quantity -= $validatedData["quantity"];
        $donation->save();

        return response()->json([
            "status" => "Success",
            "message" => "request created",
            "data" => $newRequest
        ]);
    }

    public function subscribe(Request $request)
    {
        $subscription = Subscription::where("receiver_id", $request->user()->id)->where("donor_id", $request->donation)->count();
        if ($subscription > 0) {
            Subscription::where("receiver_id", $request->user()->id)->where("donor_id", $request->donation)->delete();
        } else {
        Subscription::create([
                "receiver_id" => $request->user()->id,
                "donor_id" => $request->donation
            ]);
        }

        return response()->json([
            "status" => "Success",
            "message" => "subscribe created",
        ]);
    }

    public function history(Request $request)
    {
        $transactions = Transaction::where('receiver_id', $request->user()->id)->get();
        return view("receive.history", compact("transactions"));
    }
}
