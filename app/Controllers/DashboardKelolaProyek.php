<?php

namespace App\Controllers;

class DashboardKelolaProyek extends Dashboard
{
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'keloladatabahanbaku';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/keloladatabahanbaku', $this->datalogin);
    }
    public function keloladatabahanbaku()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'keloladatabahanbaku';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/keloladatabahanbaku', $this->datalogin);
    }
    public function kelolajenisbahanbaku()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'kelolajenisbahanbaku';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/kelolajenisbahanbaku', $this->datalogin);
    }
    public function belibahanbaku()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'belibahanbaku';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/belibahanbaku', $this->datalogin);
    }
    public function gunakanbahanbaku()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'gunakanbahanbaku';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/gunakanbahanbaku', $this->datalogin);
    }
    public function kelolatenaker()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'tenaker';
        $_SESSION['subaktif'] = 'kelolatenaker';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/kelolatenaker', $this->datalogin);
    }
    public function transaksibop()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'transaksibop';
        $_SESSION['subaktif'] = '';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/transaksibop', $this->datalogin);
    }
    public function pembayaranproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'pembayaranproyek';
        $_SESSION['subaktif'] = '';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/pembayaranproyek', $this->datalogin);
    }
    public function progressproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $_SESSION['subaktif'] = '';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/progressproyek', $this->datalogin);
    }
}
