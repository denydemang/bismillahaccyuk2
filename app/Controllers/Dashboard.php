<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function index()
    {
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';
            $judul = 'Admin';
            $data = [
                'judul' => $judul,
                'nama' => $nama,
                'alamat' => $alamat,
                'notelp' => $notelp,
                'username' => $username
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
            $judul = 'Klien';
            $data = [
                'judul' => $judul,
                'nama' => $nama,
                'alamat' => $alamat,
                'notelp' => $notelp,
                'username' => $username
            ];
            return view('dashboard/klien/welcome', $data);
        };
    }
}
