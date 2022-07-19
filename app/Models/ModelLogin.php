<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{

    protected $table = 'akun';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'user_name', 'nama', 'alamat', 'notelp', 'password', 'user_level'
    ];
}
