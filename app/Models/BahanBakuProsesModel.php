<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBakuProsesModel extends Model
{
    protected $table = 'belibahan';
    protected $primaryKey = 'idbelibahan';
    protected $allowedFields = [
        'idproyek', 'idbelibahan', 'namabahan', 'tgl_beli', 'ukuran', 'kualitas', 'jenis', 'berat', 'ketebalan', 'panjang', 'harga', 'jumlah_beli'
    ];
    public function tampildata()
    {
        $bbdalamproses = new BahanBakuProsesModel();
        $builder = $bbdalamproses->builder();
        $builder = $builder->join('proyek', 'belibahan.idproyek=proyek.idproyek')->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan')->get();
        $getData = $builder->getResultArray();
        return $getData;
    }
}
