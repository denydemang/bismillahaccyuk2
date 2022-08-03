<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function index()
    {
        session()->destroy();
        session()->set('kelolaproyek', '');
        return redirect()->to(base_url() . '/');
    }
}
