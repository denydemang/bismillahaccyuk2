<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressProyekModel extends Model
{

    protected $table = 'progress_proyek';
    protected $primaryKey = 'idprogress';
    protected $allowedFields = [
        'idprogress', 'idproyek', 'idajuan', 'user_id', 'tanggal', 'namaproyek', 'persentase', 'progressproyek', 'gambar'
    ];
}
