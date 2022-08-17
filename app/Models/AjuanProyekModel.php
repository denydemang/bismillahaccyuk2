<?php


namespace App\Models;

use CodeIgniter\Model;

class AjuanProyekModel extends Model
{
    protected $table = 'pengajuan_proyek';
    protected $primaryKey = 'idajuan';
    protected $allowedFields = [
        'idajuan', 'user_id', 'namaproyek', 'jenisproyek', 'lokasiproyek', 'jadwalproyek', 'anggaran', 'status_id', 'file_upload', 'file_admin', 'revisi_id'
    ];
}
