<?php

namespace App\Controllers;

use App\Models\ModelLogin;

class Login extends BaseController
{
    public function index()
    {

        $data = [
            'judul' => 'Halaman Login',
        ];
        return view('login/index', $data);
    }
    public function cekUser()
    {
        $username = $this->request->getPost('username');
        $pass = $this->request->getPost('password');
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'username' => [
                'label' => 'Username atau Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],

        ]);
        if (!$valid) {
            $sessErr = [
                'errUsername' => $validation->getError('username'),
                'errPassword' => $validation->getError('password')
            ];
            session()->setFlashdata($sessErr);
            return redirect()->to(base_url() . '/login')->withInput();
        } else {
            $modelLogin = new ModelLogin();
            $cekUserLogin = $modelLogin->where('user_name', $username);
            $cekUserLogin = $modelLogin->orWhere('email', $username)->first();
            if ($cekUserLogin == null) {
                $sessErr = [
                    'errUsername' => 'Username/Email Tidak Terdaftar',

                ];
                session()->setFlashdata($sessErr);
                return redirect()->to(base_url() . '/login')->withInput();
            } else {
                $passwordUser = $cekUserLogin['password'];
                if (password_verify($pass, $passwordUser)) {
                    $idlevel = $cekUserLogin['user_level'];
                    $simpan_session = [
                        'user_id' => $cekUserLogin['user_id'],
                        'email' => $cekUserLogin['email'],
                        'username' => $cekUserLogin['user_name'],
                        'nama'  => $cekUserLogin['nama'],
                        'alamat' => $cekUserLogin['alamat'],
                        'notelp' => $cekUserLogin['notelp'],
                        'idlevel' => $idlevel,
                    ];
                    session()->set($simpan_session);
                    return redirect()->to(base_url() . '/dashboard');
                } else {
                    $sessErr = [
                        'errPassword' => 'Password Yang Dimasukkan Salah',

                    ];
                    session()->setFlashdata($sessErr);
                    return redirect()->to(base_url() . '/login')->withInput();
                }
            }
        }
    }
}
