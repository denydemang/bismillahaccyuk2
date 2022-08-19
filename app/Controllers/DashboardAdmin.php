<?php

namespace App\Controllers;

use App\Models\MeetingModel;
use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
// use App\Models\PerhitunganBBModel;
// use App\Models\PerhitunganBBRevisiModel;
// use App\Models\PerhitunganBOPModel;
// use App\Models\PerhitunganBOPRevisiModel;
// use App\Models\PerhitunganTenakerModel;
// use App\Models\PerhitunganTenakerRevisiModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader


use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\massagemodel;
use App\Models\PerhitunganMaterialModel;
use App\Models\PerhitunganMaterialPenyusunModel;
use App\Models\PerhitunganTenakerModel;


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
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'welcome';
        $_SESSION['subaktif'] = '';
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek
        ];

        return view('dashboard/admin/welcome', $this->datalogin);
    }
    public function perhitunganbiayamaterial()
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };

        $perhitunganmaterial = new PerhitunganMaterialModel();
        $ajuan = new AjuanProyekModel();
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '7')->Orwhere('status_id', '8')->get()->getResultArray();
        $datajoinajuan = $perhitunganmaterial->getalljoinajuan();
        $idmaterial = $this->kodeotomatis('perhitungan_material', 'idmaterial', 'PBB001');
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbmaterial';
        $this->datalogin += [
            'datamaterial' => $datajoinajuan,
            'idmaterial' => $idmaterial,
            'dataajuannn' => $dataajuan
        ];

        return view('dashboard/admin/perhitunganbiayamaterial', $this->datalogin);
    }
    public function perhitunganbiayamaterialpenyusun($idmaterial = false)
    {
        if ($idmaterial != false) {
            $idmaterialpenyusun = $this->kodeotomatis('perhitungan_materialpenyusun', 'idmaterialpenyusun', 'PBP001');

            $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
            $Perhitunganmaterial = new PerhitunganMaterialModel();
            $getdatamaterial = $Perhitunganmaterial->where('idmaterial', $idmaterial)->find();
            $getdata = $perhitunganmaterialpenyusun->getbyidmaterial($idmaterial);
            if (!empty($getdatamaterial)) {
                if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
                    unset($_SESSION['aktif']);
                    unset($_SESSION['subaktif']);
                };
                $_SESSION['aktif'] = 'pb';
                $_SESSION['subaktif'] = 'pbmaterial';
                $this->datalogin += [
                    'material' => $getdata,
                    'idmaterial' => $idmaterial,
                    'idmaterialpenyusun' => $idmaterialpenyusun,
                    'namamaterial' => $getdatamaterial[0]['namamaterial'],
                    'idajuan' => $getdatamaterial[0]['idajuan']
                ];

                return view('dashboard/admin/perhitunganbiayamaterialpenyusun', $this->datalogin);
            } else {
                return redirect()->to('admin/perhitunganbiayamaterial');
            }
        } else {
            return redirect()->to('admin/perhitunganbiayamaterial');
        }
        $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
        $getdata = $perhitunganmaterialpenyusun->getbyidmaterial($idmaterial);
    }
    public function perhitunganbiayatenaker()
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $ajuan = new AjuanProyekModel();
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbtenaker';
        $tenaker = new PerhitunganTenakerModel();
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '7')->Orwhere('status_id', '8')->get()->getResultArray();
        $getdata = $tenaker->findAll();
        $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PTK001');

        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek,
            'tenaker' => $getdata,
            'id_pbtenaker' => $id_pbtenaker,
            'dataajuannn' => $dataajuan,
        ];

        return view('dashboard/admin/perhitunganbiayatenagakerja', $this->datalogin);
    }
    public function perhitunganbiayalain()
    {

        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbop';
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek
        ];

        return view('dashboard/admin/perhitunganbiayalain', $this->datalogin);
    }
    public function ajuanproyek()
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $ajuanproyek = new AjuanProyekModel();
        $belumditinjau = $ajuanproyek->builder()->like('status_id', 1)->countAllResults();
        $diterima = $ajuanproyek->builder()->like('status_id', 2)->countAllResults();
        $ditolak = $ajuanproyek->builder()->like('status_id', 3)->countAllResults();
        $dikerjakan = $ajuanproyek->builder()->like('status_id', 4)->countAllResults();
        $dihitung = $ajuanproyek->builder()->like('revisi_id', 1)->countAllResults();
        $negotiating = $ajuanproyek->builder()->like('status_id', 5)->countAllResults();
        $diterimaklien = $ajuanproyek->builder()->like('status_id', 6)->countAllResults();
        $ditolakklien = $ajuanproyek->builder()->like('status_id', 7)->countAllResults();
        $permintaanmeeting = $ajuanproyek->builder()->like('status_id', 8)->countAllResults();
        $totalajuan = $ajuanproyek->builder()->countAll();

        $status = [
            'belumditinjau' => $belumditinjau,
            'diterima' => $diterima,
            'ditolak' => $ditolak,
            'dikerjakan' => $dikerjakan,
            'dihitung' => $dihitung,
            'totalajuan' => $totalajuan,
            'negotiating' => $negotiating,
            'diterimaklien' => $diterimaklien,
            'ditolakklien' => $ditolakklien,
            'permintaanmeeting' => $permintaanmeeting,


        ];
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query = $builder->get();


        $_SESSION['aktif'] = 'ajuan';
        $_SESSION['subaktif'] = '';
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

        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['subaktif'] = '';
        $_SESSION['aktif'] = 'datauser';

        $this->datalogin += [
            'users' => $getData,
        ];
        return view('dashboard/admin/datauser', $this->datalogin);
    }
    public function dataproyek($id = '')
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['subaktif'] = '';
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
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['subaktif'] = '';
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
    // public function perhitunganrab($id = '')
    // {
    //     if (isset($_SESSION['aktif'])) {
    //         unset($_SESSION['aktif']);
    //     };
    //     $_SESSION['aktif'] = 'perhitunganbiaya';
    //     return view('dashboard/admin/perhitunganbiaya', $this->datalogin);
    // }
    //End Method TampiView


    //Query Get
    public function getdatatenaker($idtenaker)
    {
        if ($this->request->isAJAX()) {
            $tk = new PerhitunganTenakerModel();
            $getdata = $tk->builder()->where('id_pbtenaker', $idtenaker)->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function getdatampjoin($idmp)
    {
        if ($this->request->isAJAX()) {

            $materialpendukung = new PerhitunganMaterialPenyusunModel();
            $getdata = $materialpendukung->builder()->join('perhitungan_material', 'perhitungan_materialpenyusun.idmaterial=perhitungan_material.idmaterial')->where('idmaterialpenyusun', $idmp)->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function getmaterialdanpenyusun($idmaterial)
    {
        if ($this->request->isAjax()) {

            $material = new PerhitunganMaterialModel();
            $bahanpenyusun = new PerhitunganMaterialPenyusunModel();
            $getdatamaterial = $material->find($idmaterial);
            $getsumjumlahmp = $bahanpenyusun->builder()->selectSum('totalmp')->where('idmaterial', $idmaterial)->get()->getResultArray();
            $getdatapenyusun = $bahanpenyusun->where('idmaterial', $idmaterial)->findAll();
            $data = [
                'datamaterial' => $getdatamaterial,
                'datapenyusun' => $getdatapenyusun,
                'totalmp' => $getsumjumlahmp,
            ];
            echo json_encode($data);
        }
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
    public function getmeeting($id)
    {
        $meeting = new MeetingModel();
        $data = $meeting->where('idajuan', $id)->first();
        echo json_encode($data);
    }
    public function getUser()
    {
        $id = $_POST['id'];
        $getuser = new ModelLogin();
        echo json_encode($getuser->where('user_id', $id)->findAll());
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
    //End Query get


    //Query Create
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
    public function simpantenaker()
    {
        $tenaker = new PerhitunganTenakerModel();
        $id_pbtenaker = $this->request->getVar('id_pbtenaker');
        $idajuan = $this->request->getVar('idajuan');
        $jobdesk = $this->request->getVar('jobdesk');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan');
        $gaji = $this->request->getVar('gaji');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja');
        $total_gaji = $this->request->getVar('total_gaji');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);

        $tenaker->insert([
            'id_pbtenaker' => $id_pbtenaker,
            'idajuan' => $idajuan,
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
        ]);
        $affected = $tenaker->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID ' . $id_pbtenaker . ' Berhasil Ditambahkan');
        } else {
            session()->setFlashdata('gagal', $id_pbtenaker . ' Gagal Ditambahkan');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }
    public function simpanmaterialpenyusun()
    {
        $materialpeyusun = new PerhitunganMaterialPenyusunModel();
        $material = new PerhitunganMaterialModel();
        $idmaterialpenyusun = $this->kodeotomatis('perhitungan_materialpenyusun', 'idmaterialpenyusun', 'PBP001');
        $idmaterial = $this->request->getVar('idmaterial');
        $namamp = $this->request->getVar('namamp');
        $spesifikasimp = $this->request->getVar('spesifikasimp');
        $jumlahmp = $this->request->getVar('jumlahmp');
        $satuanmp = $this->request->getVar('satuanmp');
        $hargamp = $this->request->getVar('hargamp');
        $hargamp = (int)filter_var($hargamp, FILTER_SANITIZE_NUMBER_INT);
        $totalmp = $this->request->getVar('totalmp');
        $totalmp = (int)filter_var($totalmp, FILTER_SANITIZE_NUMBER_INT);

        $materialpeyusun->insert([
            'idmaterialpenyusun' => $idmaterialpenyusun,
            'idmaterial' => $idmaterial,
            'namamp' => $namamp,
            'spesifikasimp' => $spesifikasimp,
            'jumlahmp' => $jumlahmp,
            'jumlahmp' => $jumlahmp,
            'satuanmp' => $satuanmp,
            'hargamp' => $hargamp,
            'totalmp' => $totalmp,
        ]);
        $gettotal = $materialpeyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        $total = $gettotal[0]['totalmp'];
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total)->update();
        $affected = $materialpeyusun->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', $namamp . ' Berhasil Ditambahkan');
        } else {
            session()->setFlashdata('gagal', $namamp . ' Gagal Ditambahkan');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }

    public function simpanmaterial()
    {
        $material = new PerhitunganMaterialModel();
        $idmaterial = $this->request->getVar('idmaterial');
        $idajuan = $this->request->getVar('idajuan');
        $jenismaterial = $this->request->getVar('jenismaterial');
        $namamaterial = $this->request->getVar('namamaterial');
        $satuanmaterial = $this->request->getVar('satuanmaterial');
        $qtymaterial = $this->request->getVar('qtymaterial');
        $material->insert([
            'idmaterial' => $idmaterial,
            'idajuan' => $idajuan,
            'jenismaterial' => $jenismaterial,
            'namamaterial' => $namamaterial,
            'satuanmaterial' => $satuanmaterial,
            'qtymaterial' => $qtymaterial,
        ]);
        $affected = $material->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('pesanmaterial', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('pesanmaterial', 'Gagal Disimpan');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterial'));
    }

    //End Query Create



    //Query Update
    public function updatetenaker()
    {
        $tk = new PerhitunganTenakerModel();
        $id_pbtenaker = $this->request->getVar('id_pbtenaker');
        $idajuan = $this->request->getVar('idajuan');
        $jobdesk = $this->request->getVar('jobdesk');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan');
        $gaji = $this->request->getVar('gaji');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja');
        $total_gaji = $this->request->getVar('total_gaji');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);
        $tk->update($id_pbtenaker, [
            'idajuan' => $idajuan,
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
        ]);
        $affected = $tk->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID ' . $id_pbtenaker . ' Berhasil Diupdate');
        } else {
            session()->setFlashdata('gagal', $id_pbtenaker . ' Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }
    public function updatematerialpenyusun()
    {
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $idmaterialpenyusun = $this->request->getVar('idmaterialpenyusun');
        $idmaterial = $this->request->getVar('idmaterial');
        $namamp = $this->request->getVar('namamp');
        $spesifikasimp = $this->request->getVar('spesifikasimp');
        $satuanmp = $this->request->getVar('satuanmp');
        $jumlahmp = $this->request->getVar('jumlahmp');
        $hargamp = $this->request->getVar('hargamp');
        $hargamp = (int)filter_var($hargamp, FILTER_SANITIZE_NUMBER_INT);
        $totalmp = $this->request->getVar('totalmp');
        $totalmp = (int)filter_var($totalmp, FILTER_SANITIZE_NUMBER_INT);
        $materialpenyusun->update($idmaterialpenyusun, [
            'idmaterial' => $idmaterial,
            'namamp' => $namamp,
            'spesifikasimp' => $spesifikasimp,
            'satuanmp' => $satuanmp,
            'jumlahmp' => $jumlahmp,
            'hargamp' => $hargamp,
            'totalmp' => $totalmp,
        ]);
        $gettotal = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        $total = '';
        if (!empty($gettotal)) {
            $total = $gettotal[0]['totalmp'];
        } else {
            $total = 0;
        };
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total)->update();
        $affected = $materialpenyusun->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('gagal', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('berhasil', 'Data ' . $namamp . ' Berhasil Diupdate');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }
    public function updatematerial()
    {
        $material = new PerhitunganMaterialModel();
        $idmaterial = $this->request->getVar('idmaterial');
        $idajuan = $this->request->getVar('idajuan');
        $namamaterial = $this->request->getVar('namamaterial');
        $jenismaterial = $this->request->getVar('jenismaterial');
        $satuanmaterial = $this->request->getVar('satuanmaterial');
        $qtymaterial = $this->request->getVar('qtymaterial');
        $hargamaterial = 0;
        $material->update($idmaterial, [
            'idajuan' => $idajuan,
            'namamaterial' => $namamaterial,
            'jenismaterial' => $jenismaterial,
            'satuanmaterial' => $satuanmaterial,
            'qtymaterial' => $qtymaterial,
            'hargamaterial' => $hargamaterial,
        ]);
        $affected = $material->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('pesanmaterial', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('pesanmaterial', 'Data Berhasil Diupdate');
        } else {
            session()->setFlashdata('pesanmaterial', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterial'));
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

    //End Query Update


    //Query Delete
    public function hapustenaker($id)
    {
        $tk = new PerhitunganTenakerModel();
        $tk->delete($id);
        $affected = $tk->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID :' . $id . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
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
    public function hapusmaterial($id)
    {
        $material = new PerhitunganMaterialModel();
        $material->delete($id);
        $affected = $material->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('pesanmaterial', 'Berhasil DiHapus');
        } else {
            session()->setFlashdata('pesanmaterial', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterial'));
    }
    public function hapusmaterialpenyusun($idmaterialpenyusun, $idmaterial)
    {
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $materialpenyusun->delete($idmaterialpenyusun);
        $gettotal = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        $total = '';
        if (!empty($gettotal)) {
            $total = $gettotal[0]['totalmp'];
        } else {
            $total = 0;
        }
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total)->update();
        $affected = $materialpenyusun->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil',  $idmaterialpenyusun . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }
    public function deleteuser($id)
    {
        $modeluser = new ModelLogin();
        $modeluser->where('user_id', $id)->delete();
        return redirect()->to(base_url() . '/admin/datauser');
    }
    //End Query Delete


    //Query  Lain
    // public function printperhitunganbiaya($id = '')

    // {

    //     date_default_timezone_set('Asia/Jakarta');
    //     $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
    //     $perhitunganbop = new PerhitunganBOPModel();
    //     $perhitunganbb = new PerhitunganBBModel();
    //     $perhitungantk = new PerhitunganTenakerModel();
    //     $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
    //     $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
    //     $perhitunganboprevisi = new PerhitunganBOPRevisiModel();

    //     $builder1 = $perhitunganbop->builder();
    //     $builder1->where('idajuan', $id)->selectSum('tot_biaya');
    //     $query = $builder1->get();
    //     $sumbop = $query->getResultArray();
    //     $sumbop = intval($sumbop[0]['tot_biaya']);


    //     $builder2 = $perhitunganbb->builder();
    //     $builder2->where('idajuan', $id)->selectSum('total_harga');
    //     $query = $builder2->get();
    //     $sumbb = $query->getResultArray();
    //     $sumbb = intval($sumbb[0]['total_harga']);

    //     $builder3 = $perhitungantk->builder();
    //     $builder3->where('idajuan', $id)->selectSum('total_gaji');
    //     $query = $builder3->get();
    //     $sumtk = $query->getResultArray();
    //     $sumtk = intval($sumtk[0]['total_gaji']);

    //     $sumall = $sumbb + $sumbop + $sumtk;


    //     $perhitunganbbmodel = new PerhitunganBBModel();
    //     $getdatabb = $perhitunganbbmodel->where('idajuan', $id)->findAll();

    //     $perhitungantenakermodel = new PerhitunganTenakerModel();
    //     $getdatatk = $perhitungantenakermodel->where('idajuan', $id)->findAll();

    //     $perhitunganbopmodel = new PerhitunganBOPModel();
    //     $getdatabop = $perhitunganbopmodel->where('idajuan', $id)->findAll();

    //     $pengajuanproyekmodel = new AjuanProyekModel();
    //     $builder = $pengajuanproyekmodel->builder();
    //     $builder = $builder->select('*');
    //     $builder = $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->where('idajuan', $id);
    //     $query = $builder->get();
    //     $getdatauser = $query->getResultArray();

    //     if (empty($sumbb && $sumbop && $sumtk && $sumall && $getdatauser)) {
    //         session()->setFlashdata('pesanprint', 'Data Belum Terisi Semua !, Silakan Lengkapi Data!');
    //         return redirect()->to(base_url() . '/admin/perhitunganbiaya');
    //     } else {

    //         $data = [
    //             'bb' => $getdatabb,
    //             'tk' => $getdatatk,
    //             'bop' => $getdatabop,
    //             'user' => $getdatauser,
    //             'sumbop' => $sumbop,
    //             'tanggal' => $tanggal,
    //             'sumbb' => $sumbb,
    //             'sumtk' => $sumtk,
    //             'sumall' => $sumall

    //         ];

    //         // instantiate and use the dompdf class
    //         $html = view('dashboard/admin/printperhitunganbiaya', $data);
    //         $dompdf = new Dompdf();

    //         $dompdf->loadHtml($html);

    //         // (Optional) Setup the paper size and orientation
    //         $dompdf->setPaper('A4', 'landscape');

    //         // Render the HTML as PDF
    //         $dompdf->render();

    //         // Output the generated PDF to Browser

    //         $dompdf->stream('Proposal Ajuan' . '-' . $getdatauser[0]['idajuan'] . '-' . $getdatauser[0]['nama'] . ".pdf", array("Attachment" => false));
    //     };
    // }
    public function redirectkelola($idproyek, $idajuan)
    {
        session()->set('kelolaproyek', 'true');
        session()->set('idproyek', $idproyek);
        session()->set('idajuan', $idajuan);
        return redirect()->to(base_url('kelolaproyek'));
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
        } else {
            session()->setFlashdata('pesanemail', $send);
        }
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '5')->update();
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('file_admin', $nospacefilename)->update();
        return redirect()->to(base_url('admin/kirimemail'));
    }
    //End Query Lain


}
