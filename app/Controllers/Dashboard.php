<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function index()
    {

        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';
            $judul = 'Admin';
            $data = [
                'judul' => $judul,
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
            ];
            return view('dashboard/klien/welcome', $data);
        };
    }
}
