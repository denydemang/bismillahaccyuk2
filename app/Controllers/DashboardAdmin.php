<?php

namespace App\Controllers;

use App\Models\ModelLogin;

class DashboardAdmin extends Dashboard
{
    private $db,
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
        //end query builder untuk mendapatkan jumlah baris di tabel
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,
            'jumlahdataakun' => $this->jumlahdataakun

        ];
        return view('dashboard/admin/welcome', $data);
    }
    public function ajuanproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'ajuan';

        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,

        ];
        return view('dashboard/admin/ajuanproyek', $data);
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
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,
            'users' => $query->getResult(),

        ];
        return view('dashboard/admin/datauser', $data);
    }
    public function dataproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,

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
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,
        ];
        return view('dashboard/admin/message', $data);
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
