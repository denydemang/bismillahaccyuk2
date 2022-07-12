<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Dashboard Admin',
        ];
        return view('dashboard/admin', $data);
    }
    public function klien()
    {
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/klien', $data);
    }
    public function kelolaproyek()
    {
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/kelolaproyek', $data);
    }
}
