<?php

namespace App\Service;

use App\Models\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }

    public function getById($userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    public function isHashValid(int $userId, string $hash): bool
    {
        $user = $this->getById($userId);

        if ($user && md5($user->email . config('app.key')) == $hash) {
            $this->userRepository->markAsVerified($userId);

            return true;
        }

        return false;
    }
}
