<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ModelLogin;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\TenakerModel;
use App\Models\BahanBakuProsesModel;
use App\Models\PerhitunganBBRevisiModel;
use App\Models\PerhitunganBOPRevisiModel;
use App\Models\PerhitunganTenakerRevisiModel;


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
            $builder = $builder->select('perhitunganbahanbaku.*,pengajuan_proyek.user_id,pengajuan_proyek.idajuan,pengajuan_proyek.namaproyek');
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
            $builder = $builder->select('perhitungantenaker.*,pengajuan_proyek.user_id,pengajuan_proyek.idajuan,pengajuan_proyek.namaproyek');
            $builder = $builder->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            // dd($getData);
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
            $builder = $builder->select('perhitunganbop.*,pengajuan_proyek.user_id,pengajuan_proyek.idajuan,pengajuan_proyek.namaproyek');
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
    public function tablebbproses()
    {
        if ($this->request->isAJAX()) {
            $idajuan =  session()->get('idajuan');
            // dd($idajuan);
            // $perhitunganbb = new PerhitunganBBModel();
            // $perhitunganbbrevisi = new PerhitunganBBRevisiModel();
            // $databbrevisi = $perhitunganbbrevisi->findAll();
            // if (empty($databbrevisi)) {
            //     $builder = $perhitunganbb->builder();

            // }
            $union   = $this->db->table('perhitunganbahanbaku')->select('id_pbb, namabahan, ukuran, kualitas, jenis, berat, ketebalan, panjang, harga, jumlah_beli')->where('idajuan', $idajuan)->where('revisi_id', 1);
            $builder = $this->db->table('perhitunganbbrevisi')->select('id_pbb, namabahan, ukuran, kualitas, jenis, berat, ketebalan, panjang, harga, jumlah_beli')->where('idajuan', $idajuan)->where('revisi_id', 3);
            $data =  $builder->unionAll($union)->orderBy('idajuan', 'DESC')->get()->getResultArray();

            // $builder = $perhitunganbb->builder();
            // $builder->select('perhitunganbahanbaku.*')->join('perhitunganbbrevisi', 'perhitunganbbrevisi.id_pbb=perhitunganbahanbaku.id_pbb');
            // $data = $builder->get()->getResultArray();
            // dd($data);


            $bb = [
                'databb' => $data,
            ];
            $data = [
                'databb' => view('dashboard/kelolaproyek/table/tablebbproses', $bb)
            ];
            echo json_encode($data);
        }
    }
    public function tableperhitunganbbrevisi()
    {
        if ($this->request->isAJAX()) {

            $hitungbbrevisi = new PerhitunganBBRevisiModel();
            $builder = $hitungbbrevisi->builder();
            $join = $builder->select('perhitunganbbrevisi.* ,pengajuan_proyek.idajuan,pengajuan_proyek.user_id, pengajuan_proyek.namaproyek')
                ->join('perhitunganbahanbaku', 'perhitunganbbrevisi.id_pbb=perhitunganbahanbaku.id_pbb')
                ->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan')->where('perhitunganbbrevisi.revisi_id', 3)->get()->getResultArray();

            $getData = $join;
            $data = [
                'bahanbaku' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tablepbbrevisi', $data),
            ];
            echo json_encode($kirimAJax);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function tableperhitunganboprevisi()
    {
        if ($this->request->isAJAX()) {
            $hitungboprevisi = new PerhitunganBOPRevisiModel();
            $builder = $hitungboprevisi->builder();
            $join = $builder->select('perhitunganboprevisi.* ,pengajuan_proyek.idajuan,pengajuan_proyek.user_id, pengajuan_proyek.namaproyek')
                ->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')
                ->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan')->where('perhitunganboprevisi.revisi_id', 3)->get()->getResultArray();
            $data = [
                'bop' => $join
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableboprevisi', $data),
            ];
            echo json_encode($kirimAJax);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function tableperhitungantenakerrevisi()
    {
        if ($this->request->isAJAX()) {
            $hitungtkrevisi = new PerhitunganTenakerRevisiModel();
            $builder = $hitungtkrevisi->builder();
            $join = $builder->select('perhitungantenakerrevisi.* ,pengajuan_proyek.idajuan,pengajuan_proyek.user_id, pengajuan_proyek.namaproyek')
                ->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')
                ->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan')->where('perhitungantenakerrevisi.revisi_id', 3)->get()->getResultArray();
            $data = [
                'tenaker' => $join
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tablepbtenakerrevisi', $data),
            ];
            echo json_encode($kirimAJax);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
}
