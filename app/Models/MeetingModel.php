<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingModel extends Model
{

    protected $table = 'meeting';
    protected $primaryKey = 'idmeeting';
    protected $allowedFields = [
        'idmeeting', 'idajuan', 'namameeting', 'lokasimeeting', 'tanggalmeeting'
    ];
    public function getalluser()
    {
        $users = new ModelLogin();
        $data = $users->findAll();
        return $data;
    }
}
