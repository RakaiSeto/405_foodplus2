<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller 
{
    public function edit(Request $request)
    {
        // Get user from request or API token
        $user = null;
        $bearerToken = $request->bearerToken();
        
        if ($bearerToken) {
            $user = auth('sanctum')->user();
        } else {
            $user = Auth::user();
        }

        $profile = $user ? ($user->profile ?? new Profile()) : new Profile();
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'phone' => 'nullable|string|max:20',
                'address' => 'required|string',
                'password' => 'nullable|string|min:8',
            ]);

            // Update user
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            // Update or create profile
            $profile = Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $validated['phone'],
                    'address' => $validated['address']
                ]
            );

            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }
}
