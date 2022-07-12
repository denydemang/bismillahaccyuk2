<?php

namespace App\Models;

use CodeIgniter\Model;

class Bahanbakumodel extends Model
{
    protected $table = 'bahanbaku';
    protected $primaryKey = 'idbahan';

    public function getBahanBaku($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['idbahan' => $id])->first();
    }
}
