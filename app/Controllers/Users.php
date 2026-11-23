<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna & Petugas',
            'users' => $this->userModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Alamat email ini sudah digunakan oleh pengguna lain.',
            ],
            'password' => [
                'min_length' => 'Password minimal 6 karakter.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to('/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'password' => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // Jika password diisi, update password baru
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);

        // Jika mengedit akun yang sedang login, update juga session namanya
        if ($id == session()->get('id')) {
            session()->set('name', $updateData['name']);
            session()->set('email', $updateData['email']);
        }

        return redirect()->to('/pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Mencegah menghapus akun sendiri
        if ($id == session()->get('id')) {
            return redirect()->to('/pengguna')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan untuk login.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/pengguna')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
