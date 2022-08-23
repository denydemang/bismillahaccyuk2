<?php


namespace App\Models;

use CodeIgniter\Model;

class BOPModel extends Model
{
    protected $table = 'transaksibop';
    protected $primaryKey = 'id_pbopr';
    protected $allowedFields = [
        'id_pbopr', 'idpbop', 'tanggal', 'idproyek', 'harga', 'tot_biaya',
    ];
}
