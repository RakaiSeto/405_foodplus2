<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function getCountCommentsBelongToResto(Request $request, $restoId) {
        $user = User::findOrFail($restoId);
        $userWithDonationCommentCount = $user->donations()->withCount("comments")->get();
        $countComment  = $userWithDonationCommentCount->sum("comments_count");

        return response()->json([
            "status" => "Success",
            "message" => "Comment for resto {$restoId} is counted",
            "data" => [
                "user" => $userWithDonationCommentCount,
                "totalComment" => $countComment
            ]
        ]);
    }

}
