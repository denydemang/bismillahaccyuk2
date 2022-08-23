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
use App\Models\PerhitunganBBRevisiModel;
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
        $getdata = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where(['status_id' => 2, 'revisi_id' => 1])->orWhere(['status_id' => 5, 'revisi_id' => 1])->orWhere(['status_id' => 8, 'revisi_id' => 1])->get()->getResultArray();
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
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '5')->Orwhere('status_id', '8')->get()->getResultArray();
        if ($idajuan != false) {
            $perhitunganmaterial = new PerhitunganMaterialModel();
            $datajoinajuan = $perhitunganmaterial->builder()->join('pengajuan_proyek', 'perhitungan_material.idajuan=pengajuan_proyek.idajuan')->where('pengajuan_proyek.idajuan', $idajuan)->get()->getResultArray();
            $idmaterial = $this->kodeotomatis('perhitungan_material', 'idmaterial', 'PBB001');
            $data = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $idajuan)->get()->getResultArray();
            if (empty($data)) {
                $idajuan = '';
            } else {
                $idajuan = $idajuan;
            }
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
        if (isset($_SESSION['aktif']) || isset($_SESSION['subaktif'])) {
            unset($_SESSION['aktif']);
            unset($_SESSION['subaktif']);
        };
        $_SESSION['aktif'] = 'pb';
        $_SESSION['subaktif'] = 'pbmaterial';
        if ($idmaterial != false) {
            $idmaterialpenyusun = $this->kodeotomatis('perhitungan_materialpenyusun', 'idmaterialpenyusun', 'PBP001');
            $mprevisi = new PerhitunganMPrevisi();
            $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
            $Perhitunganmaterial = new PerhitunganMaterialModel();
            $getdatamaterial = $Perhitunganmaterial->where('idmaterial', $idmaterial)->find();
            $getdatamprevisi = $mprevisi->where('idmaterial', $idmaterial)->where('revisi_id', 3)->find();
            $getdatamaterialpenyusun = $perhitunganmaterialpenyusun->where('idmaterial', $idmaterial)->find();
            if (!empty($getdatamaterial)) {

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
        // $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
        // $getdata = $perhitunganmaterialpenyusun->getbyidmaterial($idmaterial);
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
        $tenakerr = new PerhitunganTenakerRevisiModel();
        $tenaker = new PerhitunganTenakerModel();
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '5')->Orwhere('status_id', '8')->get()->getResultArray();
        if ($id != false) {
            $datatkrevisi = $tenakerr->where('revisi_id', 3)->where('idajuan', $id)->find();
            $getdata = $tenaker->where('idajuan', $id)->find();
            $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PTK001');
            $data = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $id)->get()->getResultArray();
            if (empty($data)) {
                $idajuan = '';
            } else {
                $idajuan = $id;
            }
        } else {

            $tenakerr = new PerhitunganTenakerRevisiModel();
            $datatkrevisi = $tenakerr->where('revisi_id', 3)->find();
            $getdata = $tenaker->findAll();
            $id_pbtenaker = $this->kodeotomatis('perhitungantenaker', 'id_pbtenaker', 'PTK001');
            $idajuan = '';
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
        $dataajuan = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('status_id', '2')->Orwhere('status_id', '5')->Orwhere('status_id', '8')->get()->getResultArray();
        if ($id != false) {
            $getdatabop = $bop->where('idajuan', $id)->find();
            $getdatabopr = $bopr->where('revisi_id', 3)->where('idajuan', $id)->find();
            $data = $ajuan->builder()->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $id)->get()->getResultArray();
            if (empty($data)) {
                $idajuan = '';
            } else {
                $idajuan = $id;
            }
        } else {
            $getdatabop = $bop->findAll();
            $getdatabopr = $bopr->where('revisi_id', 3)->find();
            $idajuan = '';
        }
        $id_pbop = $this->kodeotomatis('perhitunganbop', 'id_pbop', 'PBO001');

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
        $tenaker     = new PerhitunganTenakerRevisiModel();
        $bop     = new PerhitunganBOPRevisiModel();
        $gettotbb = $bahanbaku->builder()->selectSum('total_harga')->where('idajuan', $idajuan)->get()->getResultArray();
        $gettottk = $tenaker->builder()->selectSum('total_gaji')->where('idajuan', $idajuan)->get()->getResultArray();
        $gettotbop = $bop->builder()->selectSum('tot_biaya')->where('idajuan', $idajuan)->get()->getResultArray();

        $jumlahbiayatotal = (intval($gettotbb[0]['total_harga']) + intval($gettottk[0]['total_gaji']) + intval($gettotbop[0]['tot_biaya']));
        return $jumlahbiayatotal;
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
            $getdata = $bopr->find($id);
            echo json_encode($getdata);
        }
    }
    public function getdatampr($id)
    {
        if ($this->request->isAJAX()) {
            $mpr = new PerhitunganMPrevisi();
            $getdata = $mpr->find($id);
            echo json_encode($getdata);
        }
    }
    public function getdatatenaker($idtenaker)
    {
        if ($this->request->isAJAX()) {
            $tk = new PerhitunganTenakerRevisiModel();
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

            $materialpendukung = new PerhitunganMPrevisi();
            $getdata = $materialpendukung->builder()->select('perhitungan_materialpenyusunrev.*,perhitungan_material.idajuan')->join('perhitungan_material', 'perhitungan_materialpenyusunrev.idmaterial=perhitungan_material.idmaterial')->where('perhitungan_materialpenyusunrev.idmaterialpenyusun', $idmp)->get()->getResultArray();
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
            $getdatapenyusun = $bahanpenyusun->where('idmaterial', $idmaterial)->find();
            $getdatrevisi = $mprevisi->where('idmaterial', $idmaterial)->where('revisi_id', 3)->findAll();
            $total1 = $bahanpenyusun->builder()->selectSum('totalmp')->where('idmaterial', $idmaterial)->get()->getResultArray();
            $total2 = $mprevisi->builder()->selectSum('totalmp')->where('idmaterial', $idmaterial)->get()->getResultArray();
            if (empty($total1[0]['totalmp'])) {
                $total1 = 0;
            } else {
                $total1 = $total1[0]['totalmp'];
            }
            if (empty($total2[0]['totalmp'])) {
                $total2 = 0;
            } else {
                $total2 = $total2[0]['totalmp'];
            }
            $totalsemua = (int)$total1 + (int)$total2;

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
        $namampr = $this->request->getVar('namampr');
        $idmaterialpenyusun = $this->request->getVar('idmaterialpenyusun');
        $spesifikasimpr = $this->request->getVar('spesifikasimpr');
        $jumlahmpr = $this->request->getVar('jumlahmpr');
        $satuanmpr = $this->request->getVar('satuanmpr');
        $hargampr = $this->request->getVar('hargampr');
        $hargampr = (int)filter_var($hargampr, FILTER_SANITIZE_NUMBER_INT);
        $totalmpr = $this->request->getVar('totalmpr');
        $totalmpr = (int)filter_var($totalmpr, FILTER_SANITIZE_NUMBER_INT);
        $mprevisi->update($idmaterialpenyusun, [
            'idmaterial' => $idmaterial,
            'namamp' => $namampr,
            'spesifikasimp' => $spesifikasimpr,
            'jumlahmp' => $jumlahmpr,
            'satuanmp' => $satuanmpr,
            'hargamp' => $hargampr,
            'totalmp' => $totalmpr,

        ]);

        $gettotal1 = $mprevisi->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $totalsemua = 0;
        } else {
            $totalsemua = (int)$gettotal1[0]['totalmp'];
        }
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
        $bopr = new PerhitunganBOPRevisiModel();
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
        $bopr->insert([
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
        $tenakerr = new PerhitunganTenakerRevisiModel();
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

        $tenakerr->insert([
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

        ]);
        $mprevisi->insert([
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
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('revisi_id', 1)->update();
        $gettotal = $mprevisi->builder()->selectSum('totalmp')->get()->getResultArray();
        if (empty($gettotal[0]['totalmp'])) {
            $total = 0;
        } else {
            $total = (int)$gettotal[0]['totalmp'];
        }
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total)->update();
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
    public function edittenakerrevisi($id)
    {
        $tkr = new PerhitunganTenakerRevisiModel();
        $tk = new PerhitunganTenakerModel();

        $getdata = $tk->where('id_pbtenaker', $id)->first();
        $idajuan = $this->request->getVar('idajuan');
        $id_pbtenaker = $getdata['id_pbtenaker'];
        $jobdesk = $getdata['jobdesk'];
        $gaji = $getdata['gaji'];
        $total_pekerja = $getdata['total_pekerja'];
        $total_gaji = $getdata['total_gaji'];
        $tkr->update($id_pbtenaker, [
            'jobdesk' =>  $jobdesk,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' =>  $total_gaji,
            'revisi_id' => 0
        ]);
        $affected = $tkr->builder()->db()->affectedRows();
        if ($affected >= 0) {
            session()->setFlashdata('berhasil', 'Data ' . $id_pbtenaker . ' Berhasil DiHapus Revisinya');
        } else {
            session()->setFlashdata('gagal', 'Gagal Dihapus');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }
    public function editrevisibop()
    {
        // $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $id_pbop = $this->request->getVar('id_pbop');
        $namatrans = $this->request->getVar('namatrans');
        $satuan = $this->request->getVar('satuan');
        $quantity = $this->request->getVar('quantity');
        $harga = $this->request->getVar('harga');
        $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getVar('tot_biaya');
        $tot_biaya = (int)filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        $bopr->update($id_pbop, [
            'namatrans' => $namatrans,
            'satuan' => $satuan,
            'quantity' => $quantity,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
            'revisi_id' => 3
        ]);
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
        $jobdesk = $this->request->getVar('jobdesk1');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan1');
        $gaji = $this->request->getVar('gaji1');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja1');
        $total_gaji = $this->request->getVar('total_gaji1');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);
        $tkr->update($id_pbtenaker, [
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
        ]);
        $affected = $tkr->builder()->db()->affectedRows();
        if ($affected == 0) {
            session()->setFlashdata('gagal', 'Tidak Ada Data Yang Diubah');
        } else if ($affected > 0) {
            session()->setFlashdata('berhasil', 'Data ' . $id_pbtenaker . ' Berhasil Diupdate');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Diupdate');
        }
        return redirect()->to(base_url('admin/perhitunganbiayatenaker'));
    }


    public function revisibop()
    {
        $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $id_pbop = $this->request->getVar('id_pbop');
        $namatrans = $this->request->getVar('namatrans');
        $satuan = $this->request->getVar('satuan');
        $quantity = $this->request->getVar('quantity');
        $harga = $this->request->getVar('harga');
        $harga = (int)filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getVar('tot_biaya');
        $tot_biaya = (int)filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        $bopr->update($id_pbop, [
            'namatrans' => $namatrans,
            'satuan' => $satuan,
            'quantity' => $quantity,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
            'revisi_id' => 3
        ]);
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
        $jobdesk = $this->request->getVar('jobdesk');
        $statuspekerjaan = $this->request->getVar('statuspekerjaan');
        $gaji = $this->request->getVar('gaji');
        $gaji = (int)filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $total_pekerja = $this->request->getVar('total_pekerja');
        $total_gaji = $this->request->getVar('total_gaji');
        $total_gaji = (int)filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);
        $tkr->update($id_pbtenaker, [
            'jobdesk' => $jobdesk,
            'statuspekerjaan' => $statuspekerjaan,
            'gaji' => $gaji,
            'total_pekerja' => $total_pekerja,
            'total_gaji' => $total_gaji,
            'revisi_id' => 3
        ]);

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
        $mprevisi->update($idmaterialpenyusun, [
            'namamp' => $namamp,
            'spesifikasimp' => $spesifikasimp,
            'satuanmp' => $satuanmp,
            'jumlahmp' => $jumlahmp,
            'hargamp' => $hargamp,
            'totalmp' => $totalmp,
            'revisi_id' => 3
        ]);

        $gettotal1 = $mprevisi->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $total1 = 0;
        } else {
            $total1 = (int)$gettotal1[0]['totalmp'];
        }
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total1)->update();
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
        $gettotal1 = $mprevisi->selectSum('totalmp')->where('idmaterial', $idmaterial)->find();
        if (empty($gettotal1[0]['totalmp'])) {
            $totalsemua = 0;
        } else {
            $totalsemua = (int)$gettotal1[0]['totalmp'];
        }
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
        $bopr = new PerhitunganBOPRevisiModel();
        $bop->delete($id);

        $affected = $bop->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'ID :' . $id . ' Berhasil DiHapus');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal DiHapus');
        }
        $bopr->delete($id);
        return redirect()->to(base_url('admin/perhitunganbiayalain'));
    }
    public function hapusbopr($idpbop)
    {
        $bop = new PerhitunganBOPModel();
        $bopr = new PerhitunganBOPRevisiModel();
        $getdata = $bop->find($idpbop);
        $namatrans = $getdata['namatrans'];
        $quantity = $getdata['quantity'];
        $satuan = $getdata['satuan'];
        $harga = $getdata['harga'];
        $tot_biaya = $getdata['tot_biaya'];
        $bopr->update($idpbop, [
            'namatrans' => $namatrans,
            'quantity' => $quantity,
            'satuan' => $satuan,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya,
            'revisi_id' => 0
        ]);
        $affected = $bop->builder()->db()->affectedRows();
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
        $tkr = new PerhitunganTenakerRevisiModel();
        $tk->delete($id);
        $tkr->delete($id);

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
    public function hapusmpr($id, $idmaterial)
    {
        $mprevisi = new PerhitunganMPrevisi();
        $material = new PerhitunganMaterialModel();
        $materialpenyusun = new PerhitunganMaterialPenyusunModel();
        $getdata = $materialpenyusun->find($id);
        $spesifikasi = $getdata['spesifikasimp'];
        $satuan = $getdata['satuanmp'];
        $jumlah = $getdata['jumlahmp'];
        $harga = $getdata['hargamp'];
        $total = $getdata['totalmp'];
        $mprevisi->update($id, [
            'spesifikasimp' => $spesifikasi,
            'satuanmp' => $satuan,
            'jumlahmp' => $jumlah,
            'hargamp' => $harga,
            'hargamp' => $harga,
            'totalmp' => $total,
            'revisi_id' => 0
        ]);
        $gettotal2 = $mprevisi->builder()->selectSum('totalmp')->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal2[0]['totalmp'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmp'];
        }
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total2)->update();
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
        $mprevisi->delete($idmaterialpenyusun);
        $gettotal2 = $mprevisi->selectSum('totalmp')->find();
        if (empty($gettotal2[0]['totalmp'])) {
            $total2 = 0;
        } else {
            $total2 = (int)$gettotal2[0]['totalmp'];
        }
        $material->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $total2)->update();
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
    public function printperhitunganbiayarevisi($id = false)

    {
        if ($id != false) {

            date_default_timezone_set('Asia/Jakarta');
            $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
            $perhitunganbop = new PerhitunganBOPModel();
            $perhitunganbb = new PerhitunganMaterialModel();
            $perhitungantk = new PerhitunganTenakerModel();
            $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
            $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
            $perhitungamprevisi = new PerhitunganMPrevisi();

            $databopr = $perhitunganboprevisi->builder()->selectSum('tot_biaya')->where('idajuan', $id)->get()->getResultArray();
            $sumbop = $databopr[0]['tot_biaya'];

            $datatk = $perhitungantkrevisi->builder()->selectSum('total_gaji')->where('idajuan', $id)->get()->getResultArray();
            $sumtk = $datatk[0]['total_gaji'];

            $databb = $perhitunganbb->builder()->selectSum('total_harga')->where('idajuan', $id)->get()->getResultArray();
            $sumbb = $databb[0]['total_harga'];

            $total = (int)$sumbop + (int)$sumtk + (int)$sumbb;


            $pengajuanproyekmodel = new AjuanProyekModel();
            $builder = $pengajuanproyekmodel->builder();
            $builder = $builder->select('*');
            $getdatauser = $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $id)->get()->getResultArray();

            $bb = $perhitunganbb->where('idajuan', $id)->find();
            $tk = $perhitungantkrevisi->where('idajuan', $id)->find();
            $bop = $perhitunganboprevisi->where('idajuan', $id)->find();



            $revisibop = $perhitunganboprevisi->where('revisi_id', 3)->find();
            $mprevisi = $perhitungamprevisi->where('revisi_id', 3)->find();
            $tkrevisi = $perhitungantkrevisi->where('revisi_id', 3)->find();

            if (empty($revisibop) && empty($mprevisi) && empty($tkrevisi) || empty($getdatauser)) {
                session()->setFlashdata('pesanprint', 'Tidak Data Yang Direvisi');
                return redirect()->to(base_url() . '/admin/cetakrab');
            } else {
                $data = [
                    'bb' => $bb,
                    'bbrevisi' => $mprevisi,
                    'tk' => $tk,
                    'tkrevisi' => $tkrevisi,
                    'bop' => $bop,
                    'boprevisi' => $revisibop,
                    'user' => $getdatauser,
                    'sumbop' => $sumbop,
                    'tanggal' => $tanggal,
                    'sumbb' => $sumbb,
                    'sumtk' => $sumtk,
                    'sumall' => $total,

                ];
                $dompdf = new Dompdf();

                // //     // instantiate and use the dompdf class
                $html = view('dashboard/admin/printperhitunganbiaya', $data);


                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'landscape');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser

                $dompdf->stream('Proposal Ajuan.pdf', array("Attachment" => false));
            }
        } else {
            return redirect()->to(base_url('admin/cetakrab'));
        }


        // if (empty($sumtkr && $sumbopr && $sumbb && $getdatauser)) {
        //     session()->setFlashdata('pesanprint', 'Tidak Data Yang Direvisi');
        //     return redirect()->to(base_url() . '/admin/cetakrab');
        // } else {
        //     $data = [
        //         'bb' => $getdatabb,
        //         'bbrevisi' => $getdatabbrevisi,
        //         'tk' => $getdatatk,
        //         'tkrevisi' => $getdatatkrevisi,
        //         'bop' => $getdatabop,
        //         'boprevisi' => $getdataboprevisi,
        //         'user' => $getdatauser,
        //         'sumbop' => $totbop,
        //         'tanggal' => $tanggal,
        //         'sumbb' => $sumbb,
        //         'sumtk' => $totaltk,
        //         'sumall' => $totalsemuabiaya

        //     ];
        // }


        // $options = new Options();
        // $options->set('defaultFont', 'Courier');

    }
    public function printperhitunganbiaya($id = false)

    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
        $perhitunganbop = new PerhitunganBOPModel();
        $perhitunganbb = new PerhitunganMaterialModel();
        $perhitungantk = new PerhitunganTenakerModel();
        $perhitunganmp = new PerhitunganMaterialPenyusunModel();
        $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
        $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
        $perhitungamprevisi = new PerhitunganMPrevisi();

        $databop = $perhitunganbop->builder()->selectSum('tot_biaya')->where('idajuan', $id)->get()->getResultArray();
        $sumbop = $databop[0]['tot_biaya'];

        $datatk = $perhitungantk->builder()->selectSum('total_gaji')->where('idajuan', $id)->get()->getResultArray();
        $sumtk = $datatk[0]['total_gaji'];

        $databb = $perhitunganmp->builder()->join('perhitungan_material', 'perhitungan_materialpenyusun.idmaterial=perhitungan_material.idmaterial')->selectSum('total_harga')->where('idajuan', $id)->get()->getResultArray();
        $sumbb = $databb[0]['total_harga'];

        $bb = $perhitunganmp->select('perhitungan_materialpenyusun.*,perhitungan_material.idajuan')->join('perhitungan_material', 'perhitungan_materialpenyusun.idmaterial=perhitungan_material.idmaterial')->where('idajuan', $id)->find();
        $tk = $perhitungantk->where('idajuan', $id)->find();
        $bop = $perhitunganbop->where('idajuan', $id)->find();

        $total = (int)$sumbop + (int)$sumtk + (int)$sumbb;


        $pengajuanproyekmodel = new AjuanProyekModel();
        $builder = $pengajuanproyekmodel->builder();
        $builder = $builder->select('*');
        $getdatauser = $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idajuan', $id)->get()->getResultArray();

        if ($id != false) {
            if (empty($sumbop) && empty($sumtk) && empty($sumbb)) {
                session()->setFlashdata('pesanprint', 'Silakan Isi Data Dulu');
                return redirect()->to(base_url() . '/admin/cetakrab');
            } else {
                $data = [
                    'bb' => $bb,
                    'tk' => $tk,
                    'bop' => $bop,
                    'user' => $getdatauser,
                    'sumbop' => $sumbop,
                    'tanggal' => $tanggal,
                    'sumbb' => $sumbb,
                    'sumtk' => $sumtk,
                    'sumall' => $total,

                ];
                $dompdf = new Dompdf();

                // //     // instantiate and use the dompdf class
                $html = view('dashboard/admin/printperhitunganbiayaasli', $data);


                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'landscape');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser

                $dompdf->stream('Proposal Ajuan.pdf', array("Attachment" => false));
            }
        } else {
            return redirect()->to(base_url('admin/cetakrab'));
        }


        // if (empty($sumtkr && $sumbopr && $sumbb && $getdatauser)) {
        //     session()->setFlashdata('pesanprint', 'Tidak Data Yang Direvisi');
        //     return redirect()->to(base_url() . '/admin/cetakrab');
        // } else {
        //     $data = [
        //         'bb' => $getdatabb,
        //         'bbrevisi' => $getdatabbrevisi,
        //         'tk' => $getdatatk,
        //         'tkrevisi' => $getdatatkrevisi,
        //         'bop' => $getdatabop,
        //         'boprevisi' => $getdataboprevisi,
        //         'user' => $getdatauser,
        //         'sumbop' => $totbop,
        //         'tanggal' => $tanggal,
        //         'sumbb' => $sumbb,
        //         'sumtk' => $totaltk,
        //         'sumall' => $totalsemuabiaya

        //     ];
        // }


        // $options = new Options();
        // $options->set('defaultFont', 'Courier');

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
