<?php

namespace App\Controllers;

use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
use App\Models\TenakerModel;

class DashboardKelolaProyek extends Dashboard
{

    public function __construct()
    {
        parent::__construct();
        $this->idproyek = session()->get('idproyek');
        $builder = $this->db->table('proyek');
        $builder->select('*');
        $builder->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan');
        $builder->where('idproyek', $this->idproyek);
        $query = $builder->get();
        $hasil = $query->getResultArray();

        $this->datalogin += [
            'idproyek' => $this->idproyek,
            'dataproyek' => $hasil
        ];
        $this->datalogin['judul'] = 'Dashboard Kelola Proyek';
    }
    public function index()
    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';

        return view('dashboard/kelolaproyek/welcome', $this->datalogin);
    }
    function bbdalamproses()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'bbdalamproses';
        return view('dashboard/kelolaproyek/bbdalamproses', $this->datalogin);
    }
    function tenagakerja()

    {

        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'tenagakerja';

        return view('dashboard/kelolaproyek/tenagakerja', $this->datalogin);
    }
    function progressproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        return view('dashboard/kelolaproyek/progressproyek', $this->datalogin);
    }
    function pembayaranproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'pembayaranproyek';
        return view('dashboard/kelolaproyek/pembayaranproyek', $this->datalogin);
    }
    function penggunaanmesin()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'penggunaanmesin';
        return view('dashboard/kelolaproyek/penggunaanmesin', $this->datalogin);
    }
    function laporanhpp()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'laporanhpp';
        return view('dashboard/kelolaproyek/laporanhpp', $this->datalogin);
    }
    function backtodataproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }

        session()->set('kelolaproyek', '');
        return redirect()->to(base_url('admin/dataproyek'));
    }
    public function tampilkodeotomatis()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'idproyek' => $this->idproyek,
                'idtenaker' => $this->kodeotomatis('tenaker', 'idtenaker', 'TKJ001')

            ];
            echo json_encode($data);
        }
    }
}
