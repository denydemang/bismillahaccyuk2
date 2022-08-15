<?php

namespace App\Controllers;

use App\Models\ModelLogin;

class Registrasi extends BaseController
{
    public function index()
    {

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
            $namaperusahaan = $this->request->getVar('namaperusahaan');
            $email = $this->request->getVar('email');
            $telpon = $this->request->getVar('telpon');
            $alamat = $this->request->getVar('alamat');
            $alamatperusahaan = $this->request->getVar('alamatperusahaan');
            $jabatan = $this->request->getVar('jabatan');
            $password = $this->request->getVar('password');
            $passwordacak = password_hash($password, PASSWORD_BCRYPT);

            $user_id = $this->kodeotomatis('akun', 'user_id', 'USR001');

            $modelLogin->insert([
                'user_id' => $user_id,
                'email' => $email,
                'user_name' => $username,
                'nama' =>  $nama,
                'namaperusahaan' => $namaperusahaan,
                'notelp' => $telpon,
                'alamat' => $alamat,
                'alamatperusahaan' => $alamatperusahaan,
                'jabatan' => $jabatan,
                'password' => $passwordacak,
                'user_level' => 2
            ]);
            //jangan menggunan method save jika field primary key bukan auto increment 
            //mending gunakan insert nanti data tidak akan masuk ke database
            // $modelLogin->save([
            //     'user_id' => '',
            //     'email' => $email,
            //     'user_name' => $username,
            //     'nama' =>  $nama,
            //     'notelp' => $telpon,
            //     'alamat' => $alamat,
            //     'password' => $passwordacak,
            //     'user_level' => 2
            // ]);

            //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
            //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
            // $builder = $modelLogin->builder();
            // $builder->db()->affectedRows();
            session()->setFlashdata('pesan', 'Akun Telah Berhasil Dibuat! Silakan Login');
            return redirect()->to(base_url() . '/login');
        }
    }
}
