<?php

namespace App\Controllers;

class Registrasi extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Halaman Registrasi',
        ];
        return view('Registrasi/index', $data);
    }
    public function save()
    {
        $data = $this->request->getVar();
        dd($data);
    }
}
