<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterKelolaProyek implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if (session()->get('kelolaproyek') == 'false') {
        //     return redirect()->to(base_url() . '/admin');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('kelolaproyek') == 'true') {
            return redirect()->to(base_url() . '/kelolaproyek');
        }
    }
}
