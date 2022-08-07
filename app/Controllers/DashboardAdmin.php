<?php
namespace App\Controllers;

use App\Models\ModelLogin;
use App\Models\massagemodel;
// require APPPATH . '..\vendor\autoload.php';
// require __DIR__ . '/vendor/autoload.php';
require VENDORPATH . '/autoload.php';
use Pusher;
// require APPPATH . '..\vendor\pusher\pusher-php-server\src\pusher.php';
// require APPPATH . 'controllers\Pusher.php';

class DashboardAdmin extends Dashboard
{
    private $db,
        $jumlahdataakun;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $builder = $this->db->table('akun');

        //query builder untuk mendapatkan jumlah baris di tabel
        $builder->selectCount('user_id');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahdataakun = $getjumlahdata[0]->user_id;
        //end query builder untuk mendapatkan jumlah baris di tabel
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');

        // $this->user_id = session()->get('user_id');
    }
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,
            'jumlahdataakun' => $this->jumlahdataakun

        ];
        return view('dashboard/admin/welcome', $data);
    }
    public function ajuanproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'ajuan';

        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,

        ];
        return view('dashboard/admin/ajuanproyek', $data);
    }
    public function datauser()
    {

        $builder = $this->db->table('akun');
        $builder->select('*');
        $builder->select('level.levelnama');
        $builder->join('level', 'akun.user_level=level.user_level');
        $query = $builder->get();

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'datauser';
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,
            'users' => $query->getResult(),

        ];
        return view('dashboard/admin/datauser', $data);
    }
    public function dataproyek()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
        $data = [
            'judul' => 'Dashboard Admin',
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,

        ];
        return view('dashboard/admin/dataproyek', $data);
    }
    public function message($id=NULL)
    {   
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';

        $modelmassage=new massagemodel();
        $tampung=$modelmassage->findAll();
        
        $tampung2=$modelmassage->where('id_client', $id)->findAll(); //NULL
        $modelakun=new ModelLogin();
        $akun=$modelakun->findAll();

        $id_client = $id;
        $builder = $this->db->table('chat');
        $builder->select('id_admin, id_client, nama_user')
        ->where('id_client', $id_client)
        ->where('id_admin !=', 0);
        $query = $builder->get(1, 0); //NULL

        $data = [
            'judul' => 'Dashboard Admin',
            'username' => $this->username,
            'akun' => $akun,
            'massage' => $tampung,
            'massage2' => $tampung2, //NULL
            'klik' => $query->getResult() //NULL 
        ];
        if($id!=NULL){
            $modelmassage2=new massagemodel();
            $tampung2=$modelmassage2->where('id_client', $id)->findAll();
            $tampung=$modelmassage->findAll();
            $akunclient=$modelakun->select('user_id', 'nama_user')->where('user_id', $id);
            $query2=$akunclient->get()->getResult();
            // echo '<script>console.log("'.$query2[0]['id_user'].'");</script>';
            echo print_r($query2);  


            $id_client = $id;
            $builder = $this->db->table('chat');
            $builder->select('id_admin, id_client, nama_user')
            ->where('id_client', $id_client)
            ->where('id_admin !=', 0);
            $query = $builder->get(1, 0);

            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );
    
            $pusher = new Pusher\Pusher(
                'e0bd82d32cf9d6ef3c0f',
                '143094503bcdc550b65b',
                '1197215',
                $options
              );
            
            $data2 = [
                'judul' => 'Dashboard Admin',
                'username' => $this->username,
                'akun' => $akun,
                'massage' => $tampung,
                'massage2' => $tampung2,
                'akunclient' => $akunclient,
                'klik' => $query->getResult()
            ];
            // $pusher->trigger($id, 'my-event', $data2);

            if(isset($_POST['id_client'])&&isset($_POST['pesan'])==""){
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
                
                $modelmassage->insert($data);

                $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
                );
                $pusher = new Pusher\Pusher(
                'e0bd82d32cf9d6ef3c0f',
                '143094503bcdc550b65b',
                '1197215',
                $options
                );

                $builder = $this->db->table('chat');
                $builder->select('*')
                ->where('id_client', $id_client);
                // ->where('id_admin !=', 0);
                $query = $builder->get()->getResult();
                
                foreach($query as $key){
                    $data_pusher[] = $key;
                }

                $pusher->trigger($id_client, 'my-event', $data_pusher);

            }
            return view('dashboard/admin/message', $data2);    
        }


        return view('dashboard/admin/message', $data);
    }

    public function store(){
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

    // public function getklien()
    // {
    //     $id_client = $_POST['id_client'];
    //     $builder = $this->db->table('chat');
    //     $builder->select('id_admin, id_client, nama_user')
    //     ->where('id_client', $id_client)
    //     ->where('id_admin !=', 0);
    //     $query = $builder->get();
        
    //     echo json_encode($query->getResult());
    // }

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
        return redirect()->to(base_url('/admin/message/'.$id_client));
    }

    public function deleteuser($id)
    {
        $modeluser = new ModelLogin();
        $modeluser->where('user_id', $id)->delete();
        return redirect()->to(base_url() . '/admin/datauser');
    }
    public function ubahuser()
    {

        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];
        $userlevel = $_POST['role'];
        $data = [
            'user_name' => $username,
            'nama' => $nama,
            'email' => $email,
            'alamat' => $alamat,
            'notelp' => $notelp,
            'user_level' => $userlevel
        ];

        $modeluser = new ModelLogin();
        $modeluser
            ->where('user_id', $user_id)
            ->set($data)
            ->update();
        return redirect()->to(base_url() . '/admin/datauser');
    }
    public function getUser()
    {
        $id = $_POST['id'];
        $getuser = new ModelLogin();
        echo json_encode($getuser->where('user_id', $id)->findAll());
    }
}
