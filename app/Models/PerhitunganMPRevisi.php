<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganMPrevisi extends Model
{
    protected $table = 'perhitungan_mprevisi';
    protected $primaryKey = 'idmprevisi';
    protected $allowedFields = [
        'idmprevisi', 'idmaterialpenyusun', 'namampr', 'spesifikasimpr', 'jumlahmpr', 'satuanmpr', 'hargampr', 'totalmpr', 'revisi_id'
    ];
    public function getbyidmaterial($idmaterial)
    {
        $mprevisi = new PerhitunganMPrevisi();
        $getdata =  $mprevisi->builder()->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_materialpenyusun.idmaterial', $idmaterial)->where('perhitungan_mprevisi.revisi_id', 3)->get()->getResultArray();
        return $getdata;
    }
}
