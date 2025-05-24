<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class SubscriptionController extends Controller implements HasMiddleware
{

    public static function middleware() {
        return [
            new Middleware("auth:sanctum")
        ];
    }
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            "donor_id" => "integer|required"
        ]);
        $userToSubscribe = User::findOrFail($validatedData["donor_id"]);
        abort_if(!Gate::allows("subscription", $userToSubscribe), 400, "Cannot subscribe to this user");
        $subscription = $request->user()->subscriptions()->create([
            ...$validatedData,
            "receiver_id" > $request->user()->id
        ]);

        return response()->json([
            "status" => "Success",
            "message" => "User subscribed",
            "data" =>$subscription
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $isSubscribeExists = $request->user()->subscriptions()->where("id", $id)->exists();
        abort_if(!$isSubscribeExists, 404, "User not subscribe to this resto or there is no subscribe_id " . $id);
        $request->user()->subscriptions()->where("id", $id)->delete();

        return response()->json([
            "status" => "Success",
            "message" => "User Unsubscribed",
        ]);
    }
}
