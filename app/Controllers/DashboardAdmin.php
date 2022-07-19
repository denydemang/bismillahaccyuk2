<?php

namespace App\Controllers;

class DashboardAdmin extends Dashboard
{
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $data = [
            'judul' => 'Dashboard Admin',

        ];
        return view('dashboard/index', $data);
    }
    public function ajuanproyek()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'ajuan';

        $data = [
            'judul' => 'Dashboard Admin',

        ];
        return view('dashboard/admin/ajuanproyek', $data);
    }
    public function dataklien()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataklien';
        $data = [
            'judul' => 'Dashboard Admin',
        ];
        return view('dashboard/admin/dataklien', $data);
    }
    public function dataproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
        $data = [
            'judul' => 'Dashboard Admin',
        ];
        return view('dashboard/admin/dataproyek', $data);
    }
    public function message()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';
        $data = [
            'judul' => 'Dashboard Admin',
        ];
        return view('dashboard/admin/message', $data);
    }
}
