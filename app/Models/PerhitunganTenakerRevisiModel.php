<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganTenakerRevisiModel extends Model
{
    protected $table = 'perhitungantenakerrevisi';
    protected $primaryKey = 'id_pbtenakerr';
    protected $allowedFields = [
        'id_pbtenakerr', 'id_pbtenaker', 'idajuan', 'jobdesk', 'statuspekerjaan', 'gaji', 'total_pekerja', 'total_gaji', 'revisi_id'
    ];
}
