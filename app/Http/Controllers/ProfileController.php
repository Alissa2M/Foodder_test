<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;


class ProfileController extends Controller
{
    public function index(User $user,Request $request)
    {
        $users = User::where('id',$request->id)->get();
        return Inertia::render('Profile/GuestProfile',[
            'users' => $users,
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $current_password = $request->password;
        if($current_password !== null){
            $validated = $request->validate([
                'current_password' => ['required','current_password'],
                'password' => ['required',Password::defaults(), 'confirmed'],
            ]);

            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        if($request->file('user_header')){
            $request->validate([
                'user_header' => 'max:3000|mimes:jpg,jpeg,png,gif,webp',
            ]);    
            $file_name = $request->file('user_header')->getClientOriginalName();
            $file_path = $request->file('user_header')->storeAs('public', $file_name);
            $user_header = '/storage' . '/' . $file_name;
            $request->user()->update([
                'user_header' => $user_header,
            ]);
        }

        if($request->file('user_icon')){
            $request->validate([
                'user_icon' => 'max:3000|mimes:jpg,jpeg,png,gif,webp'
            ]);    
            $file_name = $request->file('user_icon')->getClientOriginalName();
            $file_path = $request->file('user_icon')->storeAs('public', $file_name);
            $user_icon = '/storage' . '/' . $file_name;
            $request->user()->update([
                'user_icon' => $user_icon,
            ]);
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
