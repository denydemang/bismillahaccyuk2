<?php

namespace App\Controllers;

class DashboardDetailProyek extends Dashboard
{
    public function __construct()
    {
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $data = [
            'judul' => 'Dasboard Detail Proyek',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username

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
            'judul' => 'Dashboard Detail Proyek',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username
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
            'judul' => 'Dashboard Detail Proyek',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username
        ];
        return view('dashboard/detailproyek/pembayaranproyek', $data);
    }
}
