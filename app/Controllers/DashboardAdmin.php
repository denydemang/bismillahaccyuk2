<?php

namespace App\Controllers;

use App\Models\ModelLogin;

class DashboardAdmin extends Dashboard
{

    public function __construct()
    {
        parent::__construct();
        $this->datalogin['judul'] = 'Dashboard Admin';
    }
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun
        ];

        return view('dashboard/admin/welcome', $this->datalogin);
    }
    public function ajuanproyek()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'ajuan';
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
    public function dataproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
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
    public function detailajuanproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'ajuan';
    }
}
