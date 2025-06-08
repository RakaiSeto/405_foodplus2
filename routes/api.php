<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("donations/{resto}", [DonationController::class, "getDonation"]);
Route::get("donations", [DonationController::class, "index"]);
Route::post("donations", [DonationController::class, "store"]);
Route::post("donations/{donation}/requests", [DonationRequestController::class, "store"]);
Route::get("donations/{donation}/subscribe", [DonationRequestController::class, "subscribe"]);
Route::get("subscriptions/{donation}", [SubscriptionController::class, "index"]);
Route::apiResource("notifications", NotificationController::class);
Route::post("notifications/read-all", [NotificationController::class, "readAll"]);
Route::apiResource("donations.comments", CommentController::class);
Route::get("donations/{donation}/likes", [LikeController::class, "index"]);

Route::post("/auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
Route::get("/donations/resto/all", [DonationController::class, "getDonationsByResto"]);
Route::get("/restos/all", [DonationController::class, "getAllResto"]);


// Dashboard Statistic
Route::get("/statistics/receiver/dashboard/summary", [StatisticController::class, "getReceiverStatisticDashboard"]);
Route::get("/statistics/restorants/{resto}/donations/comments", [StatisticController::class, "getCountCommentsBelongToResto"]);
Route::get("/statistics/restorants/{resto}/donations/likes", [StatisticController::class, "getCountLikedBelongToResto"]);
