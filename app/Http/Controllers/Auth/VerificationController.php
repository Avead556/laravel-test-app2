<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function verify($userId, $hash): RedirectResponse
    {
        $isValid = $this->userService->isHashValid($userId, $hash);

        if ($isValid) {
            return redirect()->route('login')->with('success', 'Your email has been verified. You can now login.');
        }

        return redirect()->route('register')->with('error', 'Invalid verification link.');
    }
}
