<?php


namespace App\Models;

use CodeIgniter\Model;

class MaterialUtamaModel extends Model
{
    protected $table = 'material_utama';
    protected $primaryKey = 'id_materialutama';
    protected $allowedFields = [
        'id_materialutama', 'idmaterial', 'idproyek', 'hargamaterial', 'total_harga'
    ];

    public function getalljoinajuan()
    {
        $perhitunganmaterial = new PerhitunganMaterialModel();
        $getdata = $perhitunganmaterial->builder()->join('pengajuan_proyek', 'perhitungan_material.idajuan=pengajuan_proyek.idajuan')->get()->getResultArray();
        return $getdata;
    }
}
