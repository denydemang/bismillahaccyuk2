<?php


namespace App\Models;

use CodeIgniter\Model;

class TokensModel extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'token', 'user_id'
    ];
}
