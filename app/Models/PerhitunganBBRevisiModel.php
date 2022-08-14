<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBBRevisiModel extends Model
{
    protected $table = 'perhitunganbbrevisi';
    protected $primaryKey = 'id_pbbr';
    protected $allowedFields = [
        'id_pbbr', 'id_pbb', 'idajuan', 'user_id', 'namaproyek', 'idajuan', 'namabahan', 'jenis', 'ukuran', 'kualitas', 'berat', 'ketebalan', 'panjang', 'harga', 'jumlah_beli', 'total_harga', 'revisi_id'
    ];
}
