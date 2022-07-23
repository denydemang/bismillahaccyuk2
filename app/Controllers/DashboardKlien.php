<?php

namespace App\Controllers;

class DashboardKLien extends Dashboard
{

    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        $_SESSION['aktif'] = 'home';
        $data = [
            'judul' => 'Dasboard Klien',
            'nama' => $nama,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'username' => $username
        ];
        return view('dashboard/klien/welcome', $data);
    }

    public function message()
    {
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
        $data = [
            'judul' => 'Dasboard Klien',
            'nama' => $nama,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'username' => $username
        ];
        return view('dashboard/klien/message', $data);
    }
}
