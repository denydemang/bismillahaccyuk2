<?php

namespace App\Controllers;

class DashboardDetailProyek extends Dashboard
{
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $data = [
            'judul' => 'Dasboard Detail Proyek'
        ];
        return view('dashboard/detailproyek/progressproyek', $data);
    }
    public function progressproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $data = [
            'judul' => 'Dashboard Detail Proyek'
        ];
        return view('dashboard/detailproyek/progressproyek', $data);
    }
    public function pembayaranproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'pembayaranproyek';
        $data = [
            'judul' => 'Dashboard Detail Proyek'
        ];
        return view('dashboard/detailproyek/pembayaranproyek', $data);
    }
}
