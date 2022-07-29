<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ModelLogin;
use App\Models\PerhitunganBBModel;

class TampilTable extends Dashboard
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
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
            $getData = $hitungbb->findAll();
            $data = [
                'bahanbaku' => $getData,
            ];
            $kirimAJax = [
                'data' => view('dashboard/admin/table/tableperhitunganbiayabb', $data),
            ];
            echo json_encode($kirimAJax);
        } else {

            exit('Hop ANda Memasuki Wilayah Terlarang');
        }
    }
}
