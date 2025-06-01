<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use App\Notifications\DonationNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller implements HasMiddleware
{
    //

    public static function middleware()
    {
        return [
            new Middleware("auth:sanctum", except: ["index", "show"])
        ];
    }

    public function index()
    {
        $donations = Donation::with("user")->get();

        return response()->json([
            "status" => "Success",
            "message" => "Donations retrieved",
            "data" => $donations
        ]);
    }

    public function getDonationsByResto(Request $request)
    {
        $donations = Donation::where("user_id", $request->user()->id)->get();

        return response()->json([
            "status" => "Success",
            "message" => "Donations from this restaurant retrieved",
            "data" => $donations
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());


        $validatedData = $request->validate([
            "food_name" => "string|required",
            "quantity" => "integer|required",
            "location" => "string|required",
            "category" => "string|required",
            "image" => "image|mimes:jpeg,jpg,png|max:4096|nullable"
        ]);
        if ($request->hasFile("image")) {
            $validatedData["image_url"] = $request->file("image")->store("donation-images", "public");
        }

        if (!Gate::allows("insert-donation")) {
            return response()->json([
                "status" => "Error",
                "message" => "Dont have access to this resource"
            ], 403);
        };

        $donation = Donation::create([
            ...$validatedData,
            "user_id" => $request->user()->id
        ]);

        $subscribers = User::whereHas('subscriptions', function ($query) use ($request) {
            $query->where('donor_id', $request->user()->id);
        })->get();

        Notification::send($subscribers, new DonationNotification($donation, $request->user()));

        return response()->json([
            "status" => "Success",
            "message" => "Data inserted",
            "data" => $donation
        ]);

        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Data inserted",
        //     "data" => $donation
        // ]);
    }

    public function show(Request $request, Donation $donation)
    {
        // return view("donate.show", ["donation" => $donation]);
        return response()->json([
            "status" => "Success",
            "message" => "Donation retrieved",
            "data" => $donation
        ]);
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        // Memeriksa apakah pengguna memiliki akses untuk memperbarui donasi ini
        if (!Gate::allows('update-donation', $donation)) {
            abort(403, "Tidak memiliki akses untuk memperbarui donasi ini");
        }

        $validatedData = $request->validate([
            "food_name" => "string|sometimes",
            "quantity" => "integer|sometimes",
            "location" => "string|sometimes",
            "category" => "string|sometimes",
            "image" => "image|nullable|mimes:jpg,jpeg,png|max:4096"
        ]);

        if ($request->hasFile("image")) {
            if ($donation->image_url && Storage::disk("public")->exists($donation->image_url)) {
                Storage::disk("public")->delete($donation->image_url);
            }
            $validatedData["image_url"] = $request->file("image")->store("donation-images", "public");
        }

        $donation->update($validatedData);

        return redirect()->route("dashboard.donate");
        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Donasi berhasil diperbarui",
        //     "data" => $donation
        // ]);
    }

    public function edit(User $user, Donation $donation)
    {
        return view("donate.edit", ["donation" => $donation]);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route("dashboard.donate");
        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Donation deleted",
        //     "data" => $donation
        // ]);
    }
}
