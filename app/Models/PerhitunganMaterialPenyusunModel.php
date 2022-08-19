<?php


namespace App\Models;

use CodeIgniter\Model;

class PerhitunganMaterialPenyusunModel extends Model
{
    protected $table = 'perhitungan_materialpenyusun';
    protected $primaryKey = 'idmaterialpenyusun';
    protected $allowedFields = [
        'idmaterialpenyusun', 'idmaterial', 'namamp', 'spesifikasimp', 'jumlahmp', 'satuanmp', 'hargamp', 'totalmp'
    ];
    public function getbyidmaterial($idmaterial)
    {
        $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
        $getdata =  $perhitunganmaterialpenyusun->builder()->join('perhitungan_material', 'perhitungan_materialpenyusun.idmaterial=perhitungan_material.idmaterial')->where('perhitungan_materialpenyusun.idmaterial', $idmaterial)->get()->getResultArray();
        return $getdata;
    }
}
