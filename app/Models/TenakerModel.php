<?php


namespace App\Models;

use CodeIgniter\Model;

class TenakerModel extends Model
{
    protected $table = 'tenaker';
    protected $primaryKey = 'idtenaker';
    protected $allowedFields = [
        'idtenaker', 'idproyek', 'namatenaker', 'almttenaker', 'pekerjaan', 'gaji', 'belum_bayar', 'sudah_bayar'
    ];
}
