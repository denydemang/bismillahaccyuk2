<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{

    protected $table = 'akun';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'user_id', 'user_name', 'nama', 'namaperusahaan', 'email', 'alamat', 'alamatperusahaan', 'jabatan', 'notelp', 'password', 'user_level'
    ];
    public function getalluser()
    {
        $users = new ModelLogin();
        $data = $users->findAll();
        return $data;
    }
}
