<?php

namespace App\Service;

use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            if (!Auth::user()->email_verified_at) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'You need to verify your email first.');
            }
            session()->put('last_activity', now());
            session()->put('apiToken', Auth::user()->createToken('api')->plainTextToken);

            return redirect()->route('posts.index');
        }

        return redirect()->back()->with('error', 'Invalid login credentials.');

    }

    public function register(array $data): ?User
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'email_verified_at' => null
            ]);

        } catch (\Throwable $e) {
            Log::critical('[AUTH REGISTRATION] error:' . $e->getMessage());

            return null;
        }

        $url = route('verification.verify', [
            'id' => $user->id,
            'hash' => md5($user->email . config('app.key'))
        ]);
        Mail::to($user->email)->send(new VerifyMail($user, $url));

        return $user;
    }
}
