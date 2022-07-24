<?php

namespace App\Controllers;

class DashboardKLien extends Dashboard
{
    public function __construct()
    {
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';
        $data = [
            'judul' => 'Dasboard Klien',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username
        ];
        return view('dashboard/klien/welcome', $data);
    }

    public function message()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
        $data = [
            'judul' => 'Dasboard Klien',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username
        ];
        return view('dashboard/klien/message', $data);
    }
}
