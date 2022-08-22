<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBOPRevisiModel extends Model
{
    protected $table = 'perhitunganboprev';
    protected $primaryKey = 'id_pbop';
    protected $allowedFields = [
        'id_pbop', 'idajuan', 'namatrans', 'satuan', 'quantity', 'harga', 'tot_biaya', 'revisi_id'
    ];
}
