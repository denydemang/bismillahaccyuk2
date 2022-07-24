<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    private $nama,
        $alamat,
        $notelp,
        $username;
    public function __construct()
    {
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {

        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';
            $judul = 'Dashboard Admin';
            $data = [
                'judul' => $judul,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'notelp' => $this->notelp,
                'username' => $this->username
            ];
            return view('dashboard/admin/welcome', $data);
        } else {
            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            }
            $_SESSION['aktif'] = 'home';
            $data = [
                'judul' => 'Dasboard Klien'
            ];
            $judul = 'Dashboard Klien';
            $data = [
                'judul' => $judul,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'notelp' => $this->notelp,
                'username' => $this->username
            ];
            return view('dashboard/klien/welcome', $data);
        };
    }
}
