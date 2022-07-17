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
        $_SESSION['subaktif'] = 'keloladatakun';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/keloladataakun', $data);
    }
    public function keloladataakun()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'keloladataakun';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/keloladataakun', $data);
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
        return view('dashboard/kelolaproyek/belibahanbaku', $data);
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
        return view('dashboard/kelolaproyek/gunakanbahanbaku', $data);
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
        return view('dashboard/kelolaproyek/kelolatenaker', $data);
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
        return view('dashboard/kelolaproyek/transaksibop', $data);
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
        return view('dashboard/kelolaproyek/pembayaranproyek', $data);
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
        return view('dashboard/kelolaproyek/progressproyek', $data);
    }
    public function message()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'message';
        $_SESSION['subaktif'] = '';
        $data = [
            'judul' => 'Dasboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/message', $data);
    }
}
