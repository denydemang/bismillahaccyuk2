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
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganBOPRevisiModel;
use App\Models\PerhitunganMaterialModel;
use App\Models\PerhitunganMaterialPenyusunModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\PerhitunganMPrevisi;
use App\Models\PerhitunganTenakerRevisiModel;

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
    public function cetakrab()
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'cetakrab';
        $ajuan = new AjuanProyekModel();
        $getdata = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('revisi_id', 1)->get()->getResultArray();
        $this->datalogin += [
            'dataajuannn' => $getdata
        ];

        return view('dashboard/admin/cetakrab', $this->datalogin);
    }
    public function perhitunganbiayamaterial($idajuan = false)
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbmaterial';
        $ajuan = new AjuanProyekModel();
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '7')->Orwhere('status_id', '8')->get()->getResultArray();
        if ($idajuan != false) {
            $perhitunganmaterial = new PerhitunganMaterialModel();
            $datajoinajuan = $perhitunganmaterial->builder()->join('pengajuan_proyek', 'perhitungan_material.idajuan=pengajuan_proyek.idajuan')->where('pengajuan_proyek.idajuan', $idajuan)->get()->getResultArray();
            $idmaterial = $this->kodeotomatis('perhitungan_material', 'idmaterial', 'PBB001');
        } else {
            $perhitunganmaterial = new PerhitunganMaterialModel();
            $datajoinajuan = $perhitunganmaterial->findAll();
            $idmaterial = $this->kodeotomatis('perhitungan_material', 'idmaterial', 'PBB001');
        }
        $this->datalogin += [
            'datamaterial' => $datajoinajuan,
            'idmaterial' => $idmaterial,
            'dataajuannn' => $dataajuan,
            'idajuan' => $idajuan,
        ];


        return view('dashboard/admin/perhitunganbiayamaterial', $this->datalogin);
    }
    public function perhitunganbiayamaterialpenyusun($idmaterial = false)
    {
        if ($idmaterial != false) {
            $idmaterialpenyusun = $this->kodeotomatis('perhitungan_materialpenyusun', 'idmaterialpenyusun', 'PBP001');
            $mprevisi = new PerhitunganMPrevisi();
            $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
            $Perhitunganmaterial = new PerhitunganMaterialModel();
            $getdatamaterial = $Perhitunganmaterial->where('idmaterial', $idmaterial)->find();
            $getdatamprevisi = $mprevisi->getbyidmaterial($idmaterial);
            $getdatamaterialpenyusun = $perhitunganmaterialpenyusun->getbyidmaterial($idmaterial);
            if (!empty($getdatamaterial)) {
                if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
                    unset($_SESSION['aktif']);
                    unset($_SESSION['subaktif']);
                };
                $_SESSION['aktif'] = 'pb';
                $_SESSION['subaktif'] = 'pbmaterial';
                $this->datalogin += [
                    'material' => $getdatamaterialpenyusun,
                    'idmaterial' => $idmaterial,
                    'idmaterialpenyusun' => $idmaterialpenyusun,
                    'namamaterial' => $getdatamaterial[0]['namamaterial'],
                    'idajuan' => $getdatamaterial[0]['idajuan'],
                    'mprevisi' => $getdatamprevisi
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
    public function perhitunganbiayatenaker($id = false)
    {
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbtenaker';
        $ajuan = new AjuanProyekModel();
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '7')->Orwhere('status_id', '8')->get()->getResultArray();
        if ($id != false) {
            $tenaker = new PerhitunganTenakerModel();
            $tenakerr = new PerhitunganTenakerRevisiModel();
            $datatkrevisi = $tenakerr->builder()->select('perhitungantenakerrevisi.*')->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')->where('perhitungantenakerrevisi.revisi_id', 3)->where('idajuan', $id)->get()->getResultArray();
            $getdata = $tenaker->where('idajuan', $id)->find();
            $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PTK001');
            $idajuan = $id;
        } else {

            $tenaker = new PerhitunganTenakerModel();
            $tenakerr = new PerhitunganTenakerRevisiModel();
            $datatkrevisi = $tenakerr->builder()->select('perhitungantenakerrevisi.*')->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')->where('perhitungantenakerrevisi.revisi_id', 3)->get()->getResultArray();
            $getdata = $tenaker->findAll();
            $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PTK001');
            $idajuan = $id;
        }

        $this->datalogin += [

            'tenaker' => $getdata,
            'id_pbtenaker' => $id_pbtenaker,
            'idajuan' => $idajuan,
            'dataajuannn' => $dataajuan,
            'tkrevisi' => $datatkrevisi

        ];

        return view('dashboard/admin/perhitunganbiayatenagakerja', $this->datalogin);
    }
    public function perhitunganbiayalain($id = false)
    {

        $bop = new PerhitunganBOPModel;
        $bopr = new PerhitunganBOPRevisiModel();
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $ajuan = new AjuanProyekModel();
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbop';
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '7')->Orwhere('status_id', '8')->where('idajuan', $id)->get()->getResultArray();
        if ($id != false) {
            $getdatabop = $bop->where('idajuan', $id)->find();
            $getdatabopr = $bopr->builder()->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')->where('perhitunganboprevisi.revisi_id', 3)->where('idajuan', $id)->get()->getResultArray();
            $id_pbop = $this->kodeotomatis('perhitunganbop', 'id_pbop', 'PBO001');
            $idajuan = $id;
        } else {
            $getdatabop = $bop->findAll();
            $getdatabopr = $bopr->where('revisi_id', 3)->find();
            $id_pbop = $this->kodeotomatis('perhitunganbop', 'id_pbop', 'PBO001');
            $idajuan = '';
        }

        $this->datalogin += [
            'dataajuannn' => $dataajuan,
            'bop' => $getdatabop,
            'id_pbop' => $id_pbop,
            'bopr' => $getdatabopr,
            'idajuan' => $idajuan,
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
        $getData =  $modelajuan->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '6')->where('revisi_id', 1)->findAll();

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
    public function getidajuan($katakunci)
    {
        if ($this->request->isAJAX()) {
            $ajuan = new AjuanProyekModel();
            $getdata = $ajuan->builder()->select('pengajuan_proyek.*,akun.nama')->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->like('idajuan', $katakunci)->orLike('namaproyek', $katakunci)->orLike('jenisproyek', $katakunci)->orLike('nama', $katakunci)->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function gettotbiaya($idajuan)
    {

        $bahanbaku = new PerhitunganMaterialModel();
        $tenaker     = new PerhitunganTenakerModel();
        $bop     = new PerhitunganBOPModel();
        $gettotbb = $bahanbaku->builder()->selectSum('total_harga')->where('idajuan', $idajuan)->get()->getResultArray();
        $gettottk = $tenaker->builder()->selectSum('total_gaji')->where('idajuan', $idajuan)->where('revisi_id', '0')->get()->getResultArray();
        $gettotbop = $bop->builder()->selectSum('tot_biaya')->where('idajuan', $idajuan)->where('revisi_id', '0')->get()->getResultArray();

        $tkrevisi = new PerhitunganTenakerRevisiModel();
        $boprevisi = new PerhitunganBOPRevisiModel();

        $getottkrevisi = $tkrevisi->builder()->selectSum('perhitungantenakerrevisi.total_gaji')
            ->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')
            ->where('idajuan', $idajuan)->where('perhitungantenakerrevisi.revisi_id', '3')->get()->getResultArray();



        $getotboprevisi = $boprevisi->builder()->selectSum('perhitunganboprevisi.tot_biaya')
            ->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')
            ->where('perhitunganbop.idajuan', $idajuan)->where('perhitunganboprevisi.revisi_id', '3')->get()->getResultArray();

        $jumlahbiayatotal = (intval($gettotbb[0]['total_harga']) + intval($gettottk[0]['total_gaji']) + intval($gettotbop[0]['tot_biaya']));
        $jumlahbiayarevisitotal = (intval($getottkrevisi[0]['total_gaji']) + intval($getotboprevisi[0]['tot_biaya']));
        $totalbiaya = $jumlahbiayatotal + $jumlahbiayarevisitotal;
        return $totalbiaya;
    }

    public function getdatarevisitk($id)
    {
        if ($this->request->isAJAX()) {
            $tenakerr = new PerhitunganTenakerRevisiModel();
            $getdata = $tenakerr->find($id);
            echo json_encode($getdata);
        }
    }
    public function getbopr($id)
    {
        if ($this->request->isAJAX()) {
            $bopr = new PerhitunganBOPRevisiModel();
            $getdata = $bopr->builder()->select('perhitunganboprevisi.*,perhitunganbop.idajuan')->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function getdatampr($id)
    {
        if ($this->request->isAJAX()) {
            $mpr = new PerhitunganMPrevisi();
            $getdata = $mpr->builder()->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('idmprevisi', $id)->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function getdatatenaker($idtenaker)
    {
        if ($this->request->isAJAX()) {
            $tk = new PerhitunganTenakerModel();
            $getdata = $tk->builder()->where('id_pbtenaker', $idtenaker)->get()->getResultArray();
            echo json_encode($getdata);
        }
    }
    public function getbop($id_pbop)
    {
        // if ($this->request->isAJAX()) {
        $bop = new PerhitunganBOPModel();
        $getdata = $bop->builder()->where('id_pbop', $id_pbop)->get()->getResultArray();
        $data = [
            'bop' => $getdata
        ];
        // dd($getdata);
        echo json_encode($getdata);
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
            $mprevisi = new PerhitunganMPrevisi();
            $getdatamaterial = $material->find($idmaterial);
            $getdatapenyusun = $bahanpenyusun->where('revisi_id', 0)->where('idmaterial', $idmaterial)->find();
            $getdatrevisi = $mprevisi->builder()->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('idmaterial', $idmaterial)->get()->getResultArray();
            $gettotal1 = $bahanpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
            if (empty($gettotal1[0]['totalmp'])) {
                $total1 = 0;
            } else {
                $total1 = (int)$gettotal1[0]['totalmp'];
            }
            $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
            if (empty($gettotal2[0]['totalmpr'])) {
                $total2 = 0;
            } else {
                $total2 = (int)$gettotal2[0]['totalmpr'];
            }
            $totalsemua = $total1 + $total2;

            $data = [
                'datamaterial' => $getdatamaterial,
                'datapenyusun' => $getdatapenyusun,
                'datarevisi' => $getdatrevisi,
                'totalbahanpenyusun' => $total1,
                'totalbahanrevisi' => $total2,
                'grandtotal' => $totalsemua
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
        // dd($data);
        echo json_encode($data);
    }
    public function totalbiaya($id)
    {
        $biaya = $this->gettotbiaya($id);
        echo json_encode($biaya);
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

    public function editrevisimp()
    {
        $mprevisi = new PerhitunganMPrevisi();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $material = new PerhitunganMaterialModel();
        $idmaterial = $this->request->getVar('idmaterial');
        $idmprevisi = $this->kodeotomatis('perhitungan_mprevisi', 'idmprevisi', 'BPR001');
        $namampr = $this->request->getVar('namampr');
        $idmaterialpenyusun = $this->request->getVar('idmaterialpenyusun');
        $spesifikasimpr = $this->request->getVar('spesifikasimpr');
        $jumlahmpr = $this->request->getVar('jumlahmpr');
        $satuanmpr = $this->request->getVar('satuanmpr');
        $hargampr = $this->request->getVar('hargampr');
        $hargampr = (int)filter_var($hargampr, FILTER_SANITIZE_NUMBER_INT);
        $totalmpr = $this->request->getVar('totalmpr');
        $totalmpr = (int)filter_var($totalmpr, FILTER_SANITIZE_NUMBER_INT);
        $mprevisi->insert([
            'idmaterialpenyusun' => $idmaterialpenyusun,
            'idmprevisi' => $idmprevisi,
            'namampr' => $namampr,
            'spesifikasimpr' => $spesifikasimpr,
            'jumlahmpr' => $jumlahmpr,
            'satuanmpr' => $satuanmpr,
            'hargampr' => $hargampr,
            'totalmpr' => $totalmpr,
            'revisi_id' => 3,
        ]);
        $mprevisi->builder()->where('idmprevisi', $this->request->getVar('idmprevisi'))->set('revisi_id', 2)->update();

        $gettotal1 = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $affected = $mprevisi->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', $namampr . ' Berhasil Direvisi');
        } else {
            session()->setFlashdata('gagal', $namampr . ' Gagal Ditambahkan');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }
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
    public function simpanbop()
    {
        $bop = new PerhitunganBOPModel();
        $id_pbop = $this->request->getVar('id_pbop');
        $idajuan = $this->request->getVar('idajuan');
        $namatrans = $this->request->getVar('namatrans');
        $quantity = $this->request->getVar('quantity');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getVar('tot_biaya');
        $tot_biaya = (int)filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        $bop->insert([
            'id_pbop' => $id_pbop,
            'idajuan' => $idajuan,
            'namatrans' => $namatrans,
            'quantity' => $quantity,
            'satuan' => $satuan,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
        ]);
        $affected = $bop->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID ' . $id_pbop . ' Berhasil Ditambahkan');
        } else {
            session()->setFlashdata('gagal', $id_pbop . ' Gagal Ditambahkan');
        }
        return redirect()->to(base_url('admin/perhitunganbiayalain/' . $idajuan));
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
        return redirect()->to(base_url('admin/perhitunganbiayatenaker/' . $idajuan));
    }
    public function simpanmaterialpenyusun()
    {
        $ajuanproyek = new AjuanProyekModel();
        $mprevisi = new PerhitunganMPrevisi();
        $materialpeyusun = new PerhitunganMaterialPenyusunModel();
        $material = new PerhitunganMaterialModel();
        $idajuan = $this->request->getVar('idajuan');
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
            'revisi_id' => 0
        ]);
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('revisi_id', 1)->update();
        $gettotal1 = $materialpeyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $affected = $materialpeyusun->builder()->db()->affectedRows();
        if ($affected >= 0) {
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
        return redirect()->to(base_url('admin/perhitunganbiayamaterial/' . $idajuan));
    }

    //End Query Create



    //Query Update
    public function editrevisibop()
    {
        // $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $id_pbopr = $this->kodeotomatis('perhitunganboprevisi', 'id_pbopr', 'BOR001');
        $id_pbop = $this->request->getVar('id_pbop');
        $namatrans = $this->request->getVar('namatrans');
        $satuan = $this->request->getVar('satuan');
        $quantity = $this->request->getVar('quantity');
        $harga = $this->request->getVar('harga');
        $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getVar('tot_biaya');
        $tot_biaya = (int)filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        $bopr->insert([
            'id_pbopr' => $id_pbopr,
            'id_pbop' => $id_pbop,
            'namatrans' => $namatrans,
            'satuan' => $satuan,
            'quantity' => $quantity,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
            'revisi_id' => 3
        ]);
        $bopr->builder()->where('id_pbopr', $this->request->getVar('id_pbopr'))->set('revisi_id', 2)->update();
        $affected = $bopr->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('gagal', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('berhasil', 'Data ' . $namatrans . ' Berhasil Diupdate');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayalain'));
    }
    public function editrevisitenaker()
    {

        $tkr = new PerhitunganTenakerRevisiModel();
        $id_pbtenaker = $this->request->getVar('id_pbtenaker1');
        $id_pbtenakerr = $this->kodeotomatis('perhitungantenakerrevisi', 'id_pbtenakerr', 'TKR001');
        $jobdesk = $this->request->getVar('jobdesk1');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan1');
        $gaji = $this->request->getVar('gaji1');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja1');
        $total_gaji = $this->request->getVar('total_gaji1');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);
        $tkr->insert([
            'id_pbtenakerr' => $id_pbtenakerr,
            'id_pbtenaker' => $id_pbtenaker,
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
            'revisi_id' => 3
        ]);
        $tkr->builder()->where('id_pbtenakerr', $this->request->getVar('id_pbtenakerr1'))->set('revisi_id', 2)->update();

        $affected = $tkr->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('gagal', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('berhasil', 'Data ' . $id_pbtenakerr . ' Berhasil Diupdate');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }


    public function revisibop()
    {
        $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $id_pbopr = $this->kodeotomatis('perhitunganboprevisi', 'id_pbopr', 'BOR001');
        $id_pbop = $this->request->getVar('id_pbop');
        $namatrans = $this->request->getVar('namatrans');
        $satuan = $this->request->getVar('satuan');
        $quantity = $this->request->getVar('quantity');
        $harga = $this->request->getVar('harga');
        $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getVar('tot_biaya');
        $tot_biaya = (int)filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        $bopr->insert([
            'id_pbopr' => $id_pbopr,
            'id_pbop' => $id_pbop,
            'namatrans' => $namatrans,
            'satuan' => $satuan,
            'quantity' => $quantity,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
            'revisi_id' => 3
        ]);
        $bop->where('id_pbop', $id_pbop)->set('revisi_id', 2)->update();
        $affected = $bopr->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('gagal', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('berhasil', 'Data ' . $namatrans . ' Berhasil Direvisi');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayalain'));
    }
    public function revisitenaker()
    {

        $tk = new PerhitunganTenakerModel();
        $tkr = new PerhitunganTenakerRevisiModel();
        $id_pbtenaker = $this->request->getVar('id_pbtenaker');
        $id_pbtenakerr = $this->kodeotomatis('perhitungantenakerrevisi', 'id_pbtenakerr', 'TKR001');
        $jobdesk = $this->request->getVar('jobdesk');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan');
        $gaji = $this->request->getVar('gaji');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja');
        $total_gaji = $this->request->getVar('total_gaji');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);
        $tkr->insert([
            'id_pbtenakerr' => $id_pbtenakerr,
            'id_pbtenaker' => $id_pbtenaker,
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
            'revisi_id' => 3
        ]);
        $tk->builder()->where('id_pbtenaker', $id_pbtenaker)->set('revisi_id', 2)->update();
        $affected = $tkr->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID ' . $id_pbtenaker . ' Berhasil DiRevisi');
        } else {
            session()->setFlashdata('gagal', $id_pbtenaker . ' Gagal Direvisi');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }
    public function revisimaterialpenyusun()
    {
        $mprevisi = new PerhitunganMPrevisi();
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $idmprevisi = $this->kodeotomatis('perhitungan_mprevisi', 'idmprevisi', 'BPR001');
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
        $mprevisi->insert([
            'idmprevisi' => $idmprevisi,
            'idmaterialpenyusun' => $idmaterialpenyusun,
            'namampr' => $namamp,
            'spesifikasimpr' => $spesifikasimp,
            'satuanmpr' => $satuanmp,
            'jumlahmpr' => $jumlahmp,
            'hargampr' => $hargamp,
            'totalmpr' => $totalmp,
            'revisi_id' => 3
        ]);
        $materialpenyusun->builder()->where('idmaterialpenyusun', $idmaterialpenyusun)->set('revisi_id', 2)->update();
        $gettotal1 = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $affected = $mprevisi->builder()->db()->affectedRows();
        if ($affected >= 0) {
            session()->setFlashdata('berhasil', 'Data ' . $namamp . ' Berhasil DiRevisi');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Direvisi');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }
    public function updatematerial()
    {
        $material = new PerhitunganMaterialModel();
        $mprevisi = new PerhitunganMPrevisi();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
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
        ]);
        $affected = $material->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('pesanmaterial', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('pesanmaterial', 'Data Berhasil Diupdate');
        } else {
            session()->setFlashdata('pesanmaterial', 'Data Gagal Diupdate');
        }
        $gettotal1 = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
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
    public function hapusbop($id)
    {

        $bop = new PerhitunganBOPModel();
        $bop->delete($id);
        $affected = $bop->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID :' . $id . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayalain'));
    }
    public function hapusbopr($idpbop)
    {
        $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $bopr->builder()->where('id_pbop', $idpbop)->delete();
        $affected = $bopr->builder()->db()->affectedRows();
        $bop->builder()->where('id_pbop', $idpbop)->set('revisi_id', 0)->update();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID :' . $idpbop . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayalain'));
    }
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
    public function hapustenakerrevisi($id)
    {
        $tk = new PerhitunganTenakerModel();
        $tkr = new PerhitunganTenakerRevisiModel();
        $tkr->where('id_pbtenaker', $id)->delete();
        $tk->builder()->where('id_pbtenaker', $id)->set('revisi_id', 0)->update();
        $affected = $tkr->builder()->db()->affectedRows();
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
    public function hapusmpr($id, $idmaterial, $idmaterialpenyusun)
    {
        $mprevisi = new PerhitunganMPrevisi();
        $mprevisi->where('idmaterialpenyusun', $idmaterialpenyusun)->delete();
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $materialpenyusun->builder()->where('idmaterialpenyusun', $idmaterialpenyusun)->set('revisi_id', 0)->update();
        $gettotal1 = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $affected = $mprevisi->builder()->db()->affectedRows();
        if ($affected >= 0) {
            session()->setFlashdata('berhasil',  $id . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayamaterialpenyusun/' . $idmaterial));
    }
    public function hapusmaterialpenyusun($idmaterialpenyusun, $idmaterial)
    {
        $mprevisi = new PerhitunganMPrevisi();
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $materialpenyusun->delete($idmaterialpenyusun);
        $gettotal1 = $materialpenyusun->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 0)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $gettotal2 = $mprevisi->builder()->selectSum('totalmpr')->join('perhitungan_materialpenyusun', 'perhitungan_mprevisi.idmaterialpenyusun=perhitungan_materialpenyusun.idmaterialpenyusun')->where('perhitungan_mprevisi.revisi_id', 3)->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmpr'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmpr'];
        }
        $totalsemua = $total1 + $total2;
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $material->find($idmaterial);
        $hargamaterial = $datamaterial['hargamaterial'];
        $qtymaterial = $datamaterial['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $material->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $affected = $materialpenyusun->builder()->db()->affectedRows();
        if ($affected >= 0) {
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
    public function printperhitunganbiaya($id = '')

    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
        $perhitunganbop = new PerhitunganBOPModel();
        $perhitunganbb = new PerhitunganMaterialModel();
        $perhitungantk = new PerhitunganTenakerModel();
        $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
        $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
        $perhitunganbbpenyusun = new PerhitunganMaterialPenyusunModel();

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

        // $builder3 = $perhitungantk->builder();
        // $builder3->where('idajuan', $id)->selectSum('total_gaji');
        // $query = $builder3->get();
        // $sumtk = $query->getResultArray();
        // $sumtk = intval($sumtk[0]['total_gaji']);

        // $sumall = $sumbb + $sumbop + $sumtk;


        // $perhitunganbbmodel = new PerhitunganBBModel();
        // $getdatabb = $perhitunganbbmodel->where('idajuan', $id)->findAll();

        // $perhitungantenakermodel = new PerhitunganTenakerModel();
        // $getdatatk = $perhitungantenakermodel->where('idajuan', $id)->findAll();

        // $perhitunganbopmodel = new PerhitunganBOPModel();
        // $getdatabop = $perhitunganbopmodel->where('idajuan', $id)->findAll();

        // $pengajuanproyekmodel = new AjuanProyekModel();
        // $builder = $pengajuanproyekmodel->builder();
        // $builder = $builder->select('*');
        // $builder = $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->where('idajuan', $id);
        // $query = $builder->get();
        // $getdatauser = $query->getResultArray();

        // if (empty($sumbb && $sumbop && $sumtk && $sumall && $getdatauser)) {
        //     session()->setFlashdata('pesanprint', 'Data Belum Terisi Semua !, Silakan Lengkapi Data!');
        //     return redirect()->to(base_url() . '/admin/perhitunganbiaya');
        // } else {

        //     $data = [
        //         'bb' => $getdatabb,
        //         'tk' => $getdatatk,
        //         'bop' => $getdatabop,
        //         'user' => $getdatauser,
        //         'sumbop' => $sumbop,
        //         'tanggal' => $tanggal,
        //         'sumbb' => $sumbb,
        //         'sumtk' => $sumtk,
        //         'sumall' => $sumall

        //     ];

        //     // instantiate and use the dompdf class
        $html = view('dashboard/admin/printperhitunganbiaya');
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser

        $dompdf->stream('Proposal Ajuan.pdf', array("Attachment" => false));
        // };
    }
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
            $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '5')->update();
            $ajuanproyek->builder()->where('idajuan', $idajuan)->set('file_admin', $nospacefilename)->update();
        } else {
            session()->setFlashdata('pesanemail', $send);
        }

        return redirect()->to(base_url('admin/kirimemail'));
    }
    //End Query Lain


}
