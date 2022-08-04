<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;

class Dashboard extends BaseController
{

    protected $user_id,
        $nama,
        $email,
        $alamat,
        $notelp,
        $username,
        $db,
        $jumlahdataakun,
        $jumlahajuan,
        $jumlahproyek,
        $datalogin,
        $idproyek;
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


        //query buider untuk mendapatkan jumlah baris data di table proyek
        $builder = $this->db->table('proyek');
        $builder->selectCount('idproyek');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahproyek = $getjumlahdata[0]->idproyek;

        //query builder untuk mendapatkan jumlah baris data di table ajuan
        $builder = $this->db->table('pengajuan_proyek');
        $builder->selectCount('idajuan');
        $builder->where('status_id', '1');
        $jumlahajuan = $builder->get();
        $jumlahajuan->getRow();
        $getjumlahajuan = $jumlahajuan->getResultObject();
        $this->jumlahajuan = $getjumlahajuan[0]->idajuan;
        //end query builder untuk mendapatkan jumlah baris data di table ajuan

        //menginput data user yang login
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
        $this->user_id = session()->get('user_id');
        $this->email = session()->get('email');
        //masukkan ke variable data login admin
        $this->datalogin = [
            'judul' => '',
            'user_id' => $this->user_id,
            'email' => $this->email,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,


        ];
        //untuk mendapatkan data progress dan ajuan proyek berdasarkan user yang login
        $data = $this->datalogin['user_id'];
        $ajuanproyekmodel = new AjuanProyekModel();
        $ajuanklien = $ajuanproyekmodel->where('user_id', $data)->find();
        $ajuanditerima = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '2')->find();
        $ajuanditolak = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '3')->find();
        $ajuandikerjakan = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '4')->find();
        $this->datalogin += [
            'ajuanditerima' => $ajuanditerima,
            'ajuanditolak' => $ajuanditolak,
            'ajuandikerjakan' => $ajuandikerjakan,
            'ajuanklien' => $ajuanklien
        ];
        //end untuk mendapatkan data progress dan ajuan proyek berdasarkan user yang login
    }

    public function index()
    {
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek
        ];
        $this->kodeotomatis('akun', 'user_id', 'usr001');
        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';

            $this->datalogin['judul'] = 'Dashboard Admin';
            $this->datalogin += [
                'jumlahdataakun' => $this->jumlahdataakun,
                'jumlahajuan' => $this->jumlahajuan
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
