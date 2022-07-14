<?php 
namespace App\Controllers;
class DashboardDetailProyek extends Dashboard
{
    public function index()
    {
        $data = [
            'judul' => 'Dasboard Detail Proyek'
        ];
        return view('dashboard/detailproyek', $data);
    }

}
