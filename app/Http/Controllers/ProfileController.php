<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!isset($_COOKIE['user_id'])) {
            return redirect('/login');
        } else {
            $user = User::find($_COOKIE['user_id']);
            $batalUrl = '';
            switch ($user->role) {
                case 'penerima':
                    $batalUrl = '/receive/dashboard';
                    break;
                case 'penyedia':
                    $batalUrl = '/donate/dashboard';
                    break;
                case 'admin':
                    $batalUrl = '/admin/dashboard';
                    break;
            }

            $userJson = json_encode($user);

            return view('profile', compact('user', 'batalUrl', 'userJson'));
        }
    }

    public function update(Request $request)
    {
        $user = User::find($_COOKIE['user_id']);
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->password != '') {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect('/profile')->with('success', 'Profile berhasil diubah');
    }
}
