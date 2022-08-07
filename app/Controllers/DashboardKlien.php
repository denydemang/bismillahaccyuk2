<?php

namespace App\Controllers;
use App\Models\ModelLogin;
use App\Models\massagemodel;
require VENDORPATH . '/autoload.php';
use Pusher;

use App\Models\AjuanProyekModel;
use App\Models\ProgressProyekModel;

class DashboardKLien extends Dashboard
{

    public function __construct()
    {
<<<<<<< HEAD
        $this->db = \Config\Database::connect();

        $this->user_id = session()->get('user_id');
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
=======
        parent::__construct();

        $this->datalogin['judul'] = 'Dashboard Klien';
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
    }
    public function index()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';
        return view('dashboard/klien/welcome', $this->datalogin);
    }
    public function ajuanproyek()
    {

<<<<<<< HEAD
    public function message($id=0)
=======
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'ajuanproyek';
        return view('dashboard/klien/pengajuanproyek', $this->datalogin);
    }
    public function progressproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'progressproyek';
        $progressproyek = new ProgressProyekModel();
        $user_id = $this->user_id;
        $dataprogress = $progressproyek->where('user_id', $user_id)->find();
        $this->datalogin += [
            'dataprogress' => $dataprogress,
        ];

        return view('dashboard/klien/progressproyek', $this->datalogin);
    }
    public function message()
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
<<<<<<< HEAD
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
=======

        return view('dashboard/klien/message', $this->datalogin);
    }

    //FUnction Query
    public function simpanajuanproyek()
    {
        $user_id = $this->request->getVar('user_id');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $alamat = $this->request->getVar('alamat');
        $notelp = $this->request->getVar('notelp');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $lokasiproyek = $this->request->getVar('lokasiproyek');
        $catatan = $this->request->getVar('catatan');
        $idajuan = $this->kodeotomatis('pengajuan_proyek', 'idajuan', 'AJP001');
        $AjuanProyekModel = new AjuanProyekModel();
        $AjuanProyekModel->insert([
            'idajuan' => $idajuan,
            'user_id' => $user_id,
            'nama' => $nama,
            'email' => $email,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'lokasiproyek' => $lokasiproyek,
            'catatanproyek' => $catatan,
            'status_id' => '1'


        ]);
        session()->setFlashdata('pesan', 'berhasildiajukan');
        return redirect()->to(base_url('/klien'));
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
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