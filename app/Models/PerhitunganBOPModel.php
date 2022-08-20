<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBOPModel extends Model
{
    protected $table = 'perhitunganbop';
    protected $primaryKey = 'id_pbop';
    protected $allowedFields = [
        'id_pbop', 'idajuan', 'namatrans', 'satuan', 'quantity', 'harga', 'tot_biaya', 'revisi_id'
    ];
}
