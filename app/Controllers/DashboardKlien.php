<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;

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
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $alamat = $this->request->getVar('alamat');
        $notelp = $this->request->getVar('notelp');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $lokasiproyek = $this->request->getVar('lokasiproyek');
        $catatan = $this->request->getVar('catatan');

        $AjuanProyekModel = new AjuanProyekModel();
        $AjuanProyekModel->save([
            'idajuan' => '',
            'user_id' => $user_id,
            'nama' => $nama,
            'email' => $email,
            'alamat' => $alamat,
            'notelp' => $notelp,
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
