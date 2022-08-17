<?php

namespace App\Controllers;

use App\Models\MeetingModel;
use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBBRevisiModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganBOPRevisiModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\PerhitunganTenakerRevisiModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader


use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\massagemodel;

require VENDORPATH . '/autoload.php';

use Pusher;


class DashboardAdmin extends Dashboard
{

    public function __construct()
    {


        parent::__construct();
        $this->datalogin['judul'] = 'Dashboard Admin';
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
        $ajuanproyek = new AjuanProyekModel();
        $belumditinjau = $ajuanproyek->builder()->like('status_id', 1)->countAllResults();
        $diterima = $ajuanproyek->builder()->like('status_id', 2)->countAllResults();
        $ditolak = $ajuanproyek->builder()->like('status_id', 3)->countAllResults();
        $dikerjakan = $ajuanproyek->builder()->like('status_id', 4)->countAllResults();
        $dihitung = $ajuanproyek->builder()->like('revisi_id', 1)->countAllResults();
        $totalajuan = $ajuanproyek->builder()->countAll();

        $status = [
            'belumditinjau' => $belumditinjau,
            'diterima' => $diterima,
            'ditolak' => $ditolak,
            'dikerjakan' => $dikerjakan,
            'dihitung' => $dihitung,
            'totalajuan' => $totalajuan,

        ];
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query = $builder->get();


        $_SESSION['aktif'] = 'ajuan';
        $this->datalogin += [
            'dataajuan' => $query->getResult(),
            'status' => $status
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
        $getData = $query->getResult();

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'datauser';
        $this->datalogin += [
            'users' => $getData,
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
        $getData =  $modelajuan->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->where('revisi_id', 1)->findAll();

        // $modelajuan = new AjuanProyekModel();
        $builder1 = $this->db->table('pengajuan_proyek');
        $builder1->select('*');
        $builder1->select('status_ajuan.keterangan');
        $builder1->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder1->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $builder1->where('pengajuan_proyek.idajuan', $id);

        $query = $builder1->get();
        $datakirim = $query->getResultArray();
        $biaya = $this->gettotbiaya($id);
        if (!empty($datakirim)) {
            $idajuan = $datakirim[0]['idajuan'];
            $namaproyek = $datakirim[0]['namaproyek'];
            $jenisproyek = $datakirim[0]['jenisproyek'];
            $namaklien = $datakirim[0]['nama'];
            $idklien = $datakirim[0]['user_id'];
            $biayaproyek = $biaya;
        } else {
            $idajuan = '';
            $namaproyek = '';
            $jenisproyek = '';
            $namaklien = '';
            $idklien = '';
            $biayaproyek = '';
        }
        $builder2 = $this->db->table('proyek');
        $builder2->select('proyek.*,pengajuan_proyek.namaproyek,pengajuan_proyek.jenisproyek,akun.user_id,akun.nama');
        $builder2->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan');
        $builder2->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query = $builder2->get();
        $hasil = $query->getResultArray();
        // dd($hasil);
        // dd($hasil);
        $this->datalogin += [
            'dataajuan' => $getData,
            'kodeproyek' => $kodeproyek,
            'datakirim' => $datakirim,
            'idajuan' => $idajuan,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'namaklien' => $namaklien,
            'idklien' => $idklien,
            'proyek' => $hasil,
            'biaya' => $biayaproyek,

        ];


        return view('dashboard/admin/dataproyek', $this->datalogin);
    }
    public function message($id = NULL)
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';

        $modelmassage = new massagemodel();
        $tampung = $modelmassage->findAll();

        $tampung2 = $modelmassage->where('id_client', $id)->findAll(); //NULL
        $modelakun = new ModelLogin();
        $akun = $modelakun->findAll();

        // $id_client = $id;
        // $builder = $this->db->table('chat');
        // $builder->select('id_admin, id_client, nama_user')
        // ->where('id_client', $id_client)
        // ->where('id_admin !=', 0);
        // $query = $builder->get(1, 0); //NULL

        $data = [
            'judul' => 'Dashboard Admin',
            'id_admin' => NULL,
            'username' => NULL,
            'nama_client' => NULL,
            'id_client' => NULL,
            'akun' => $akun,
            'massage' => $tampung,
            'massage2' => $tampung2, //NULL
            // 'klik' => $query->getResult() //NULL 
        ];
        if ($id != NULL) {
            $modelmassage2 = new massagemodel();
            $tampung2 = $modelmassage2->where('id_client', $id)->findAll();
            $tampung = $modelmassage->findAll();

            $akunclient = $modelakun->select('user_name')->where('user_id', $id)->get()->getResult();
            $nama_client = array_column($akunclient, 'user_name');

            // $id_client = $id;
            // $builder = $this->db->table('chat');
            // $builder->select('id_admin, id_client, nama_user')
            // ->where('id_client', $id_client)
            // ->where('id_admin !=', 0);
            // $query = $builder->get(1, 0);//1 baris
            // echo '<script>console.log('.print_r($query->getResult()).')</script>';

            // echo '<script>console.log('.$nama_client[0].')</script>';
            // echo '<script>console.log('.$id_client.')</script>';

            $data2 = [
                'judul' => 'Dashboard Admin',
                'id_admin' => $this->user_id,
                'username' => $this->username,
                'nama_client' => $nama_client[0],
                'id_client' => $id,
                'akun' => $akun,
                'massage' => $tampung,
                'massage2' => $tampung2,
                // 'klik' => $query->getResult()
            ];

            return view('dashboard/admin/message', $data2);
        }


        return view('dashboard/admin/message', $data);
    }

    public function perhitunganbiayarevisi($id = '')
    {

        if (!empty($id)) {
            $bbrevisi = new PerhitunganBBRevisiModel();
            $hasilbb = $bbrevisi->where('id_pbb', $id)->findAll();
            $tkrevisi = new PerhitunganTenakerRevisiModel();
            $hasiltk = $tkrevisi->where('id_pbtenaker', $id)->findAll();
            $boprevisi = new PerhitunganBOPRevisiModel();
            $hasilbop = $boprevisi->where('id_pbop', $id)->findAll();
            if ((!empty($hasilbb) || !empty($hasilbop) || !empty($hasiltk))) {
                return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
            } else {
                $ambilhuruf = substr($id, 0, 3);
                if ($ambilhuruf == 'PBB') {
                    $bukaform = [
                        'bukaform' => 'bahanbaku'
                    ];
                    $bb = new PerhitunganBBModel();
                    $builder = $bb->builder();
                    $builder->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan');
                    $getarraybb = $builder->where('id_pbb', $id)->get()->getResultArray();
                    $getDataBB = [
                        'id_pbb' =>  $getarraybb[0]['id_pbb'],
                        'idajuan' =>  $getarraybb[0]['idajuan'],
                        'user_id' =>  $getarraybb[0]['user_id'],
                        'namaproyek' =>  $getarraybb[0]['namaproyek'],
                        'namabahan' =>  $getarraybb[0]['namabahan'],
                        'ukuran' =>  $getarraybb[0]['ukuran'],
                        'kualitas' =>  $getarraybb[0]['kualitas'],
                        'jenis' =>  $getarraybb[0]['jenis'],
                        'berat' =>  $getarraybb[0]['berat'],
                        'ketebalan' =>  $getarraybb[0]['ketebalan'],
                        'panjang' =>  $getarraybb[0]['panjang'],
                        'harga' =>  $getarraybb[0]['harga'],
                        'jumlah_beli' =>  $getarraybb[0]['jumlah_beli'],
                        'total_harga' =>  $getarraybb[0]['total_harga'],
                    ];
                    $getDataBOP = [
                        'id_pbop' =>  '',
                        'idajuan' =>  '',
                        'user_id' =>  '',
                        'namaproyek' =>  '',
                        'namatrans' =>  '',
                        'tot_biaya' =>  '',
                    ];
                    $getDataTK = [
                        'id_pbtenaker' =>  '',
                        'idajuan' =>  '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'jenispekerjaan' =>  '',
                        'gaji' =>  '',
                        'hari' => '',
                        'total_pekerja' => '',
                        'total_gaji' =>  '',
                    ];
                } elseif ($ambilhuruf == 'PBO') {
                    $bukaform = [
                        'bukaform' => 'bop'
                    ];
                    $bop = new PerhitunganBOPModel();
                    $builder = $bop->builder();
                    $builder->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan');
                    $getarraybop = $builder->where('id_pbop', $id)->get()->getResultArray();
                    $getDataBOP = [
                        'id_pbop' =>  $getarraybop[0]['id_pbop'],
                        'idajuan' =>  $getarraybop[0]['idajuan'],
                        'user_id' =>  $getarraybop[0]['user_id'],
                        'namaproyek' =>  $getarraybop[0]['namaproyek'],
                        'namatrans' =>  $getarraybop[0]['namatrans'],
                        'tot_biaya' =>  $getarraybop[0]['tot_biaya'],
                    ];
                    $getDataBB = [
                        'id_pbb' =>  '',
                        'idajuan' => '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'namabahan' =>  '',
                        'ukuran' =>  '',
                        'kualitas' =>  '',
                        'jenis' =>  '',
                        'berat' => '',
                        'ketebalan' => '',
                        'panjang' =>  '',
                        'harga' =>  '',
                        'jumlah_beli' => '',
                        'total_harga' =>  '',
                    ];
                    $getDataTK = [
                        'id_pbtenaker' =>  '',
                        'idajuan' =>  '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'jenispekerjaan' =>  '',
                        'gaji' =>  '',
                        'hari' => '',
                        'total_pekerja' => '',
                        'total_gaji' =>  '',
                    ];
                } elseif ($ambilhuruf == 'PBT') {
                    $bukaform = [
                        'bukaform' => 'tenaker'
                    ];
                    session()->getFlashdata('bukaform', 'tenaker');
                    $tk = new PerhitunganTenakerModel();
                    $builder = $tk->builder();
                    $builder->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan');
                    $getarraytk = $builder->where('id_pbtenaker', $id)->get()->getResultArray();
                    $getDataTK = [
                        'id_pbtenaker' =>  $getarraytk[0]['id_pbtenaker'],
                        'idajuan' =>  $getarraytk[0]['idajuan'],
                        'user_id' =>  $getarraytk[0]['user_id'],
                        'namaproyek' =>  $getarraytk[0]['namaproyek'],
                        'jenispekerjaan' =>  $getarraytk[0]['jenispekerjaan'],
                        'gaji' =>  $getarraytk[0]['gaji'],
                        'hari' =>  $getarraytk[0]['hari'],
                        'total_pekerja' =>  $getarraytk[0]['total_pekerja'],
                        'total_gaji' =>  $getarraytk[0]['total_gaji'],
                    ];
                    $getDataBOP = [
                        'id_pbop' =>  '',
                        'idajuan' =>  '',
                        'user_id' =>  '',
                        'namaproyek' =>  '',
                        'namatrans' =>  '',
                        'tot_biaya' =>  '',
                    ];
                    $getDataBB = [
                        'id_pbb' =>  '',
                        'idajuan' => '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'namabahan' =>  '',
                        'ukuran' =>  '',
                        'kualitas' =>  '',
                        'jenis' =>  '',
                        'berat' => '',
                        'ketebalan' => '',
                        'panjang' =>  '',
                        'harga' =>  '',
                        'jumlah_beli' => '',
                        'total_harga' =>  '',
                    ];
                } else {
                    $bukaform = [
                        'bukaform' => ''
                    ];
                    $getDataBOP = [
                        'id_pbop' =>  '',
                        'idajuan' =>  '',
                        'user_id' =>  '',
                        'namaproyek' =>  '',
                        'namatrans' =>  '',
                        'tot_biaya' =>  '',
                    ];
                    $getDataBB = [
                        'id_pbb' =>  '',
                        'idajuan' => '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'namabahan' =>  '',
                        'ukuran' =>  '',
                        'kualitas' =>  '',
                        'jenis' =>  '',
                        'berat' => '',
                        'ketebalan' => '',
                        'panjang' =>  '',
                        'harga' =>  '',
                        'jumlah_beli' => '',
                        'total_harga' =>  '',
                    ];
                    $getDataTK = [
                        'id_pbtenaker' =>  '',
                        'idajuan' =>  '',
                        'user_id' => '',
                        'namaproyek' =>  '',
                        'jenispekerjaan' =>  '',
                        'gaji' =>  '',
                        'hari' => '',
                        'total_pekerja' => '',
                        'total_gaji' =>  '',
                    ];
                }
            }
        } else {
            $bukaform = [
                'bukaform' => ''
            ];
            $getDataBOP = [
                'id_pbop' =>  '',
                'idajuan' =>  '',
                'user_id' =>  '',
                'namaproyek' =>  '',
                'namatrans' =>  '',
                'tot_biaya' =>  '',
            ];
            $getDataBB = [
                'id_pbb' =>  '',
                'idajuan' => '',
                'user_id' => '',
                'namaproyek' =>  '',
                'namabahan' =>  '',
                'ukuran' =>  '',
                'kualitas' =>  '',
                'jenis' =>  '',
                'berat' => '',
                'ketebalan' => '',
                'panjang' =>  '',
                'harga' =>  '',
                'jumlah_beli' => '',
                'total_harga' =>  '',
            ];
            $getDataTK = [
                'id_pbtenaker' =>  '',
                'idajuan' =>  '',
                'user_id' => '',
                'namaproyek' =>  '',
                'jenispekerjaan' =>  '',
                'gaji' =>  '',
                'hari' => '',
                'total_pekerja' => '',
                'total_gaji' =>  '',
            ];
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $this->datalogin += [
            'bb' =>  $getDataBB,
            'bop' => $getDataBOP,
            'tk' => $getDataTK,
            'bukaform' => $bukaform
        ];
        $_SESSION['aktif'] = 'perhitunganbiayarevisi';
        return view('dashboard/admin/perhitunganrevisi', $this->datalogin);
    }

    public function store()
    {
        $modelmassage = new massagemodel();

        $id_admin = $_POST['id_admin'];
        $id_client = $_POST['id_client'];
        $nama_user = $_POST['nama_user'];
        $nama_client = $_POST['nama_client'];
        $pesan = $_POST['pesan'];

        echo '<script>console.log(' . $id_client . ')</script>';

        $data = array(
            'id_admin' => $id_admin,
            'id_client' => $id_client,
            'nama_user' => $nama_user,
            'nama_client' => $nama_client,
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

        foreach ($query as $key) {
            $data_pusher[] = $key;
        }

        $pusher->trigger($id_client, 'my-event', $data_pusher);
        echo json_encode($query);
    }

    public function perhitunganbiaya($id = '')
    {
        $modelajuan = new AjuanProyekModel();

        if (!empty($id)) {
            $getdata =  $modelajuan->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->orWhere('status_id', '7')->orWhere('status_id', '8')->where('idajuan', $id)->first();
            if (!empty($getdata)) {
                $DataKirim = [
                    'idajuan' => $getdata['idajuan'],
                    'user_id' => $getdata['user_id'],
                    'namaproyek' => $getdata['namaproyek']
                ];
            } else {
                $DataKirim =  [
                    'idajuan' => '',
                    'user_id' => '',
                    'namaproyek' => ''
                ];
            }
        } else {
            $DataKirim =  [
                'idajuan' => '',
                'user_id' => '',
                'namaproyek' => ''
            ];
        }
        $getData = $modelajuan->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->findAll();
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $this->datalogin += [
            'dataajuan' => $getData,
            'datakirim' => $DataKirim,
        ];
        $_SESSION['aktif'] = 'perhitunganbiaya';
        return view('dashboard/admin/perhitunganbiaya', $this->datalogin);
    }


    ////Method untuk menjalankan query

    public function buatproyek()
    {
        $idproyek = $this->request->getVar('idproyek');
        $idajuan = $this->request->getVar('idajuan');
        $iduser = $this->request->getVar('user_id');
        $namaproyek = $this->request->getVar('namaproyek');

        $biaya = $this->request->getVar('biaya');
        $biaya =  (int)(filter_var($biaya, FILTER_SANITIZE_NUMBER_INT));
        $sudahbayar = $this->request->getVar('sudahbayar');
        $sudahbayar = (int)(filter_var($sudahbayar, FILTER_SANITIZE_NUMBER_INT));
        $belumbayar = $this->request->getVar('belumbayar');
        $belumbayar = (int)(filter_var($belumbayar, FILTER_SANITIZE_NUMBER_INT));
        $modelproyek = new ProyekModel();
        $idprogress = $this->kodeotomatis('progress_proyek', 'idprogress', 'PRG001');
        $modelprogressproyek = new ProgressProyekModel();

        $modelproyek->insert([
            'idproyek' => $idproyek,
            'idajuan' => $idajuan,
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
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $builder->where('idajuan', $id);
        $query = $builder->get();
        $getdata = $query->getResult();
        $biaya = $this->gettotbiaya($id);
        $data = [
            'data' => $getdata,
            'biaya' => $biaya
        ];

        echo json_encode($data);
    }

    public function terimaajuan($id = false)
    {
        $modelajuan = new AjuanProyekModel();
        $modelajuan->where('idajuan', $id)->set(['status_id' => 2])->update();

        $getData = $this->db->table('pengajuan_proyek');
        $getData->select('*');
        $getData->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query =  $getData->where('idajuan', 'AJP001')->get();
        $hasil = $query->getResultArray();
        $namaproyek = $hasil[0]['namaproyek'];
        $namaklien = $hasil[0]['nama'];
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
        $getData = $this->db->table('pengajuan_proyek');
        $getData->select('*');
        $getData->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query =  $getData->where('idajuan', 'AJP001')->get();
        $hasil = $query->getResultArray();
        $namaproyek = $hasil[0]['namaproyek'];
        $namaklien = $hasil[0]['nama'];
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'ditolak');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function hapusajuan($id)
    {
        $modelajuan = new AjuanProyekModel();
        $getData = $this->db->table('pengajuan_proyek');
        $getData->select('*');
        $getData->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query =  $getData->where('idajuan', 'AJP001')->get();
        $hasil = $query->getResultArray();
        $namaproyek = $hasil[0]['namaproyek'];
        $namaklien = $hasil[0]['nama'];
        $modelajuan->delete($id);
        session()->setFlashdata('namaproyek', $namaproyek);
        session()->setFlashdata('namaklien', $namaklien);
        session()->setFlashdata('pesan', 'dihapus');
        return redirect()->to(base_url() . '/admin/ajuanproyek');
    }
    public function getmeeting($id)
    {
        $meeting = new MeetingModel();
        $data = $meeting->where('idajuan', $id)->first();
        echo json_encode($data);
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
    public function tableuser()
    {
        $builder = $this->db->table('akun');
        $builder->select('*');
        $builder->select('level.levelnama');
        $builder->join('level', 'akun.user_level=level.user_level');
        $query = $builder->get();
        $getData = $query->getResult();
        $data = [
            'users' => $getData,
        ];
        $kirimAJax = [
            'data' => view('dashboard/admin/table/tableuser', $data),
        ];
        echo json_encode($kirimAJax);
    }
    public function getUser()
    {
        $id = $_POST['id'];
        $getuser = new ModelLogin();
        echo json_encode($getuser->where('user_id', $id)->findAll());
    }

    //Perhitungan Biaya Bahan Baku
    public function getuseridajuan()
    {

        $modelajuan = new AjuanProyekModel();

        if ($this->request->isAJAX()) {
            $idajuan = $this->request->getVar('id');
            $builder = $modelajuan->builder();
            $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
            $builder->where('idajuan', $idajuan)->where('status_id', '2');
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }

    public function hapusperhitunganbb($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitunganbbmodel = new PerhitunganBBModel();
            $perhitunganbbmodel->delete($id);
            $builder = $perhitunganbbmodel->builder();
            $getaffectedrow = $builder->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function simpanperhitunganbb()
    {

        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuanbb' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jumlahbeli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'namabahan' => [
                    'label' => 'Nama Bahan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbb'),
                        'errorharga' => $validation->getError('harga'),
                        'errorjumlahbeli' => $validation->getError('jumlahbeli'),
                        'errornamabahan' => $validation->getError('namabahan'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $harga = $this->request->getVar('harga');
                $harga = (int)(filter_var($harga, FILTER_SANITIZE_NUMBER_INT));
                $totalharga = $this->request->getVar('totalharga');
                $totalharga = (int)(filter_var($totalharga, FILTER_SANITIZE_NUMBER_INT));
                $idpbb = $this->kodeotomatis('perhitunganbahanbaku', 'id_pbb', 'PBB001');

                $perhitunganbbmodel = new PerhitunganBBModel();

                $simpandata = [
                    'id_pbb' => $idpbb,
                    'idajuan' => $this->request->getVar('idajuanbb'),
                    'namabahan' => $this->request->getVar('namabahan'),
                    'ukuran' => $this->request->getVar('ukuran'),
                    'jenis' => $this->request->getVar('jenis'),
                    'kualitas' => $this->request->getVar('kualitas'),
                    'berat' => $this->request->getVar('berat'),
                    'ketebalan' => $this->request->getVar('tebal'),
                    'panjang' => $this->request->getVar('panjang'),
                    'harga' => $harga,
                    'jumlah_beli' => $this->request->getVar('jumlahbeli'),
                    'total_harga' => $totalharga,
                    'revisi_id' => 1,

                ];
                $perhitunganbbmodel->insert($simpandata);
                $ajuan = new AjuanProyekModel();
                $getdata = $ajuan->where('idajuan', $this->request->getVar('idajuanbb'))->where('revisi_id', '1')->findAll();
                if (empty($getdata)) {
                    $ajuan->builder()->where('idajuan', $this->request->getVar('idajuanbb'))
                        ->set('revisi_id', 1)->update();
                }
                //         //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //         //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganbbmodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function updateperhitunganbb($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuanbb' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jumlahbeli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'namabahan' => [
                    'label' => 'Nama Bahan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbb'),
                        'errorharga' => $validation->getError('harga'),
                        'errorjumlahbeli' => $validation->getError('jumlahbeli'),
                        'errornamabahan' => $validation->getError('namabahan'),
                    ],
                ];
                echo json_encode($msg);
            } else {

                $harga = $this->request->getVar('harga');
                $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
                $totalharga = $this->request->getVar('totalharga');
                $totalharga = (int)filter_var($totalharga, FILTER_SANITIZE_NUMBER_INT);
                $perhitunganbbmodel = new PerhitunganBBModel();
                $updatedata = [
                    'idajuan' => $this->request->getVar('idajuanbb'),
                    'namabahan' => $this->request->getVar('namabahan'),
                    'ukuran' => $this->request->getVar('ukuran'),
                    'jenis' => $this->request->getVar('jenis'),
                    'kualitas' => $this->request->getVar('kualitas'),
                    'berat' => $this->request->getVar('berat'),
                    'ketebalan' => $this->request->getVar('tebal'),
                    'panjang' => $this->request->getVar('panjang'),
                    'harga' => $harga,
                    'jumlah_beli' => $this->request->getVar('jumlahbeli'),
                    'total_harga' => $totalharga,

                ];

                $perhitunganbbmodel->where('id_pbb', $id)
                    ->set($updatedata)
                    ->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganbbmodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $data = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyekbb'),
                    'notifajuan' => $this->request->getVar('idajuanbb')
                ];
                echo json_encode($data);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdataperhitunganbb()

    {
        $perhitunganbb = new PerhitunganBBModel();


        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitunganbb->builder();
            $builder->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->where('id_pbb', $id)->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }

    // End Perhitungan Biaya Bahan Baku

    //Perhitungan Biaya Tenaga Kerja 
    public function getdataperhitunganbbrevisi()
    {
        $perhitunganbbrevisi = new PerhitunganBBRevisiModel();


        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitunganbbrevisi->builder();
            $builder->select('perhitunganbbrevisi.*,pengajuan_proyek.namaproyek,pengajuan_proyek.user_id,pengajuan_proyek.idajuan')->join('perhitunganbahanbaku', 'perhitunganbbrevisi.id_pbb=perhitunganbahanbaku.id_pbb')
                ->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->where('id_pbbr', $id)->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdataperhitungantkrevisi()
    {
        $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();


        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitungantkrevisi->builder();
            $builder->select('perhitungantenakerrevisi.*,pengajuan_proyek.namaproyek,pengajuan_proyek.user_id,pengajuan_proyek.idajuan')->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')
                ->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->where('id_pbtenakerr', $id)->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdataperhitunganboprevisi($id = false)
    {
        $perhitunganboprevisi = new PerhitunganBOPRevisiModel();


        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitunganboprevisi->builder();
            $builder->select('perhitunganboprevisi.*,pengajuan_proyek.namaproyek,pengajuan_proyek.user_id,pengajuan_proyek.idajuan')->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')
                ->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan');
            $builder = $builder->where('id_pbopr', $id)->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function hapusperhitungantk($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitungantkmodel = new PerhitunganTenakerModel();
            $perhitungantkmodel->delete($id);
            $builder = $perhitungantkmodel->builder();
            $getaffectedrow = $builder->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function updateperhitungantk($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuantk' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jenispekerjaan' => [
                    'label' => 'Jenis Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalpekerja' => [
                    'label' => 'Total Pekerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuantk'),
                        'errorjenispekerjaan' => $validation->getError('jenispekerjaan'),
                        'errorgaji' => $validation->getError('gaji'),
                        'errortotalpekerja' => $validation->getError('totalpekerja'),
                    ],
                ];
                echo json_encode($msg);
            } else {


                $gaji = $this->request->getVar('gaji');
                $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
                $perhitungantkmodel = new PerhitunganTenakerModel();
                $totalgaji = $this->request->getVar('totalgaji');
                $totalgaji = (int)filter_var($totalgaji, FILTER_SANITIZE_NUMBER_INT);
                $updatedata = [
                    'idajuan' => $this->request->getVar('idajuantk'),
                    'jenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                    'gaji' => $gaji,
                    'hari' => $this->request->getVar('hari'),
                    'total_pekerja' => $this->request->getVar('totalpekerja'),
                    'total_gaji' => $totalgaji,

                ];
                $perhitungantkmodel->where('id_pbtenaker', $id)
                    ->set($updatedata)
                    ->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitungantkmodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $data = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyektk'),
                    'notifajuan' => $this->request->getVar('idajuantk')
                ];
                echo json_encode($data);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdataperhitungantk()
    {
        $perhitungantenaker = new PerhitunganTenakerModel();
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitungantenaker->builder();
            $builder =  $builder->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan')->where('id_pbtenaker', $id);
            $builder = $builder->get();
            $getData = $builder->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function simpanperhitungantenaker()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuantk' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jenispekerjaan' => [
                    'label' => 'Jenis Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalpekerja' => [
                    'label' => 'Total Pekerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuantk'),
                        'errorjenispekerjaan' => $validation->getError('jenispekerjaan'),
                        'errortotalpekerja' => $validation->getError('totalpekerja'),
                        'errorgaji' => $validation->getError('gaji'),
                        'errorhari' => $validation->getError('hari'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $gaji = $this->request->getVar('gaji');
                $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
                $totalgaji = $this->request->getVar('totalgaji');
                $totalgaji = (int)filter_var($totalgaji, FILTER_SANITIZE_NUMBER_INT);
                $perhitungantenakermodel = new PerhitunganTenakerModel();
                $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PBT001');
                $ajuan = new AjuanProyekModel();
                $simpandata = [
                    'id_pbtenaker' => $id_pbtenaker,
                    'idajuan' => $this->request->getVar('idajuantk'),
                    'jenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                    'gaji' => $gaji,
                    'hari' => $this->request->getVar('hari'),
                    'total_pekerja' => $this->request->getVar('totalpekerja'),
                    'total_gaji' => $totalgaji,
                    'revisi_id' => 1

                ];
                $perhitungantenakermodel->insert($simpandata);
                $ajuan = new AjuanProyekModel();
                $getdata = $ajuan->where('idajuan', $this->request->getVar('idajuantk'))->where('revisi_id', '1')->findAll();
                if (empty($getdata)) {
                    $ajuan->builder()->where('idajuan', $this->request->getVar('idajuantk'))
                        ->set('revisi_id', 1)->update();
                }
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitungantenakermodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    //End Perhitungan Biaya Tenaker

    //Perhitungan Biaya Bop
    public function hapusperhitunganbop($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitunganbop = new PerhitunganBOPModel();
            $perhitunganbop->delete($id);
            $builder = $perhitunganbop->builder();
            $getaffectedrow = $builder->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function updateperhitunganbop($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'namatransaksi' => [
                    'label' => 'Nama Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'idajuanbop' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalbiaya' => [
                    'label' => 'Total Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbop'),
                        'errornamatransaksi' => $validation->getError('namatransaksi'),
                        'errortotalbiaya' => $validation->getError('totalbiaya'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $totbiaya = $this->request->getVar('totalbiaya');
                $totbiaya = (int)filter_var($totbiaya, FILTER_SANITIZE_NUMBER_INT);
                $perhitunganbopmodel = new PerhitunganBOPModel();
                $updatedata = [
                    'idajuan' => $this->request->getVar('idajuanbop'),
                    'namatrans' => $this->request->getVar('namatransaksi'),
                    'tot_biaya' => $totbiaya,

                ];
                $perhitunganbopmodel->where('id_pbop', $id)
                    ->set($updatedata)
                    ->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganbopmodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyekbop'),
                    'notifajuan' => $this->request->getVar('idajuanbop')
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function simpanperhitunganbop()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'namatransaksi' => [
                    'label' => 'Nama Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'idajuanbop' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalbiaya' => [
                    'label' => 'Total Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbop'),
                        'errornamatransaksi' => $validation->getError('namatransaksi'),
                        'errortotalbiaya' => $validation->getError('totalbiaya'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $totbiaya = $this->request->getVar('totalbiaya');
                $totbiaya = (int)filter_var($totbiaya, FILTER_SANITIZE_NUMBER_INT);
                $perhitunganbopmodel = new PerhitunganBOPModel();
                $id_pbop = $this->kodeotomatis('perhitunganbop', 'id_pbop', 'PBO001');
                $ajuan = new AjuanProyekModel();
                $simpandata = [
                    'id_pbop' => $id_pbop,
                    'idajuan' => $this->request->getVar('idajuanbop'),
                    'namatrans' => $this->request->getVar('namatransaksi'),
                    'tot_biaya' => $totbiaya,
                    'revisi_id' => 1

                ];
                $perhitunganbopmodel->insert($simpandata);
                $ajuan = new AjuanProyekModel();
                $getdata = $ajuan->where('idajuan', $this->request->getVar('idajuanbop'))->where('revisi_id', '1')->findAll();
                if (empty($getdata)) {
                    $ajuan->builder()->where('idajuan', $this->request->getVar('idajuanbop'))
                        ->set('revisi_id', 1)->update();
                }
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganbopmodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdataperhitunganbop()
    {
        $perhitunganbop = new PerhitunganBOPModel();
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $builder = $perhitunganbop->builder();
            $builder = $builder->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan')->where('id_pbop', $id)->get();
            $getData = $builder->getResultArray();

            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function tampiltotal($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitunganbop = new PerhitunganBOPModel();
            $perhitunganbb = new PerhitunganBBModel();
            $perhitungantk = new PerhitunganTenakerModel();

            $builder1 = $perhitunganbop->builder();
            $builder1->where('idajuan', $id)->selectSum('tot_biaya');
            $query = $builder1->get();
            $sumbop = $query->getResultArray();
            $sumbop = intval($sumbop[0]['tot_biaya']);

            $builder2 = $perhitunganbb->builder();
            $builder2->where('idajuan', $id)->selectSum('total_harga');
            $query = $builder2->get();
            $sumbb = $query->getResultArray();
            $sumbb = intval($sumbb[0]['total_harga']);

            $builder3 = $perhitungantk->builder();
            $builder3->where('idajuan', $id)->selectSum('total_gaji');
            $query = $builder3->get();
            $sumtk = $query->getResultArray();
            $sumtk = intval($sumtk[0]['total_gaji']);
            $sumall = $sumbb + $sumbop + $sumtk;
            echo json_encode(number_format($sumall, 0, ",", "."));
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function printperhitunganbiaya($id = '')

    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
        $perhitunganbop = new PerhitunganBOPModel();
        $perhitunganbb = new PerhitunganBBModel();
        $perhitungantk = new PerhitunganTenakerModel();
        $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
        $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
        $perhitunganboprevisi = new PerhitunganBOPRevisiModel();

        $builder1 = $perhitunganbop->builder();
        $builder1->where('idajuan', $id)->selectSum('tot_biaya');
        $query = $builder1->get();
        $sumbop = $query->getResultArray();
        $sumbop = intval($sumbop[0]['tot_biaya']);


        $builder2 = $perhitunganbb->builder();
        $builder2->where('idajuan', $id)->selectSum('total_harga');
        $query = $builder2->get();
        $sumbb = $query->getResultArray();
        $sumbb = intval($sumbb[0]['total_harga']);

        $builder3 = $perhitungantk->builder();
        $builder3->where('idajuan', $id)->selectSum('total_gaji');
        $query = $builder3->get();
        $sumtk = $query->getResultArray();
        $sumtk = intval($sumtk[0]['total_gaji']);

        $sumall = $sumbb + $sumbop + $sumtk;


        $perhitunganbbmodel = new PerhitunganBBModel();
        $getdatabb = $perhitunganbbmodel->where('idajuan', $id)->findAll();

        $perhitungantenakermodel = new PerhitunganTenakerModel();
        $getdatatk = $perhitungantenakermodel->where('idajuan', $id)->findAll();

        $perhitunganbopmodel = new PerhitunganBOPModel();
        $getdatabop = $perhitunganbopmodel->where('idajuan', $id)->findAll();

        $pengajuanproyekmodel = new AjuanProyekModel();
        $builder = $pengajuanproyekmodel->builder();
        $builder = $builder->select('*');
        $builder = $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->where('idajuan', $id);
        $query = $builder->get();
        $getdatauser = $query->getResultArray();

        if (empty($sumbb && $sumbop && $sumtk && $sumall && $getdatauser)) {
            session()->setFlashdata('pesanprint', 'Data Belum Terisi Semua !, Silakan Lengkapi Data!');
            return redirect()->to(base_url() . '/admin/perhitunganbiaya');
        } else {

            $data = [
                'bb' => $getdatabb,
                'tk' => $getdatatk,
                'bop' => $getdatabop,
                'user' => $getdatauser,
                'sumbop' => $sumbop,
                'tanggal' => $tanggal,
                'sumbb' => $sumbb,
                'sumtk' => $sumtk,
                'sumall' => $sumall

            ];

            // instantiate and use the dompdf class
            $html = view('dashboard/admin/printperhitunganbiaya', $data);
            $dompdf = new Dompdf();

            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser

            $dompdf->stream('Proposal Ajuan' . '-' . $getdatauser[0]['idajuan'] . '-' . $getdatauser[0]['nama'] . ".pdf", array("Attachment" => false));
        };
    }
    public function redirectkelola($idproyek, $idajuan)
    {
        session()->set('kelolaproyek', 'true');
        session()->set('idproyek', $idproyek);
        session()->set('idajuan', $idajuan);
        return redirect()->to(base_url('kelolaproyek'));
    }

    //Perhitungan Biaya revisi
    public function getdatapbb()
    {
        $bbmodel = new PerhitunganBBModel();

        if ($this->request->isAJAX()) {
            $id_pbb = $this->request->getVar('id');
            $builder = $bbmodel->builder();
            $builder->join('pengajuan_proyek', 'perhitunganbahanbaku.idajuan=pengajuan_proyek.idajuan');
            $getData = $builder->where('id_pbb', $id_pbb)->get()->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function getdatapbtk()
    {
        $tkmodel = new PerhitunganTenakerModel();
        if ($this->request->isAJAX()) {
            $id_pbtk = $this->request->getVar('id');
            $builder = $tkmodel->builder();
            $builder->join('pengajuan_proyek', 'perhitungantenaker.idajuan=pengajuan_proyek.idajuan');
            $getData = $builder->where('id_pbtenaker', $id_pbtk)->get()->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function getdatapbop()
    {

        $bopmodel = new PerhitunganBOPModel();
        if ($this->request->isAJAX()) {
            $id_pbop = $this->request->getVar('id');
            $builder = $bopmodel->builder();
            $builder->join('pengajuan_proyek', 'perhitunganbop.idajuan=pengajuan_proyek.idajuan');
            $getData = $builder->where('id_pbop', $id_pbop)->get()->getResultArray();
            echo json_encode($getData);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function simpanrevisibb()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'id_pbb' => [
                    'label' => 'Id Biaya BB',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ],
                ],
                'jumlahbeli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorid_pbb' => $validation->getError('id_pbb'),
                        'errorharga' => $validation->getError('harga'),
                        'errorjumlahbeli' => $validation->getError('jumlahbeli'),

                    ],
                ];
                echo json_encode($msg);
            } else {

                $harga = $this->request->getVar('harga');
                $harga = (int)(filter_var($harga, FILTER_SANITIZE_NUMBER_INT));
                $totalharga = $this->request->getVar('totalharga');
                $totalharga = (int)(filter_var($totalharga, FILTER_SANITIZE_NUMBER_INT));
                $id_pbbr = $this->kodeotomatis('perhitunganbbrevisi', 'id_pbbr', 'PBR001');

                $pbbrevisi = new PerhitunganBBRevisiModel();
                $pbb = new PerhitunganBBModel();
                $simpandata = [
                    'id_pbbr' => $id_pbbr,
                    'id_pbb' => $this->request->getVar('id_pbb'),
                    'idajuan' => $this->request->getVar('idajuanbb'),
                    'namabahan' => $this->request->getVar('namabahan'),
                    'ukuran' => $this->request->getVar('ukuran'),
                    'jenis' => $this->request->getVar('jenis'),
                    'kualitas' => $this->request->getVar('kualitas'),
                    'berat' => $this->request->getVar('berat'),
                    'ketebalan' => $this->request->getVar('tebal'),
                    'panjang' => $this->request->getVar('panjang'),
                    'harga' => $harga,
                    'jumlah_beli' => $this->request->getVar('jumlahbeli'),
                    'total_harga' => $totalharga,
                    'revisi_id' => 3

                ];
                $pbbrevisi->insert($simpandata);
                $builder = $pbb->builder();
                $builder->set('revisi_id', 2)->where('id_pbb', $this->request->getVar('id_pbb'))->update();
                // query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                // optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $pbbrevisi->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                    'notifid_pbb' => $this->request->getVar('id_pbb'),
                    'notifnamabahan' => $this->request->getVar('namabahan'),
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function simpanboprevisi()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'id_pbop' => [
                    'label' => 'Id Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalbiaya' => [
                    'label' => 'Total Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorid_pbop' => $validation->getError('id_pbop'),
                        'errortotalbiaya' => $validation->getError('totalbiaya'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $totbiaya = $this->request->getVar('totalbiaya');
                $totbiaya = (int)filter_var($totbiaya, FILTER_SANITIZE_NUMBER_INT);
                $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
                $id_pbopr = $this->kodeotomatis('perhitunganboprevisi', 'id_pbopr', 'POR001');
                $pob = new PerhitunganBOPModel();
                $simpandata = [
                    'id_pbopr' => $id_pbopr,
                    'idajuan' => $this->request->getVar('idajuanbop'),
                    'id_pbop' => $this->request->getVar('id_pbop'),
                    'namatrans' => $this->request->getVar('namatransaksi'),
                    'tot_biaya' => $totbiaya,
                    'revisi_id' => 3

                ];
                $perhitunganboprevisi->insert($simpandata);
                $builder = $pob->builder();
                $builder->set('revisi_id', 2)->where('id_pbop', $this->request->getVar('id_pbop'))->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganboprevisi->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                    'notifid_pbop' => $this->request->getVar('id_pbop'),
                    'notifnamatrans' => $this->request->getVar('namatransaksi'),
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function simpanperhitungantenakerrevisi()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'id_pbtenaker' => [
                    'label' => 'ID Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalpekerja' => [
                    'label' => 'Total Pekerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'errorid_pbtenaker' => $validation->getError('id_pbtenaker'),
                        'errortotalpekerja' => $validation->getError('totalpekerja'),
                        'errorgaji' => $validation->getError('gaji'),
                        'errorhari' => $validation->getError('hari'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $gaji = $this->request->getVar('gaji');
                $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
                $totalgaji = $this->request->getVar('totalgaji');
                $totalgaji = (int)filter_var($totalgaji, FILTER_SANITIZE_NUMBER_INT);
                $perhitungatkrevisi = new PerhitunganTenakerRevisiModel();
                $id_pbtenakerr = $this->kodeotomatis('perhitungantenakerrevisi', 'id_pbtenakerr', 'PTR001');
                $tk = new PerhitunganTenakerModel();
                $simpandata = [
                    'id_pbtenakerr' =>  $id_pbtenakerr,
                    'id_pbtenaker' => $this->request->getVar('id_pbtenaker'),
                    'idajuan' => $this->request->getVar('idajuantk'),
                    'jenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                    'gaji' => $gaji,
                    'hari' => $this->request->getVar('hari'),
                    'total_pekerja' => $this->request->getVar('totalpekerja'),
                    'total_gaji' => $totalgaji,
                    'revisi_id' => 3

                ];
                $perhitungatkrevisi->insert($simpandata);

                $builder = $tk->builder();
                $builder->set('revisi_id', 2)->where('id_pbtenaker', $this->request->getVar('id_pbtenaker'))->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitungatkrevisi->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                    'notifid_pbtenaker' => $this->request->getVar('id_pbtenaker'),
                    'notifjenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function hapuspbbrevisi($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitunganbb = new PerhitunganBBModel();
            $perhitunganbb->builder()->where('id_pbb', $id)->set('revisi_id', 1)->update();
            $perhitunganbbrevisi = new PerhitunganBBRevisiModel();
            $affected = new PerhitunganBBRevisiModel();
            $perhitunganbbrevisi->builder()->where('id_pbb', $id)->delete();
            $getaffectedrow = $affected->builder()->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function hapuspboprevisi($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitunganbop = new PerhitunganBOPModel();
            $perhitunganbop->builder()->where('id_pbop', $id)->set('revisi_id', 1)->update();
            $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
            $affected = new PerhitunganBOPRevisiModel();
            $perhitunganboprevisi->builder()->where('id_pbop', $id)->delete();
            $getaffectedrow = $affected->builder()->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function hapusptkrevisi($id = false)
    {
        if ($this->request->isAJAX()) {
            $perhitungantenaker = new PerhitunganTenakerModel();
            $perhitungantenaker->builder()->where('id_pbtenaker', $id)->set('revisi_id', 1)->update();
            $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
            $affected = new PerhitunganTenakerRevisiModel();
            $perhitungantkrevisi->builder()->where('id_pbtenaker', $id)->delete();
            $getaffectedrow = $affected->builder()->db()->affectedRows();
            echo json_encode($getaffectedrow);
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function updaterevisibb($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuanbb' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ], 'id_pbb' => [
                    'label' => 'Id Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jumlahbeli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'namabahan' => [
                    'label' => 'Nama Bahan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbb'),
                        'errorid_pbb' => $validation->getError('id_pbb'),
                        'errorharga' => $validation->getError('harga'),
                        'errorjumlahbeli' => $validation->getError('jumlahbeli'),
                        'errornamabahan' => $validation->getError('namabahan'),
                    ],
                ];
                echo json_encode($msg);
            } else {

                $harga = $this->request->getVar('harga');
                $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
                $totalharga = $this->request->getVar('totalharga');
                $totalharga = (int)filter_var($totalharga, FILTER_SANITIZE_NUMBER_INT);
                $id_pbbr = $this->kodeotomatis('perhitunganbbrevisi', 'id_pbbr', 'PBR001');
                $perhitunganbbrevisi = new PerhitunganBBRevisiModel();
                $simpandata = [
                    'id_pbbr' => $id_pbbr,
                    'id_pbb' => $this->request->getVar('id_pbb'),
                    'idajuan' => $this->request->getVar('idajuanbb'),
                    'namabahan' => $this->request->getVar('namabahan'),
                    'ukuran' => $this->request->getVar('ukuran'),
                    'jenis' => $this->request->getVar('jenis'),
                    'kualitas' => $this->request->getVar('kualitas'),
                    'berat' => $this->request->getVar('berat'),
                    'ketebalan' => $this->request->getVar('tebal'),
                    'panjang' => $this->request->getVar('panjang'),
                    'harga' => $harga,
                    'jumlah_beli' => $this->request->getVar('jumlahbeli'),
                    'total_harga' => $totalharga,
                    'revisi_id' => 3

                ];
                $perhitunganbbrevisi->insert($simpandata);

                $perhitunganbbrevisi->builder()->where('id_pbbr', $id)->set('revisi_id', 2)->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitunganbbrevisi->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $data = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyekbb'),
                    'notifajuan' => $this->request->getVar('idajuanbb')
                ];
                echo json_encode($data);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function updaterevisitk($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'idajuantk' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ], 'id_pbtenaker' => [
                    'label' => 'Id Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'jenispekerjaan' => [
                    'label' => 'Jenis Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalpekerja' => [
                    'label' => 'Total Pekerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuantk'),
                        'erroridtenaker' => $validation->getError('id_pbtenaker'),
                        'errorjenispekerjaan' => $validation->getError('jenispekerjaan'),
                        'errorgaji' => $validation->getError('gaji'),
                        'errortotalpekerja' => $validation->getError('totalpekerja'),
                    ],
                ];
                echo json_encode($msg);
            } else {


                $gaji = $this->request->getVar('gaji');
                $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
                $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
                $totalgaji = $this->request->getVar('totalgaji');
                $totalgaji = (int)filter_var($totalgaji, FILTER_SANITIZE_NUMBER_INT);
                $id_pbtenakerr = $this->kodeotomatis('perhitungantenakerrevisi', 'id_pbtenakerr', 'PTR001');
                $simpandata = [
                    'id_pbtenakerr' => $id_pbtenakerr,
                    'id_pbtenaker' => $this->request->getVar('id_pbtenaker'),
                    'idajuan' => $this->request->getVar('idajuantk'),
                    'jenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                    'gaji' => $gaji,
                    'hari' => $this->request->getVar('hari'),
                    'total_pekerja' => $this->request->getVar('totalpekerja'),
                    'total_gaji' => $totalgaji,
                    'revisi_id' => 3

                ];


                $perhitungantkrevisi->insert($simpandata);
                $perhitungantkrevisi->builder()->where('id_pbtenakerr', $id)->set('revisi_id', 2)->update();
                // untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $perhitungantkrevisi->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $data = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyektk'),
                    'notifajuan' => $this->request->getVar('idajuantk')
                ];
                echo json_encode($data);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiayarevisi'));
        }
    }
    public function updaterevisibop($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'namatransaksi' => [
                    'label' => 'Nama Transaksi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'idajuanbop' => [
                    'label' => 'Id Ajuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],
                'totalbiaya' => [
                    'label' => 'Total Biaya',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ],
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'erroridajuan' => $validation->getError('idajuanbop'),
                        'errornamatransaksi' => $validation->getError('namatransaksi'),
                        'errortotalbiaya' => $validation->getError('totalbiaya'),
                    ],
                ];
                echo json_encode($msg);
            } else {
                $totbiaya = $this->request->getVar('totalbiaya');
                $totbiaya = (int)filter_var($totbiaya, FILTER_SANITIZE_NUMBER_INT);
                $boprevisimodel = new PerhitunganBOPRevisiModel();
                $id_pbopr = $this->kodeotomatis('perhitunganboprevisi', 'id_pbopr', 'POR001');
                $simpandata = [
                    'id_pbopr' => $id_pbopr,
                    'id_pbop' => $this->request->getVar('id_pbop'),
                    'idajuan' => $this->request->getVar('idajuanbop'),
                    'namatrans' => $this->request->getVar('namatransaksi'),
                    'tot_biaya' => $totbiaya,
                    'revisi_id' => 3

                ];

                $boprevisimodel->insert($simpandata);
                $boprevisimodel->builder()->where('id_pbopr', $id)->set('revisi_id', 2)->update();
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $boprevisimodel->builder();
                $getaffectedrow = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $getaffectedrow,
                    'notifnamaproyek' => $this->request->getVar('namaproyekbop'),
                    'notifajuan' => $this->request->getVar('idajuanbop')
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('admin/perhitunganbiaya'));
        }
    }
    public function downloadfile($nama = false, $path = false)
    {
        $file_path = $path . '/' . $nama;
        $ctype = "application/octet-stream";
        header("Pragma:public");
        header("Expired:0");
        header("Cache-Control:must-revalidate");
        header("Content-Control:public");
        header("Content-Description: File Transfer");
        header("Content-Type: $ctype");
        header("Content-Disposition:attachment; filename=\"" . basename($file_path) . "\"");
        header("Content-Transfer-Encoding:binary");
        header("Content-Length:" . filesize($file_path));
        flush();
        readfile($file_path);
        exit();
    }
    public function kirimemail($id = false)
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        if ($id != false) {
            $ajuanproyek = new AjuanProyekModel();
            $getdata =  $ajuanproyek->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $id)->get()->getResultArray();
            if (!empty($getdata)) {
                $email = $getdata[0]['email'];
                $ajuan = $getdata[0]['idajuan'];
            } else {
                $email = '';
                $ajuan = '';
            }
        } else {
            $email = '';
            $ajuan = '';
        }
        $akun = new ModelLogin();
        $data = $akun->getalluser();
        $_SESSION['aktif'] = 'kirimemail';
        $this->datalogin += [
            'emailkirim' => $email,
            'ajuan' => $ajuan
        ];

        return view('dashboard/admin/kirimemail', $this->datalogin);
    }
    public function getemailklien()
    {
        if ($this->request->isAJAX()) {
            $user_id = $this->request->getVar('id');
            $akun = new ModelLogin();
            $data = $akun->where('user_id', $user_id)->first();

            echo json_encode($data);
        } else {
            return view('dashboard/admin/kirimemail', $this->datalogin);
        }
    }
    public function kirimfileemail()
    {
        $file = $this->request->getFile('uploadfileemail');
        $namapenerima = $this->request->getVar('penerimaemail');
        $idajuan = $this->request->getVar('idajuan');
        $subject = $this->request->getVar('subjectemail');
        $pesan = $this->request->getVar('pesanemail');
        $filename = $file->getName();
        $nospacefilename = str_replace(' ', '', $filename);
        $file->move('fileadmin', $nospacefilename);
        $path = ('fileadmin/' . $nospacefilename);
        $ajuanproyek = new AjuanProyekModel();
        $send = $this->kirimemaildanfile($namapenerima, $pesan, $path, $subject);

        if ($send == 1) {
            session()->setFlashdata('pesanemail', 1);
            $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '5')->update();
            $ajuanproyek->builder()->where('idajuan', $idajuan)->set('file_admin', $nospacefilename)->update();
        } else {
            session()->setFlashdata('pesanemail', $send);
        }
        return redirect()->to(base_url('admin/kirimemail'));
    }
}
