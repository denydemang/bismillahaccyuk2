<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()

    {
        $data = [
            'judul' => 'Welcome',
        ];
        return view('home/index', $data);
    }
}
