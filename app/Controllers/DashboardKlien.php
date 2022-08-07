<?php

namespace App\Controllers;
use App\Models\ModelLogin;
use App\Models\massagemodel;
require VENDORPATH . '/autoload.php';
use Pusher;

class DashboardKLien extends Dashboard
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->user_id = session()->get('user_id');
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
    }
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';
        $data = [
            'judul' => 'Dasboard Klien',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username
        ];
        return view('dashboard/klien/welcome', $data);
    }

    public function message($id=0)
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
        $modelmassage=new massagemodel();
        // $tampung=$modelmassage->findAll();
        $tampung=$modelmassage->where('id_client', $this->user_id)->findAll();
        // $tampung2=$modelmassage->where('id_admin', $id)->findAll(); //NULL
        $modelakun=new ModelLogin();
        $akun=$modelakun->findAll();

        $id_client = $id;
        $builder = $this->db->table('chat');
        $builder->select('id_admin, id_client, nama_user')
        ->where('id_client', $id_client)
        ->where('id_admin !=', 0);
        $query = $builder->get(1, 0); //NULL

        $data = [
            'judul' => 'Dashboard Klien',
            'user_id' => $this->user_id,
            'username' => $this->username,
            'akun' => $akun,
            'massage' => $tampung,
            'klik' => $query->getResult() //NULL 
        ];
        return view('dashboard/klien/message', $data);
    }

    public function kirimpesan($id=NULL)
    {
        $id_admin = $_POST['id_admin'];
        $id_client = $_POST['id_client'];
        $nama_user = $_POST['nama_user'];
        $pesan = $_POST['pesan'];
        $data = [
            'id_admin' => $id_admin,
            'id_client' => $id_client,
            'nama_user' => $nama_user,
            'pesan' => $pesan,
        ];

        $modelmassage=new massagemodel();
        $modelmassage->insert($data);
        return redirect()->to(base_url('/klien/message/'));
    }

    public function store2(){
        $modelmassage=new massagemodel();

        $id_admin = $_POST['id_admin'];
        $id_client = $_POST['id_client'];
        $nama_user = $_POST['nama_user'];
        $pesan = $_POST['pesan'];

        $data = array(
            'id_admin' => $id_admin,
            'id_client' => $id_client,
            'nama_user' => $nama_user,
            'pesan' => $pesan,
        );
        
        $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
        );
        // $pusher = new Pusher\Pusher(
        // 'e0bd82d32cf9d6ef3c0f',
        // '143094503bcdc550b65b',
        // '1197215',
        // $options
        // );
        $pusher = new Pusher\Pusher(
            '40ffd99f64d712cc1ceb',
            '6fa3735fd7909ba7255c',
            '1456878',
            $options
            );

        
        $modelmassage->insert($data);

        $builder = $this->db->table('chat');
        $builder->select('*')
        ->where('id_client', $id_client);
        // ->where('id_admin !=', 0);
        $query = $builder->get()->getResult();
        
        foreach($query as $key){
            $data_pusher[] = $key;
        }
        
        $pusher->trigger($id_client, 'my-event', $data_pusher);
        echo json_encode($query); 
        
    }

}