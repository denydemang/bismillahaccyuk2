<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganTenakerModel extends Model
{
    protected $table = 'perhitungantenaker';
    protected $primaryKey = 'id_pbtenaker';
    protected $allowedFields = [
        'id_pbtenaker', 'user_id', 'idajuan', 'namaproyek', 'jenispekerjaan', 'gaji', 'hari', 'total_pekerja', 'total_gaji', 'revisi_id'
    ];
}
