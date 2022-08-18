<?php


namespace App\Models;

use CodeIgniter\Model;

class PerhitunganMaterialPenyusunModel extends Model
{
    protected $table = 'perhitungan_materialpenyusun';
    protected $primaryKey = 'idmaterialpenyusun';
    protected $allowedFields = [
        'idmaterialpenyusun', 'idmaterial', 'namamp', 'spesifikasimp', 'jumlahmp', 'satuanmp', 'hargamp'
    ];
}
