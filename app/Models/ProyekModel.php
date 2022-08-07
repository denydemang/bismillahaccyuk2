<?php


namespace App\Models;

use CodeIgniter\Model;

class ProyekModel extends Model
{
    protected $table = 'proyek';
    protected $primaryKey = 'idproyek';
    protected $allowedFields = [
        'idproyek', 'idajuan', 'user_id', 'namaproyek', 'jenisproyek', 'nama', 'biaya', 'belum_bayar', 'sudah_bayar'
    ];
}
