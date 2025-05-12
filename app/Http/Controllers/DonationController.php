<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class DonationController extends Controller implements HasMiddleware
{
    //

    public static function middleware() {
        return [
            new Middleware("auth:sanctum", except: ["index", "show"])
        ];
    }

    public function index() {
        $donations = Donation::all();

        return response()->json([
            "status" => "Success",
            "message" => "Donations retrieved",
            "data" => $donations
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            "food_name" => "string|required",
            "quantity" => "integer|required",
            "location" => "string|required",
            "category" => "string|required"
        ]);

        if(!Gate::allows("insert-donation")) {
            abort(403, "Dont have access to this resource");
        };

        $donation = Donation::create([
            ...$validatedData,
            "user_id" => $request->user()->id
        ]);
        return redirect()->route("dashboard.donate");

        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Data inserted",
        //     "data" => $donation
        // ]);
    }

    public function show(Request $request, Donation $donation) {
        // return view("donate.show", ["donation" => $donation]);
        return response()->json([
            "status" => "Success",
            "message" => "Donation retrieved",
            "data" => $donation
        ]);
    }

    public function update(Request $request, $id) {
        $donation = Donation::findOrFail($id);

        // Memeriksa apakah pengguna memiliki akses untuk memperbarui donasi ini
        if (!Gate::allows('update-donation', $donation)) {
            abort(403, "Tidak memiliki akses untuk memperbarui donasi ini");
        }

        $validatedData = $request->validate([
            "food_name" => "string|sometimes",
            "quantity" => "integer|sometimes",
            "location" => "string|sometimes",
            "category" => "string|sometimes"
        ]);

        $donation->update($validatedData);

        return redirect()->route("dashboard.donate");
        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Donasi berhasil diperbarui",
        //     "data" => $donation
        // ]);
    }

    public function edit(User $user, Donation $donation) {
        return view("donate.edit", ["donation" => $donation]);
    }

    public function destroy(Donation $donation) {
        $donation->delete();

        return redirect()->route("dashboard.donate");
        // return response()->json([
        //     "status" => "Success",
        //     "message" => "Donation deleted",
        //     "data" => $donation
        // ]);
    }
}
