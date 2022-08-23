<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatNotifKlienModel extends Model
{

    protected $table = 'chat_notif_klien';
    protected $primaryKey = 'id_chat_notif';
    protected $allowedFields = [
        'id_chat_notif', 'nama_klien', 'jumlah_notif',
    ];
}