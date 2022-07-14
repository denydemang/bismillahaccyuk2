<?php

namespace App\Controllers;

class DashboardAdmin extends Dashboard
{
    public function index()
    {
        $data = [
            'judul' => 'Dashboard Admin',
        ];
        return view('dashboard/admin', $data);
    }
}
