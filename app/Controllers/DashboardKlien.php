<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ProgressProyekModel;

class DashboardKLien extends Dashboard
{

    public function __construct()
    {
        parent::__construct();

        $this->datalogin['judul'] = 'Dashboard Klien';
    }
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';
        return view('dashboard/klien/welcome', $this->datalogin);
    }
    public function ajuanproyek()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'ajuanproyek';
        return view('dashboard/klien/pengajuanproyek', $this->datalogin);
    }
    public function progressproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $progressproyek = new ProgressProyekModel();
        $user_id = $this->user_id;
        $dataprogress = $progressproyek->where('user_id', $user_id)->find();
        $this->datalogin += [
            'dataprogress' => $dataprogress,
        ];

        return view('dashboard/klien/progressproyek', $this->datalogin);
    }
    public function message()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';

        return view('dashboard/klien/message', $this->datalogin);
    }

    //FUnction Query
    public function simpanajuanproyek()
    {
        $user_id = $this->request->getVar('user_id');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $lokasiproyek = $this->request->getVar('lokasiproyek');
        $catatan = $this->request->getVar('catatan');
        $idajuan = $this->kodeotomatis('pengajuan_proyek', 'idajuan', 'AJP001');
        $AjuanProyekModel = new AjuanProyekModel();
        $AjuanProyekModel->insert([
            'idajuan' => $idajuan,
            'user_id' => $user_id,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'lokasiproyek' => $lokasiproyek,
            'catatanproyek' => $catatan,
            'status_id' => '1'


        ]);
        session()->setFlashdata('pesan', 'berhasildiajukan');
        return redirect()->to(base_url('/klien'));
    }
}
