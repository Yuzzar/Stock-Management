<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AuthService;

class Auth extends BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function loginPost()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (! $this->authService->attempt($username, $password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali!');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
