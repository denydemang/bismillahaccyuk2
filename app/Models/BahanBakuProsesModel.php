<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuProsesModel extends Model
{
    protected $table = 'belibahan';
    protected $primaryKey = 'idbeli';
    protected $allowedFields = [
        'idbeli', 'idproyek', 'idmaterialpenyusun', 'namamp', 'tgl_beli', 'harga_beli', 'totalharga'
    ];
    public function tampildata()
    {
        $bbdalamproses = new BahanBakuProsesModel();
        $builder = $bbdalamproses->builder();
        $builder = $builder->join('proyek', 'belibahan.idproyek=proyek.idproyek')->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan')->get();
        $getData = $builder->getResultArray();
        return $getData;
    }
}
