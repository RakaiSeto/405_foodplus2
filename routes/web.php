<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AuthController;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\CommentController;

// Redirect halaman awal ke dashboard guest
Route::get('/', function () {
    return redirect('/guest/dashboard');
});

// Route untuk dashboard guest
Route::get('/guest/dashboard', function () {
    return view('guest.dashboard');
})->name('dashboard.guest');

// Route untuk autentikasi
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Tambahkan route POST untuk register dengan redirect berdasarkan role
Route::post('/register', function (Request $request) {
    $controller = new AuthController();
    $response = $controller->register($request);

    // Jika response berhasil, redirect berdasarkan role
    if ($response->getStatusCode() === 201) {
        // Ambil data user dari response
        $responseData = json_decode($response->getContent());
        $userData = $responseData->data;

        // Login user secara manual dengan email
        $user = User::where('email', $request->email)->first();
        if ($user) {
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'penyedia') {
                return redirect()->route('dashboard.donate');
            } else {
                return redirect()->route('dashboard.receive');
            }
        }
    }

    // Jika gagal, kembalikan response dari controller
    return $response;
})->name('register.submit');

// Route untuk autentikasi login dengan redirect berdasarkan role
// Route::post('/login', function (Request $request) {
//     $controller = new AuthController();
//     $response = $controller->login($request);

//     // Jika response berhasil, redirect berdasarkan role
//     if ($response->getStatusCode() === 200) {
//         // Ambil token dari response
//         $responseData = json_decode($response->getContent());
//         $token = $responseData->data->accessToken ?? null;

//         if ($token) {
//             // Login user dengan token menggunakan email
//             $user = User::where('email', $request->email)->first();
//             if ($user) {
//                 Auth::login($user);

//                 // Redirect berdasarkan role
//                 if ($user->role === 'penyedia') {
//                     return redirect()->route('dashboard.donate')->with("accessToken", $token);
//                 } else {
//                     return redirect()->route('dashboard.receive')->with ("accessToken", $token);
//                 }
//             }
//         }
//     }

//     // Jika gagal, kembalikan response dari controller
//     return $response;
// })->name('login.submit');

// MIDDLEWARE
// Route untuk dashboard donatur (yang sudah login)
    // Dashboard donatur
    Route::get('/donate/dashboard', function () {
        return view('donate.dashboard');
    })->name('dashboard.donate');

    // Dashboard penerima
    Route::get('/receive/dashboard', function () {
        return view('receive.dashboard');
    })->name('dashboard.receive');

    // Dashboard user (general)
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard.user');

    // Dashboard admin
    Route::get("/admin/dashboard", function () {
        return view("Admin.dashboard");
    })->name("dashboard.admin");

    // Route untuk donasi
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', function () {
        return view('donate.create');
    })->name('donations.create');
    // Add the alias route with the donate.create name
    Route::get('/donate/create', function () {
        return view('donate.create');
    })->name('donate.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}', function (Donation $donation) {
        return view("donate.show", ["donation" => $donation]);
    })->name('donations.show');

    // Perbaikan route edit yang bermasalah
    Route::get('/donations/{donation}/edit', function (Donation $donation) {
        return view('donate.edit', ["donation" => $donation]);
    })->name('donations.edit');

    // MIDDLEWARE


    Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');

    // Route untuk logout
    Route::post('/logout', function (Request $request) {
        // Instead of calling controller method, handle logout directly
        Auth::guard('web')->logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman guest setelah logout
        return redirect()->route('dashboard.guest');
    })->name('logout');

// Route untuk manajemen donasi (guest)
Route::get('/guest/manajemendonasi', function () {
    $donations = \App\Models\Donation::all();
    return view('guest.manajemendonasi', ['donations' => $donations]);
})->name('guest.manajemendonasi');

Route::get('/resto/comment/{id}', [CommentController::class, 'index'])->name('donate.comment');
Route::post('/resto/{id}/comment/store', [CommentController::class, 'store'])->name('donate.comment.store');

// Routes untuk penerima donasi
// Route::middleware(['auth:sanctum', 'role:penerima'])->group(function () {
//     Route::get('/receiver/dashboard', [App\Http\Controllers\DonationRequestController::class, 'dashboard'])->name('receiver.dashboard');
//     Route::get('/receiver/request/{restoId}', [App\Http\Controllers\DonationRequestController::class, 'showRequestForm'])->name('receiver.request');
//     Route::get('/receiver/requests', [App\Http\Controllers\DonationRequestController::class, 'myRequests'])->name('receiver.requests');
//     Route::get('/receiver/history', [App\Http\Controllers\DonationRequestController::class, 'history'])->name('receiver.history');
//     Route::post('/receiver/request', [App\Http\Controllers\DonationRequestController::class, 'store'])->name('donation.request');
// });
Route::get('/receiver/request/{restoId}', function () {
    return view("request donasi.request");
})->name('receiver.request');




// API routes
Route::prefix('api')->group(function () {
    Route::get('/donations/available', [App\Http\Controllers\DonationRequestController::class, 'getAvailableDonations']);
});

// ... existing code ...
