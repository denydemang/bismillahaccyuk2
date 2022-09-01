<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\ProgressProyekModel;
use App\Models\ModelLogin;
use App\Models\massagemodel;
use App\Models\MeetingModel;
use App\Models\PerhitunganBOPRevisiModel;
use App\Models\PerhitunganBBRevisiModel;
use App\Models\PerhitunganTenakerRevisiModel;
use App\Models\PerhitunganMaterialModel;


require VENDORPATH . '/autoload.php';

use Pusher;

class DashboardKLien extends Dashboard
{

    public function __construct()
    {
        parent::__construct();

        $this->datalogin['judul'] = 'Dashboard Klien';
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
    public function message($id = 0)
    {
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'message';
        $modelmassage = new massagemodel();
        // $tampung=$modelmassage->findAll();
        $tampung = $modelmassage->where('id_client', $this->user_id)->findAll();
        // $tampung2=$modelmassage->where('id_admin', $id)->findAll(); //NULL
        $modelakun = new ModelLogin();
        $akun = $modelakun->findAll();

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

    public function store2()
    {
        $modelmassage = new massagemodel();

        $id_admin = $_POST['id_admin'];
        $id_client = $_POST['id_client'];
        $nama_user = $_POST['nama_user'];
        $nama_client = $_POST['nama_client'];
        $pesan = $_POST['pesan'];

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

    //FUnction Query
    public function simpanajuanproyek()
    {
        $idajuan = $this->kodeotomatis('pengajuan_proyek', 'idajuan', 'AJP001');
        $uploadfile = $this->request->getFile('uploadfile');
        $getname = $uploadfile->getName();
        $namaproyek = $this->request->getVar('namaproyek');
        $nospacenamaproyek = str_replace(' ', '', $namaproyek);
        $pecah = explode('.', $getname);
        $getekstensi = $pecah[1];
        $filename = $idajuan . '-' . $this->request->getVar('user_id') . '-' . $nospacenamaproyek . '.' . $getekstensi;
        $uploadfile->move('fileclient', $filename);

        $user_id = $this->request->getVar('user_id');
        $namaproyek = $this->request->getVar('namaproyek');
        $jenisproyek = $this->request->getVar('jenisproyek');
        $lokasiproyek = $this->request->getVar('lokasiproyek');
        $jadwalproyek = $this->request->getVar('jadwalproyek');
        $anggaran = $this->request->getVar('anggaran');
        $anggaran = (int)(filter_var($anggaran, FILTER_SANITIZE_NUMBER_INT));
        $idajuan = $this->kodeotomatis('pengajuan_proyek', 'idajuan', 'AJP001');
        $AjuanProyekModel = new AjuanProyekModel();
        $AjuanProyekModel->insert([
            'idajuan' => $idajuan,
            'user_id' => $user_id,
            'namaproyek' => $namaproyek,
            'jenisproyek' => $jenisproyek,
            'lokasiproyek' => $lokasiproyek,
            'anggaran' => $anggaran,
            'status_id' => '1',
            'file_upload' => $filename,
            'jadwalproyek' => $jadwalproyek,
            'revisi_id' => '0'

        ]);
        session()->setFlashdata('pesan', 'berhasildiajukan');
        return redirect()->to(base_url('/klien'));
    }
    public function getmeeting($id)
    {
        $meeting = new MeetingModel();
        $data = $meeting->where('idajuan', $id)->first();
        echo json_encode($data);
    }
    public function terimaRAB($idajuan)
    {
        $perhitunganbop = new PerhitunganBOPRevisiModel();
        $perhitunganbb = new PerhitunganMaterialModel();
        $perhitungantk = new PerhitunganTenakerRevisiModel();

        $ajuanproyek = new AjuanProyekModel();
        // $perhitunganmp = new PerhitunganMaterialAsliModel();
        // $perhitunganboprevisi = new PerhitunganBOPRevisiModel();
        // $perhitungantkrevisi = new PerhitunganTenakerRevisiModel();
        // $perhitungamprevisi = new PerhitunganMPrevisi();

        $databop = $perhitunganbop->builder()->selectSum('tot_biaya')->where('idajuan', $idajuan)->get()->getResultArray();
        $sumbop = $databop[0]['tot_biaya'];

        $datatk = $perhitungantk->builder()->selectSum('total_gaji')->where('idajuan', $idajuan)->get()->getResultArray();
        $sumtk = $datatk[0]['total_gaji'];

        $databb = $perhitunganbb->builder()->selectSum('total_harga')->where('idajuan', $idajuan)->get()->getResultArray();
        $sumbb = $databb[0]['total_harga'];

        $totalRAB = (int)$sumbop + (int)$sumtk + (int)$sumbb;

        $anggaran = $ajuanproyek->builder()->select('pengajuan_proyek.anggaran')->where('idajuan', $idajuan)->get()->getResultArray();
        $anggaran = (int)$anggaran[0]['anggaran'];
        if ($totalRAB > $anggaran) {
            session()->setFlashdata('pesanrab', 'naikkananggaran');
            session()->setFlashdata('maxrab', $totalRAB);
            return redirect()->to(base_url('klien/ajuanproyek'));
        } else {
            $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '6')->update();
            $getaffectedrow = $ajuanproyek->builder()->db()->affectedRows();
            if ($getaffectedrow >= 1) {
                session()->setFlashdata('pesanrab', 'disetujui');
            } else {
                session()->setFlashdata('pesanrab', 'error');
            }
            return redirect()->to(base_url('klien/ajuanproyek'));
        }
    }
    public function tolakRAB($idajuan = false)
    {
        $alasantolak = session()->getFlashdata('alasan');
        $ajuanproyek = new AjuanProyekModel();
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '7')->update();
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('alasanpenolakan', $alasantolak)->update();
        $getaffectedrow = $ajuanproyek->builder()->db()->affectedRows();
        if ($getaffectedrow >= 1) {
            session()->setFlashdata('pesanrab', 'ditolak');
        } else {
            session()->setFlashdata('pesanrab', 'error');
        }
        return redirect()->to(base_url('klien/ajuanproyek'));
    }
    public function permintaanmeeting()
    {
        $idajuan = $this->request->getVar('idajuan');
        $ajuanproyek = new AjuanProyekModel();
        $meetingmodel = new MeetingModel();
        $meetingmodel->insert([
            'idmeeting' => '',
            'idajuan' => $idajuan,
            'namameeting' => $this->request->getVar('namameeting'),
            'lokasimeeting' => $this->request->getVar('lokasimeeting'),
            'tanggalmeeting' => $this->request->getVar('tanggalmeeting'),
        ]);
        $ajuanproyek->builder()->where('idajuan', $idajuan)->set('status_id', '8')->update();
        $getaffectedrow = $meetingmodel->builder()->db()->affectedRows();
        if ($getaffectedrow >= 1) {
            session()->setFlashdata('pesanrab', 'permintaanmeeting');
        } else {
            session()->setFlashdata('pesanrab', 'error');
        }
        return redirect()->to(base_url('klien/ajuanproyek'));
    }
    public function validasitolakrab()
    {
        if ($this->request->isAJAX()) {
            $idajuan = $this->request->getVar('idajuan');
            $alasantolak = $this->request->getVar('alasantolak');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'alasantolak' => [
                    'label' => 'Alasan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Silakan Beri {field} Penolakan'
                    ]
                ]
            ]);
            if (!$valid) {
                $error = [
                    'error' => $validation->getError('alasantolak'),
                ];
                echo json_encode($error);
            } else {
                $redirect = [
                    'redirect' => [
                        'idajuan' => $idajuan,
                    ]
                ];
                session()->setFlashdata('alasan', $alasantolak);
                echo json_encode($redirect);
            }
        } else {
            return redirect()->to(base_url('klien/ajuanproyek'));
        }
    }
    public function editanggaran()
    {
        $idajuan = $this->request->getVar('idajuan');
        $anggaran = $this->request->getVar('anggaran');
        $anggaran = filter_var($anggaran, FILTER_SANITIZE_NUMBER_INT);
        $ajuan = new AjuanProyekModel();
        $ajuan->builder()->where('idajuan', $idajuan)->set('anggaran', $anggaran)->update();
        $getaffectedrow = $ajuan->builder()->db()->affectedRows();
        if ($getaffectedrow >= 1) {
            session()->setFlashdata('pesanrab', 'editanggaran');
        } else {
            session()->setFlashdata('pesanrab', 'error');
        }
        return redirect()->to(base_url('klien/ajuanproyek'));
    }
}
