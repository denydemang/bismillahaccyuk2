<?php

namespace App\Controllers;

class DashboardKLien extends Dashboard
{

    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/klien/welcome', $data);
    }
    public function ajukanproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'ajukan';
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/klien/ajukanproyek', $data);
    }
    public function message()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/klien/message', $data);
    }
}
