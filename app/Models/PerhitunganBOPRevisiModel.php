<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBOPRevisiModel extends Model
{
    protected $table = 'perhitunganboprevisi';
    protected $primaryKey = 'id_pbopr';
    protected $allowedFields = [
        'id_pbopr', 'id_pbop', 'user_id', 'idajuan', 'namaproyek', 'namatrans', 'tot_biaya', 'revisi_id'
    ];
}
