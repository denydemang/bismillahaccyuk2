<?php


namespace App\Models;

use CodeIgniter\Model;

class AjuanProyekModel extends Model
{
    protected $table = 'pengajuan_proyek';
    protected $primaryKey = 'idajuan';
    protected $allowedFields = [
        'idajuan', 'user_id', 'nama', 'alamat', 'notelp', 'namaproyek', 'jenisproyek', 'lokasiproyek', 'catatanproyek'
    ];
}
