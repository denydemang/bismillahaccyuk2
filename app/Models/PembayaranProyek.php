<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranProyek extends Model
{

    protected $table = 'pembayaran_proyek';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = [
        'id_pembayaran', 'idproyek', 'tgl_bayar', 'invoice', 'total_bayar', 'belum_bayar'
    ];
    public function getalluser()
    {
        $users = new ModelLogin();
        $data = $users->findAll();
        return $data;
    }
}
