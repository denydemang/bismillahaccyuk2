<?php

namespace App\Controllers;

class DashboardKLien extends Dashboard {

    public function index()
    {
        $data = [
            'judul' => 'Dasboard Klien'
        ];
        return view('dashboard/klien', $data);
    }
}
