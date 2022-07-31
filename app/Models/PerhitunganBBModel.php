<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganBBModel extends Model
{
    protected $table = 'perhitunganbahanbaku';
    protected $primaryKey = 'id_pbb';
    protected $allowedFields = [
        'id_pbb', 'user_id', 'namaproyek', 'idajuan', 'namabahan', 'jenis', 'ukuran', 'kualitas', 'berat', 'ketebalan', 'panjang', 'harga', 'jumlah_beli', 'total_harga'
    ];
}
