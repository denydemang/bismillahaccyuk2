<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganTenakerRevisiModel extends Model
{
    protected $table = 'perhitungantenakerrev';
    protected $primaryKey = 'id_pbtenaker';
    protected $allowedFields = [
        'id_pbtenaker', 'idajuan', 'jobdesk', 'statuspekerjaan', 'gaji',  'total_pekerja', 'total_gaji', 'revisi_id'
    ];
}
