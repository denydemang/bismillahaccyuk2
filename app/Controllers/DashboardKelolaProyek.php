<?php

namespace App\Controllers;

class DashboardKelolaProyek extends Dashboard
{
    private $idproyek;
    public function __construct()
    {
        parent::__construct();
        $this->idproyek = session()->get('idproyek');
        $this->datalogin += [
            'idproyek' => $this->idproyek,
        ];
    }
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        }
        $_SESSION['aktif'] = 'bahanbaku';
        $_SESSION['subaktif'] = 'keloladatabahanbaku';
        $data = [
            'judul' => 'Dashboard Kelola Proyek'
        ];
        return view('dashboard/kelolaproyek/keloladatabahanbaku', $this->datalogin);
    }
    function brake()
    {
        session()->destroy();
    }
}
