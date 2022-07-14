<?php

namespace App\Controllers;

class DashboardKelolaProyek extends Dashboard
{
    public function index()
    {
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek', $data);
    }
}
