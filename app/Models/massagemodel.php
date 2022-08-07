<?php

namespace App\Models;

use CodeIgniter\Model;

class massagemodel extends Model
{

    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    protected $allowedFields = [
        'id_chat', 'id_admin', 'id_client', 'nama_user', 'nama_client', 'pesan'
    ];
}