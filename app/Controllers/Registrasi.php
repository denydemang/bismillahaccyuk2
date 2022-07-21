<?php

namespace App\Controllers;

use App\Models\ModelLogin;

class Registrasi extends BaseController
{
    public function index()
    {

        session()->start();
        $data = [
            'judul' => 'Halaman Registrasi',
            'validation' => \Config\Services::validation(),
        ];
        return view('Registrasi/index', $data);
    }
    public function save()
    {
        $modelLogin = new ModelLogin();
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'is_unique[akun.user_name]',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'is_unique[akun.email]',
                'errors' => [
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
        ])) {
            return redirect()->to(base_url() . '/registrasi')->withInput()->with('validation', $validation);
        } else {

            $username = $this->request->getVar('username');
            $nama = $this->request->getVar('nama');
            $email = $this->request->getVar('email');
            $telpon = $this->request->getVar('telpon');
            $alamat = $this->request->getVar('alamat');
            $password = $this->request->getVar('password');
            $passwordacak = password_hash($password, PASSWORD_BCRYPT);


            $modelLogin->save([
                'user_id' => '',
                'email' => $email,
                'user_name' => $username,
                'nama' =>  $nama,
                'notelp' => $telpon,
                'alamat' => $alamat,
                'password' => $passwordacak,
                'user_level' => 2
            ]);
            session()->setFlashdata('pesan', 'Akun Telah Berhasil Dibuat! Silakan Login');
            return redirect()->to(base_url() . '/login');
        }
    }
}
