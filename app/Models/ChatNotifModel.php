<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatNotifModel extends Model
{

    protected $table = 'chat_notif';
    protected $primaryKey = 'id_chat_notif';
    protected $allowedFields = [
        'id_chat_notif', 'nama_user', 'jumlah_notif',
    ];
}