<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Notification as ModelsNotification;
use App\Models\User;
use App\Notifications\DonationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\Like;
use App\Models\Comment;

class DonationController extends Controller implements HasMiddleware
{
    //

    public static function middleware()
    {
        return [
            new Middleware("auth:sanctum", except: ["index", "show", "getDonation", "dashboard", "getAllResto"])
        ];
    }

    public function dashboard(Request $request)
    {
        dd(Auth::user());
        $donations = Donation::where("user_id", $request->user()->id)->with("user")->withCount("likes")->withCount("comments")->get();

        return view("donate.dashboard", ["donations" => $donations]);
    }

    public function index(Request $request)
    {
        $donations = Donation::with("user")->withCount("likes")->withCount("comments")->get();

        return response()->json([
            "status" => "Success",
            "message" => "Donations retrieved",
            "data" => $donations
        ]);
    }


    public function getDonation(Request $request)
    {
        $donations = Donation::where("user_id", $request->resto)->with("user")->get();
        $donations->map(function ($donation) {
            $commentCount = Comment::whereHas('transaction', function ($query) use ($donation) {
                $query->leftJoin('donations', 'transactions.donation_id', '=', 'donations.id');
                $query->where('donations.user_id', $donation->user_id);
            })->count();

            $likeCount = Like::whereHas('donation', function ($query) use ($donation) {
                $query->where('user_id', $donation->user_id);
            })->count();

            $donation->likes_count = $likeCount;
            $donation->comments_count = $commentCount;
            return $donation;
        });

        return response()->json([
            "status" => "Success",
            "message" => "Donations retrieved",
            "data" => $donations
        ]);
    }

    public function getAllResto(Request $request)
    {
        $restos = User::where("role", "penyedia")->withCount("likes")->withCount("comments")->get();
        $restos->map(function ($resto) {
            $likeCount = Like::whereHas('donation', function ($query) use ($resto) {
                $query->where('user_id', $resto->id);
            })->count();
            $commentCount = Comment::whereHas('transaction', function ($query) use ($resto) {
                $query->leftJoin('donations', 'transactions.donation_id', '=', 'donations.id');
                $query->where('donations.user_id', $resto->id);
            })->count();
            $resto->likes_count = $likeCount;
            $resto->comments_count = $commentCount;
            return $resto;
        });
        return response()->json([
            "status" => "Success",
            "message" => "Restos retrieved",
            "data" => $restos
        ]);
    }

    public function getDonationsByResto(Request $request)
    {
        $donations = Donation::where("user_id", $request->user()->id)->with("user")->withCount("likes")->get();
        $donations->map(function ($donation) {
            $donation->comments_count = Comment::whereHas('transaction', function ($query) use ($donation) {
                $query->leftJoin('donations', 'transactions.donation_id', '=', 'donations.id');
                $query->where('donations.user_id', $donation->user_id);
            })->count();
            return $donation;
        });

        return response()->json([
            "status" => "Success",
            "message" => "Donations from this restaurant retrieved",
            "data" => $donations
        ]);
    }

    public function store(Request $request)
    {
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

        $subscribers = User::whereHas('subscriptions', function ($query) {
            $query->where('donor_id', $_COOKIE['user_id']);
        })->get();

        $this->sendNotification($subscribers, $donation);

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

    public function sendNotification($subscribers, $donation)
    {
        foreach ($subscribers as $subscriber) {
            ModelsNotification::create([
                "type" => "Donasi Baru",
                "data" => 'Donasi ' . $donation->food_name . ' baru dari ' . $donation->user->name,
                "notifiable_id" => $subscriber->id,
                "notifiable_type" => "Subscription"
            ]);
        }
    }
}
