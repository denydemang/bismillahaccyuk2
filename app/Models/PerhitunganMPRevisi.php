<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganMPrevisi extends Model
{

    protected $table = 'perhitungan_materialpenyusunrev';
    protected $primaryKey = 'idmaterialpenyusun';
    protected $allowedFields = [
        'idmaterialpenyusun', 'idmaterial', 'namamp', 'spesifikasimp', 'jumlahmp', 'satuanmp', 'hargamp', 'totalmp', 'revisi_id'
    ];
    public function getbyidmaterial($idmaterial)
    {
        $mprevisi = new PerhitunganMPrevisi();
        $getdata =  $mprevisi->builder()->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_materialpenyusun.idmaterial', $idmaterial)->where('perhitungan_mprevisi.revisi_id', 3)->get()->getResultArray();
        return $getdata;
    }
}
