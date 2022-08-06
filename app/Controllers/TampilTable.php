<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ModelLogin;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\TenakerModel;

class TampilTable extends Dashboard
{

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
        return redirect()->to(base_url('admin/perhitunganbiaya'));
    }
    public function tableuser()
    {
        if ($this->request->isAJAX()) {
            $builder = $this->db->table('akun');
            $builder->select('*');
            $builder->select('level.levelnama');
            $builder->join('level', 'akun.user_level=level.user_level');
            $query = $builder->get();
            $getData = $query->getResult();
            $data = [
                'users' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableuser', $data),
            ];
            echo json_encode($kirimAJax);
        } else {

            exit('Hop ANda Memasuki Wilayah Terlarang');
        }
    }
    public function tableperhitunganbb()
    {
        if ($this->request->isAJAX()) {
            $hitungbb = new PerhitunganBBModel();
            $builder = $hitungbb->builder();
            $builder = $builder->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            $data = [
                'bahanbaku' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableperhitunganbiayabb', $data),
            ];
            echo json_encode($kirimAJax);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function tableperhitungantenaker()
    {
        if ($this->request->isAJAX()) {
            $hitungtenaker = new PerhitunganTenakerModel();
            $builder = $hitungtenaker->builder();
            $builder = $builder->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            $data = [
                'tenaker' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableperhitunganbiayatenaker', $data),
            ];
            echo json_encode($kirimAJax);
        } else {

            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function tableperhitunganbop()
    {
        if ($this->request->isAJAX()) {
            $hitungbop = new PerhitunganBOPModel();
            $builder = $hitungbop->builder();
            $builder = $builder->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            $data = [
                'bop' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableperhitunganbiayabop', $data),
            ];
            echo json_encode($kirimAJax);
        } else {

            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function tabletenaker()
    {
        if ($this->request->isAJAX()) {
            $tenakermodel = new TenakerModel();
            $hasil = $tenakermodel->where('idproyek', $this->idproyek)->findAll();
            $data = [
                'datatenaker' => $hasil,
            ];
            $kirimAJax = [
                'data' => view('dashboard/kelolaproyek/table/tabletenaker', $data),
            ];
            echo json_encode($kirimAJax);
        } else {

            return redirect()->to(base_url('kelolaproyek'));
        }
    }
}
