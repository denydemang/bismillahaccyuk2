<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBOPModel extends Model
{
    protected $table = 'perhitunganbop';
    protected $primaryKey = 'id_pbop';
    protected $allowedFields = [
        'id_pbop', 'user_id', 'idajuan', 'namaproyek', 'namatrans', 'tot_biaya', 'revisi_id'
    ];
}
