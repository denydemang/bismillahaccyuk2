<?php


namespace App\Models;

use CodeIgniter\Model;

class PerhitunganMaterialModel extends Model
{
    protected $table = 'perhitungan_material';
    protected $primaryKey = 'idmaterial';
    protected $allowedFields = [
        'idmaterial', 'idajuan', 'jenismaterial', 'namamaterial', 'satuanmaterial', 'qtymaterial', 'hargamaterial', 'total_harga'
    ];

    public function getalljoinajuan()
    {
        $perhitunganmaterial = new PerhitunganMaterialModel();
        $getdata = $perhitunganmaterial->builder()->join('pengajuan_proyek', 'perhitungan_material.idajuan=pengajuan_proyek.idajuan')->get()->getResultArray();
        return $getdata;
    }
}
