<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function attempt(string $username, string $password): bool
    {
        $user = $this->userModel->findByUsername($username);

        if (! $user) {
            return false;
        }

        if (! password_verify($password, $user['password'])) {
            return false;
        }

        $this->createSession($user);

        return true;
    }

    public function logout(): void
    {
        session()->destroy();
    }

    private function createSession(array $user): void
    {
        session()->set([
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'user_name'    => $user['name'],
            'user_email'   => $user['email'],
            'user_role'    => $user['role'],
        ]);
    }
}
