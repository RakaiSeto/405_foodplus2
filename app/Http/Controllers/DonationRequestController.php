<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Models\Donation;
use App\Models\Transaction;
use Illuminate\Auth\Access\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class DonationRequestController extends Controller implements HasMiddleware
{

    public static function middleware() {
        return [
            new Middleware("auth:sanctum", except: ["index", "show"])
        ];
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

        return response()->json([
            "status" => "Success",
            "message" => "request created",
            "data" => $newRequest
        ]);
    }
}
