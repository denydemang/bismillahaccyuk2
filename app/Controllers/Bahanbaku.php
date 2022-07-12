<?php

namespace App\Controllers;

use \App\Models\Bahanbakumodel;

class Bahanbaku extends BaseController
{
    protected $bahanbakuModel;
    public function __construct()
    {
        $this->bahanbakuModel = new Bahanbakumodel();
    }
    public function index()
    {
        $databahanbakumodel = $this->bahanbakuModel->findAll();
        $data = [
            'judul' => 'Data Bahan Baku',
            'bahanbaku' => $databahanbakumodel
        ];

        return view('Bahanbaku/index', $data);
    }
    public function detail($id)
    {
        $databahanbakumodel = $this->bahanbakuModel->getBahanBaku($id);
        $data = [
            'judul' => 'Detail Bahan Baku',
            'bahanbaku' => $databahanbakumodel,
        ];

        return view('Bahanbaku/detail', $data);
    }
    public function save()
    {
    }
}
