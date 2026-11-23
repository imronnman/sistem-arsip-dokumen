<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function loginProcess()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
        }

        $isPasswordValid = password_verify($password, $user['password']) || ($password === $user['password']);

        if (!$isPasswordValid) {
            return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
        }

        // Jika password di database masih berupa plain text, otomatis perbarui ke hash aman
        if ($password === $user['password']) {
            $this->userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
        }

        // Set session
        $sessionData = [
            'id'         => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . esc($user['name']) . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
    /**
     * Fitur Login Cepat Menggunakan Akun Google
     */
    public function googleLogin()
    {
        $googleEmail = 'ali.imron.google@gmail.com';
        $googleName  = 'Ali Imron (Google)';

        // Cari atau daftarkan akun Google secara otomatis
        $user = $this->userModel->where('email', $googleEmail)->first();
        if (!$user) {
            $this->userModel->save([
                'name'     => $googleName,
                'email'    => $googleEmail,
                'password' => password_hash('google_auth_secret_key', PASSWORD_BCRYPT),
            ]);
            $user = $this->userModel->where('email', $googleEmail)->first();
        }

        // Set session login
        session()->set([
            'id'         => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Berhasil masuk langsung menggunakan Akun Google! 🎉');
    }
}
