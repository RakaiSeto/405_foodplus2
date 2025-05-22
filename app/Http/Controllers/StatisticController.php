<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;

class StatisticController extends Controller
{
    //
    public function getReceiverStatisticDashboard () {
        $totalResto =  User::getTotalCount("role", "penyedia");
        $totalReceiver =  User::getTotalCount("role", "penerima");
        $totalDonation = Donation::count();
        $todayDonation = Donation::whereDate("created_at",Carbon::today())->sum("quantity");

        return response()->json([
            "status" => "Success",
            "message" => "Statistic summary received",
            "data" => [
                "total_resto" => $totalResto,
                "total_receiver" => $totalReceiver,
                "total_donation" => $totalDonation,
                "today_donation" => $todayDonation
            ]
            ]);
    }

}
