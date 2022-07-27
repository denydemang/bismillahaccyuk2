<?php

namespace App\Controllers;

use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
use App\Models\ProyekModel;

class DashboardAdmin extends Dashboard
{

    public function __construct()
    {
        parent::__construct();
        $this->datalogin['judul'] = 'Dashboard Admin';
    }

    //method Tampil View
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
        ];

        return view('dashboard/admin/welcome', $this->datalogin);
    }
    public function ajuanproyek()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $query = $builder->get();
        $_SESSION['aktif'] = 'ajuan';
        $this->datalogin += [
            'dataajuan' => $query->getResult()
        ];

        return view('dashboard/admin/ajuanproyek', $this->datalogin);
    }


    public function datauser()
    {

        $builder = $this->db->table('akun');
        $builder->select('*');
        $builder->select('level.levelnama');
        $builder->join('level', 'akun.user_level=level.user_level');
        $query = $builder->get();

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'datauser';
        $this->datalogin += [
            'users' => $query->getResult(),
        ];
        return view('dashboard/admin/datauser', $this->datalogin);
    }

    public function dataproyek($id = '')
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
        $kodeproyek = $this->kodeotomatis('proyek', 'idproyek', 'PRY001');
        $modelajuan = new AjuanProyekModel();
        $getdata = $modelajuan->where('status_id', '2')->findAll();
        $modelajuan = new AjuanProyekModel();
        $datakirim = $modelajuan->where('idajuan', $id)->where('status_id', '2')->findAll();
        if (!empty($datakirim)) {
            $idajuan = $datakirim[0]['idajuan'];
            $namaproyek = $datakirim[0]['namaproyek'];
            $jenisproyek = $datakirim[0]['jenisproyek'];
            $namaklien = $datakirim[0]['nama'];
            $idklien = $datakirim[0]['user_id'];
        } else {
            $idajuan = '';
            $namaproyek = '';
            $jenisproyek = '';
            $namaklien = '';
            $idklien = '';
        }
        $proyekmodel = new ProyekModel();
        $getproyek = $proyekmodel->findAll();
        if (empty($getproyek)) {
            $tablekosong = 'true';
        } else {
            $tablekosong = 'false';
        }
        $this->datalogin += [
            'dataajuan' => $getdata,
            'kodeproyek' => $kodeproyek,
            'datakirim' => $datakirim,
            'idajuan' => $idajuan,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'namaklien' => $namaklien,
            'idklien' => $idklien,
            'proyek' => $getproyek,
            'tablekosong' => $tablekosong
        ];


        return view('dashboard/admin/dataproyek', $this->datalogin);
    }
    public function message()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';
        return view('dashboard/admin/message', $this->datalogin);
    }

    ////Method untuk menjalankan query

    public function buatproyek()
    {
        $idproyek = $this->request->getVar('idproyek');
        $idajuan = $this->request->getVar('idajuan');
        $iduser = $this->request->getVar('user_id');
        $nama = $this->request->getVar('nama');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $biaya = $this->request->getVar('biaya');
        $sudahbayar = $this->request->getVar('sudahbayar');
        $belumbayar = $this->request->getVar('belumbayar');
        $modelproyek = new ProyekModel();
        $modelproyek->insert([
            'idproyek' => $idproyek,
            'idajuan' => $idajuan,
            'user_id' => $iduser,
            'nama' => $nama,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'biaya' => $biaya,
            'sudah_bayar' => $sudahbayar,
            'belum_bayar' => $belumbayar,
        ]);
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $idajuan)->set([
            'status_id' => '4',
        ])->update();
        session()->setFlashdata('pesan', 'Proyek Dengan Id Ajuan: ' . $idajuan . ' Berhasil Dibuat');
        return redirect()->to(base_url() . '/admin/dataproyek');
    }
    public function detailajuanproyek()

    {
        $id = $this->request->getVar('id');
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->where('idajuan', $id);
        $query = $builder->get();
        $getdata = $query->getResult();

        echo json_encode($getdata);
    }

    public function terimaajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $id)->set([
            'status_id' => '2',
        ])->update();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'diterima');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function tolakajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $id)->set([
            'status_id' => '3',
        ])->update();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'ditolak');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function hapusajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        $modelajuan->delete($id);
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'dihapus');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function deleteuser($id)
    {
        $modeluser = new ModelLogin();
        $modeluser->where('user_id', $id)->delete();
        return redirect()->to(base_url() . '/admin/datauser');
    }
    public function ubahuser()
    {

        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];
        $userlevel = $_POST['role'];
        $data = [
            'user_name' => $username,
            'nama' => $nama,
            'email' => $email,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'user_level' => $userlevel
        ];

        $modeluser = new ModelLogin();
        $modeluser
            ->where('user_id', $user_id)
            ->set($data)
            ->update();
        return redirect()->to(base_url() . '/admin/datauser');
    }
    public function getUser()
    {
        $id = $_POST['id'];
        $getuser = new ModelLogin();
        echo json_encode($getuser->where('user_id', $id)->findAll());
    }
}
