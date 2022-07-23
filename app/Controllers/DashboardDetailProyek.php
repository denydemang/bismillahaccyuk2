<?php

namespace App\Controllers;

class DashboardDetailProyek extends Dashboard
{
    public function index()
    {
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $data = [
            'judul' => 'Dasboard Detail Proyek',
            'nama' => $nama,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'username' => $username

        ];
        return view('dashboard/detailproyek/progressproyek', $data);
    }
    public function progressproyek()
    {
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $data = [
            'judul' => 'Dashboard Detail Proyek',
            'nama' => $nama,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'username' => $username
        ];
        return view('dashboard/detailproyek/progressproyek', $data);
    }
    public function pembayaranproyek()
    {
        $username = session()->get('username');
        $nama = session()->get('nama');
        $alamat = session()->get('alamat');
        $notelp = session()->get('notelp');
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'pembayaranproyek';
        $data = [
            'judul' => 'Dashboard Detail Proyek',
            'nama' => $nama,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'username' => $username
        ];
        return view('dashboard/detailproyek/pembayaranproyek', $data);
    }
}
