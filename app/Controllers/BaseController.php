<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // session_start();
        session()->start();
    }
    public function kodeotomatis($table, $field, $kodeawal)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->selectMax($field);
        $hasil = $builder->get();
        $getData = $hasil->getResultArray();
        $kode = $getData[0][$field];

        if ($kode == null) {
            //jika tidak ada record masukkan id awal
            $tampilkode = $kodeawal;
        } else {
            //pecah string ambil bagian 3 digit angka setelah string misal USR001 Ambil 001 jadikan integer
            $pecahkode = (int)substr($kode, 3, 3);
            //tambahkan 1
            $pecahkode++;
            //buat digit angka tadi tetap berjumlah 3 walupun sudah ditambah 1 pake sprintf
            $pecahkode = sprintf("%03s", $pecahkode);
            //pecah string ambil 3 huruf awal misal USR001 ambil USR
            $pecahhuruf = substr($kode, 0, 3);
            //gabung antara string dan angka 
            $tampilkode = $pecahhuruf . $pecahkode;
        }
        //tampilkan
        return $tampilkode;
    }
}
