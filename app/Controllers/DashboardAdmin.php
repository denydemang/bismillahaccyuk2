<?php
namespace App\Controllers;

use App\Models\ModelLogin;
<<<<<<< HEAD
use App\Models\massagemodel;
// require APPPATH . '..\vendor\autoload.php';
// require __DIR__ . '/vendor/autoload.php';
require VENDORPATH . '/autoload.php';
use Pusher;
// require APPPATH . '..\vendor\pusher\pusher-php-server\src\pusher.php';
// require APPPATH . 'controllers\Pusher.php';
=======
use App\Models\AjuanProyekModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997

class DashboardAdmin extends Dashboard
{

    public function __construct()
    {
<<<<<<< HEAD
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
=======
        parent::__construct();
        $this->datalogin['judul'] = 'Dashboard Admin';
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
    }

    //method Tampil View
    public function index()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek
        ];

        return view('dashboard/admin/welcome', $this->datalogin);
    }
    public function ajuanproyek()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $query = $builder->get();
        $_SESSION['aktif'] = 'ajuan';
        $this->datalogin += [
            'dataajuan' => $query->getResult()
        ];

        return view('dashboard/admin/ajuanproyek', $this->datalogin);
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
        $this->datalogin += [
            'users' => $query->getResult(),
        ];
        return view('dashboard/admin/datauser', $this->datalogin);
    }

    public function dataproyek($id = '')
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'dataproyek';
        $kodeproyek = $this->kodeotomatis('proyek', 'idproyek', 'PRY001');
        $modelajuan = new AjuanProyekModel();
        $getdata = $modelajuan->where('status_id', '2')->findAll();
        $modelajuan = new AjuanProyekModel();
        $datakirim = $modelajuan->where('idajuan', $id)->where('status_id', '2')->findAll();
        if (!empty($datakirim)) {
            $idajuan = $datakirim[0]['idajuan'];
            $namaproyek = $datakirim[0]['namaproyek'];
            $jenisproyek = $datakirim[0]['jenisproyek'];
            $namaklien = $datakirim[0]['nama'];
            $idklien = $datakirim[0]['user_id'];
        } else {
            $idajuan = '';
            $namaproyek = '';
            $jenisproyek = '';
            $namaklien = '';
            $idklien = '';
        }
        $proyekmodel = new ProyekModel();
        $getproyek = $proyekmodel->findAll();
        if (empty($getproyek)) {
            $tablekosong = 'true';
        } else {
            $tablekosong = 'false';
        }
        $this->datalogin += [
            'dataajuan' => $getdata,
            'kodeproyek' => $kodeproyek,
            'datakirim' => $datakirim,
            'idajuan' => $idajuan,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'namaklien' => $namaklien,
            'idklien' => $idklien,
            'proyek' => $getproyek,
            'tablekosong' => $tablekosong
        ];


        return view('dashboard/admin/dataproyek', $this->datalogin);
    }
    public function message($id=NULL)
    {   
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';
<<<<<<< HEAD

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
=======
        return view('dashboard/admin/message', $this->datalogin);
    }
    public function perhitunganbiaya()
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'perhitunganbiaya';
        return view('dashboard/admin/perhitunganbiaya', $this->datalogin);
    }

    ////Method untuk menjalankan query

    public function buatproyek()
    {
        $idproyek = $this->request->getVar('idproyek');
        $idajuan = $this->request->getVar('idajuan');
        $iduser = $this->request->getVar('user_id');
        $nama = $this->request->getVar('nama');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $biaya = $this->request->getVar('biaya');
        $sudahbayar = $this->request->getVar('sudahbayar');
        $belumbayar = $this->request->getVar('belumbayar');
        $modelproyek = new ProyekModel();
        $idprogress = $this->kodeotomatis('progress_proyek', 'idprogress', 'PRG001');
        $modelprogressproyek = new ProgressProyekModel();

        $modelproyek->insert([
            'idproyek' => $idproyek,
            'idajuan' => $idajuan,
            'user_id' => $iduser,
            'nama' => $nama,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'biaya' => $biaya,
            'sudah_bayar' => $sudahbayar,
            'belum_bayar' => $belumbayar,
        ]);
        $modelprogressproyek->insert([
            'idprogress' => $idprogress,
            'idproyek' => $idproyek,
            'idajuan' => $idajuan,
            'user_id' => $iduser,
            'namaproyek' => $namaproyek,
        ]);
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $idajuan)->set([
            'status_id' => '4',
        ])->update();
        session()->setFlashdata('pesan', 'Proyek Dengan Id Ajuan: ' . $idajuan . ' Berhasil Dibuat');
        return redirect()->to(base_url() . '/admin/dataproyek');
    }
    public function detailajuanproyek()

    {
        $id = $this->request->getVar('id');
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->where('idajuan', $id);
        $query = $builder->get();
        $getdata = $query->getResult();

        echo json_encode($getdata);
    }

    public function terimaajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $id)->set([
            'status_id' => '2',
        ])->update();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'diterima');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function tolakajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $id)->set([
            'status_id' => '3',
        ])->update();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'ditolak');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function hapusajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $getData = $modelajuan->where('idajuan', $id)->find();
        $namaproyek = $getData[0]['namaproyek'];
        $namaklien = $getData[0]['nama'];
        $modelajuan->delete($id);
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'dihapus');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
>>>>>>> 11c201eee95eba0f92577075e2d8ca9748faf997
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
