<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    private $nama,
        $alamat,
        $notelp,
        $username,
        $db,
        $jumlahdataakun;
    public function __construct()

    {
        $this->db = \Config\Database::connect();
        $builder = $this->db->table('akun');

        //query builder untuk mendapatkan jumlah baris di tabel
        $builder->selectCount('user_id');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahdataakun = $getjumlahdata[0]->user_id;
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {


        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';
            $judul = 'Dashboard Admin';
            $data = [
                'judul' => $judul,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'notelp' => $this->notelp,
                'username' => $this->username,
                'jumlahdataakun' => $this->jumlahdataakun
            ];
            return view('dashboard/admin/welcome', $data);
        } else {
            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            }
            $_SESSION['aktif'] = 'home';
            $data = [
                'judul' => 'Dasboard Klien'
            ];
            $judul = 'Dashboard Klien';
            $data = [
                'judul' => $judul,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'notelp' => $this->notelp,
                'username' => $this->username,

            ];
            return view('dashboard/klien/welcome', $data);
        };
    }
}
