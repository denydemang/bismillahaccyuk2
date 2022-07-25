<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    protected $user_id,
        $nama,
        $alamat,
        $notelp,
        $username,
        $db,
        $jumlahdataakun,
        $datalogin;
    public function __construct()

    {

        $this->db = \Config\Database::connect();

        //query builder untuk mendapatkan jumlah baris data di tabel akun
        $builder = $this->db->table('akun');
        $builder->selectCount('user_id');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahdataakun = $getjumlahdata[0]->user_id;
        // end query builder untuk mendapatkan jumlah baris data di tabel akun

        //menginput data user yang login
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
        $this->user_id = session()->get('user_id');
        //masukkan ke variable data login admin
        $this->datalogin = [
            'judul' => '',
            'user_id' => $this->user_id,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,

        ];
    }
    public function index()
    {

        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';

            $this->datalogin['judul'] = 'Dashboard Admin';
            $this->datalogin += [
                'jumlahdataakun' => $this->jumlahdataakun,
            ];

            return view('dashboard/admin/welcome', $this->datalogin);
        } else {
            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            }
            $_SESSION['aktif'] = 'home';
            $this->datalogin['judul'] = 'Dashboard Klien';
            return view('dashboard/klien/welcome', $this->datalogin);
        };
    }
}
