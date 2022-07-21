<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{

    protected $table = 'akun';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'user_name', 'nama', 'email', 'alamat', 'notelp', 'password', 'user_level'
    ];
}
