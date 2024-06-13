<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function find(int $userId): ?User
    {
        return User::find($userId);
    }

    public function markAsVerified(int $userId): void
    {
        User::where('id', $userId)->update(['email_verified_at' => now()]);
    }
}
