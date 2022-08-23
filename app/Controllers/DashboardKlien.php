<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ProgressProyekModel;
use App\Models\ModelLogin;
use App\Models\massagemodel;
use App\Models\ChatNotifModel;
use App\Models\ChatNotifKlienModel;
require VENDORPATH . '/autoload.php';
use Pusher;

class DashboardKLien extends Dashboard
{

    public function __construct()
    {
        parent::__construct();

        $this->datalogin['judul'] = 'Dashboard Klien';
        
        $ChatNotifKlienModel = new ChatNotifKlienModel();
        $qchat_notif_klien = $ChatNotifKlienModel->select('jumlah_notif')
                    ->where('id_chat_notif', session()->get('user_id'))
                    ->get()->getResult();
        $ac_notif_admin_perklien = array_column($qchat_notif_klien, 'jumlah_notif');
        // $semua_jumlah_notif = array_sum($ac_semua_jumlah_notif);
        if($ac_notif_admin_perklien==NULL){
            $ac_notif_admin_perklien[0]='0';
        }

        $this->datalogin += [
            'notif_admin_perklien' => $ac_notif_admin_perklien[0]
        ];


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

        $ChatNotifKlienModel = new ChatNotifKlienModel();
        // $ChatNotifModel->where('id_chat_notif', $id)->set([
        //     'jumlah_notif' => '',
        // ])->update();
        $qchat_notif_klien = $ChatNotifKlienModel->select('jumlah_notif')
                        ->where('id_chat_notif', $id_client)
                        ->get()->getResult();
        $ac_notif_admin_perklien = array_column($qchat_notif_klien, 'jumlah_notif');
        if($ac_notif_admin_perklien==NULL){
            $ac_notif_admin_perklien[0]='0';
        }

        $data = [
            'judul' => 'Dashboard Klien',
            'user_id' => $this->user_id,
            'username' => $this->username,
            'akun' => $akun,
            'massage' => $tampung,
            'notif_admin_perklien' => $ac_notif_admin_perklien[0],
            'klik' => $query->getResult() //NULL 
        ];
        return view('dashboard/klien/message', $data);
    }

    public function store2(){
        $id_admin = $_POST['id_admin'];
        $id_client = $_POST['id_client'];
        $nama_user = $_POST['nama_user'];
        $nama_client = $_POST['nama_client'];
        $pesan = $_POST['pesan'];
        $status = $_POST['status'];

        $data = array(
            'id_admin' => $id_admin,
            'id_client' => $id_client,
            'nama_user' => $nama_user,
            'nama_client' => $nama_client,
            'pesan' => $pesan,
            'status' => $status,
        );

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
        // $pusher = new Pusher\Pusher(
        //     '40ffd99f64d712cc1ceb',
        //     '6fa3735fd7909ba7255c',
        //     '1456878',
        //     $options
        //     );

        //ilangin jumlah notif pesan yg belum dibaca klien dari admin
        //cek apakah ada data-id jumlah notif
        $Tchat_notif_klien = $this->db->table('chat_notif_klien');
        $Tchat_notif_klien->select('*')
        ->where('id_chat_notif', $id_client);
        $qchat_notif_klien = $Tchat_notif_klien->get()->getResult();
        //jika ada
        if($qchat_notif_klien!=NULL){
            //update data-id lokal jumlah notif jadi 0 karena sudah dibaca
            $Tchat_notif_klien2 = $this->db->table('chat_notif_klien');
            $Tchat_notif_klien2->select('*')
            ->where('id_chat_notif', $id_client)
            ->set([
                'jumlah_notif' => '0',
                ])->update();

            //kirim pusher
            $qchat_notif_klien2 = $Tchat_notif_klien->get()->getResult();

            foreach($qchat_notif_klien2 as $key4){
                $data_pusher4[] = $key4;
            }
            
            $pusher->trigger('notif_klien_'.$id_client, 'my-event', $data_pusher4);
        }

        //update data status belum dibaca dari admin tabel chat
        $tbchat = $this->db->table('chat');
        $tbchat->select('*')
        ->where('id_client', $id_client)
        ->where('id_admin!=', '0')
        ->where('status', 'belum')
        ->set([
            'status' => 'sudah',
            ])->update();
        // $query5 = $tbchat->get()->getResult();


        //masukan data chat lokal tabel chat
        $modelmassage=new massagemodel();
        $modelmassage->insert($data);
        ///////////////////////////////

        //kirim pusher data-id tabel chat
        // $builder = $this->db->table('chat');
        // $builder->select('*')
        // ->where('id_client', $id_client);
        // $query = $builder->get()->getResult();
        
        // foreach($query as $key){
        //     $data_pusher[] = $key;
        // }
        
        // $pusher->trigger($id_client, 'my-event', $data_pusher);
        ///////////////////////////////////

        //jumlah semua notif pesan yg belum dibaca admin
        // $builder2 = $this->db->table('chat');
        // $builder2->select('*')
        // ->where('id_admin', $id_admin)
        // ->where('status', 'belum');
        // $query2 = $builder2->get()->getResult();

        // foreach($query2 as $key2){
        //     $data_pusher2[] = $key2;
        // }

        // $pusher->trigger('jumlah_notif_admin', 'my-event', $data_pusher2[]);
        /////////////////////////////////

        
        //hitung jumlah notif dari klien tabel chat
        $builder5 = $this->db->table('chat');
        $builder5->select('*')
        ->where('id_client', $id_client)
        ->where('id_admin', $id_admin)
        ->where('status', 'belum');
        $query5 = $builder5->get()->getResult();

        $DataN = array(
            'id_chat_notif' => $id_client,
            'jumlah_notif' => count($query5),
            'nama_user' => $this->username
        );

        //cek data-id tabel chat_notif
        $ChatNotifModel = new ChatNotifModel();
        $Tchat_notif = $this->db->table('chat_notif');
        $Tchat_notif->select('*')
        ->where('id_chat_notif', $id_client);
        $qchat_notif = $Tchat_notif->get()->getResult();

        //jika data id tabel chat_notif tidak ada
        if($qchat_notif==NULL){
            //masukkan data lokal
            $ChatNotifModel->insert($DataN);

            //kirim pusher
            // $Tchat_notif2 = $this->db->table('chat_notif');
            // $Tchat_notif2->select('*')
            // // ->where('id_chat_notif', $id_client);
            // $qchat_notif2 = $Tchat_notif2->get()->getResult();
        }
        //jika data id tabel chat_notif ada
        else{
            //update data lokal
            $ChatNotifModel->where('id_chat_notif', $id_client)->set([
            'jumlah_notif' => count($query5),
            'nama_user' => $this->username
            ])->update();

            //kirim pusher
            // $Tchat_notif2 = $this->db->table('chat_notif');
            // $Tchat_notif2->select('*')
            // // ->where('id_chat_notif', $id_client);
            // $qchat_notif2 = $Tchat_notif2->get()->getResult();
        }

        //kirim pusher
        $Tchat_notif2 = $this->db->table('chat_notif');
        $Tchat_notif2->select('*');
        // ->where('id_chat_notif', $id_client);
        $qchat_notif2 = $Tchat_notif2->get()->getResult();

        foreach($qchat_notif2 as $key3){
            $data_pusher3[] = $key3;
        }
        
        $pusher->trigger('notif_admin_perklien', 'my-event', $data_pusher3);
        ///////////////////////////////////////////////
        
        // //ilangin jumlah notif pesan yg belum dibaca klien dari admin
        // //cek apakah ada data-id jumlah notif
        // $Tchat_notif_klien = $this->db->table('chat_notif_klien');
        // $Tchat_notif_klien->select('*')
        // ->where('id_chat_notif', $id_client);
        // $qchat_notif_klien = $Tchat_notif_klien->get()->getResult();
        // //jika ada
        // if($qchat_notif_klien!=NULL){
        //     //update data-id lokal jumlah notif jadi 0 karena sudah dibaca
        //     $Tchat_notif_klien2 = $this->db->table('chat_notif_klien');
        //     $Tchat_notif_klien2->select('*')
        //     ->where('id_chat_notif', $id_client)
        //     ->set([
        //         'jumlah_notif' => '0',
        //         ])->update();

        //     //kirim pusher
        //     $qchat_notif_klien2 = $Tchat_notif_klien->get()->getResult();

        //     foreach($qchat_notif_klien2 as $key4){
        //         $data_pusher4[] = $key4;
        //     }
            
        //     $pusher->trigger('notif_klien_'.$id_client, 'my-event', $data_pusher4);
    
        //     // //ilangin data-id status pesan yg belum dibaca 
        //     // //menjadi sudah table chat
        //     // $Tchat5 = $this->db->table('chat');
        //     // $Tchat5->select('*')
        //     // ->where('id_client', $id_client)
        //     // ->where('id_admin!=', '0')
        //     // ->set([
        //     //     'status' => 'sudah',
        //     //     ])->update();

        //     // $qchat5 = $Tchat5->get()->getResult();
        //     // foreach($qchat5 as $key5){
        //     //     $data_pusher5[] = $key5;
        //     // }
            
        //     // //kirim pusher
        //     // $pusher->trigger($id_client, 'my-event', $data_pusher5);
    
        // }

        //ilangin data-id status pesan yg belum dibaca 
        //menjadi sudah table chat
        // $Tchat5 = $this->db->table('chat');
        // $Tchat5->select('*')
        // ->where('id_client', $id_client)
        // ->where('id_admin!=', '0')
        // ->set([
        //     'status' => 'sudah',
        //     ])->update();

        // $qchat5 = $Tchat5->get()->getResult();

        //masukan data chat
        $Tchat5 = $this->db->table('chat');
        $Tchat5->select('*')
        ->where('id_client', $id_client);

        $qchat5 = $Tchat5->get()->getResult();
        foreach($qchat5 as $key5){
            $data_pusher5[] = $key5;
        }
        
        //kirim pusher
        $pusher->trigger($id_client, 'my-event', $data_pusher5);

        //jumlah semua notif pesan yg belum dibaca admin
        $bud = $this->db->table('chat_notif');
        $bud->select('*');
        $qy2 = $bud->get()->getResult();
        $ac_notif_admin_perklien = array_column($qy2, 'jumlah_notif');
        $notif_admin_perklien = array_sum($ac_notif_admin_perklien);
        // $query2 = $builder2->get()->getResult();

        // foreach($qy2 as $ky2){
        //     $data_pur2[] = $ky2;
        // }
        // $pusher->trigger('jumlah_notif_admin', 'my-event', $data_pur2[]);
        
        $pusher->trigger('jumlah_notif_admin', 'my-event', array('jumlah_notif' => $notif_admin_perklien));
        /////////////////////////////////
        
        
        //ilangin jumlah notif table chat_notif perklien
        // $Tchat_notif2 = $this->db->table('chat_notif');
        // $Tchat_notif2->select('*')
        // ->where('id_client', $id_client)
        // ->where('id_admin!=', '0')
        // ->set([
        //     'status' => 'sudah',
        //     ])->update();
        // $qchat_notif2 = $Tchat_notif2->get()->getResult();

        // foreach($qchat_notif2 as $key5){
        //     $data_pusher5[] = $key5;
        // }
        
        // $pusher->trigger('notif_klien_'.$id_client, 'my-event', $data_pusher4);
    }

    //FUnction Query
    public function simpanajuanproyek()
    {
        $user_id = $this->request->getVar('user_id');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $lokasiproyek = $this->request->getVar('lokasiproyek');
        $catatan = $this->request->getVar('catatan');
        $idajuan = $this->kodeotomatis('pengajuan_proyek', 'idajuan', 'AJP001');
        $AjuanProyekModel = new AjuanProyekModel();
        $AjuanProyekModel->insert([
            'idajuan' => $idajuan,
            'user_id' => $user_id,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'lokasiproyek' => $lokasiproyek,
            'catatanproyek' => $catatan,
            'status_id' => '1'


        ]);
        session()->setFlashdata('pesan', 'berhasildiajukan');
        return redirect()->to(base_url('/klien'));
    }
}
