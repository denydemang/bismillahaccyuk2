<?php


namespace App\Models;

use CodeIgniter\Model;

class TenakerModel extends Model
{
    protected $table = 'tenaker';
    protected $primaryKey = 'id_sewatenaker';
    protected $allowedFields = [
        'id_sewatenaker', 'id_pbtenaker', 'idproyek', 'gaji', 'total_gaji', 'tanggal'
    ];
}
