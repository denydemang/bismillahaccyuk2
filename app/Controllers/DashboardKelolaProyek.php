<?php

namespace App\Controllers;

use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
use App\Models\TenakerModel;
use App\Models\BahanBakuProsesModel;
use App\Models\BOPModel;
use App\Models\MaterialUtamaModel;
use App\Models\PembayaranProyek;
use App\Models\PerhitunganBOPRevisiModel;
use App\Models\PerhitunganMaterialModel;
use App\Models\PerhitunganMaterialPenyusunModel;
use App\Models\PerhitunganMPrevisi;
use App\Models\PerhitunganTenakerRevisiModel;


use Dompdf\Dompdf;
use Dompdf\Options;

class DashboardKelolaProyek extends Dashboard
{

    public function __construct()
    {
        parent::__construct();
        $this->idproyek = session()->get('idproyek');
        $builder = $this->db->table('proyek');
        $builder->select('*');
        $builder->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $builder->where('idproyek', $this->idproyek);
        $query = $builder->get();
        $hasil = $query->getResultArray();

        $this->datalogin += [
            'idproyek' => $this->idproyek,
            'dataproyek' => $hasil
        ];
        $this->datalogin['judul'] = 'Dashboard Kelola Proyek';
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
    public function index()
    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'home';

        return view('dashboard/kelolaproyek/welcome', $this->datalogin);
    }
    public function bbmaterialpenyusun($idmaterial = false)

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $idajuan =  session()->get('idajuan');
        // $perhitunganmaterialpenyusun = new PerhitunganMaterialPenyusunModel();
        $Perhitunganmaterial = new PerhitunganMaterialModel();
        $mprevisi =  new PerhitunganMPrevisi();
        $mprevisi = new PerhitunganMPrevisi();
        if ($idmaterial != false) {
            $data =  $mprevisi->builder()->where('idmaterial', $idmaterial)->get()->getResultArray();
        } else {
            return redirect()->to('kelolaproyek/bbmaterialutama');
        }
        $this->datalogin += [
            'databb' => $data,
        ];
        $_SESSION['aktif'] = 'bbdalamproses';
        return view('dashboard/kelolaproyek/bbmaterialpenyusun', $this->datalogin);
    }
    public function bbmaterialutama()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $idproyek =  session()->get('idproyek');

        $material = new MaterialUtamaModel();
        $data =  $material->builder()
            ->select('material_utama.hargamaterial,material_utama.total_harga,perhitungan_material.idmaterial,perhitungan_material.namamaterial,perhitungan_material.jenismaterial,perhitungan_material.satuanmaterial,perhitungan_material.qtymaterial')
            ->join('perhitungan_material', 'material_utama.idmaterial=perhitungan_material.idmaterial')
            ->where('material_utama.idproyek', $idproyek)->get()->getResultArray();
        $this->datalogin += [
            'datamaterial' => $data,
        ];
        $_SESSION['aktif'] = 'bbdalamproses';
        return view('dashboard/kelolaproyek/bbmaterialutama', $this->datalogin);
    }
    public function tenagakerja()

    {

        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $idproyek = session()->get('idproyek');
        $idajuan = session()->get('idajuan');
        $_SESSION['aktif'] = 'tenagakerja';
        $datatenaker = new PerhitunganTenakerRevisiModel();
        $getdata = $datatenaker->where('idajuan', $idajuan)->find();
        $idtenaker = $this->kodeotomatis('tenaker', 'id_sewatenaker', 'STK001');
        $this->datalogin += [
            'datatenaker' => $getdata,
            'idproyek' => $idproyek,
            'idtenaker' => $idtenaker
        ];

        return view('dashboard/kelolaproyek/tenagakerja', $this->datalogin);
    }
    function progressproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        $idajuan = session()->get('idajuan');
        $ajuan = new AjuanProyekModel();
        $progress = new ProgressProyekModel();
        $idproyek = session()->get('idproyek');
        $namaproyek = $ajuan->where('idajuan', $idajuan)->first();
        $namaproyek = $namaproyek['namaproyek'];
        $dataprogress = $progress->where('idproyek', $idproyek)->find();
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $this->datalogin += [
            'idproyek' => $idproyek,
            'namaproyek' => $namaproyek,
            'progress' => $dataprogress
        ];
        $_SESSION['aktif'] = 'progressproyek';
        return view('dashboard/kelolaproyek/progressproyek', $this->datalogin);
    }
    function pembayaranproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $pembayaranproyek = new PembayaranProyek();
        $idproyek = session()->get('idproyek');
        $pembayaranproyek =  $pembayaranproyek->where('idproyek', $idproyek)->find();
        $this->datalogin += [
            'idproyek' => $idproyek,
            'pembayaranproyek' => $pembayaranproyek
        ];
        $_SESSION['aktif'] = 'pembayaranproyek';
        return view('dashboard/kelolaproyek/pembayaranproyek', $this->datalogin);
    }
    function kelolabiayaoperasional()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        $idajuan = session()->get('idajuan');
        $boprevisi = new PerhitunganBOPRevisiModel();
        $data = $boprevisi->where('idajuan', $idajuan)->find();
        $id_pbopr = $this->kodeotomatis('transaksibop', 'id_pbopr', 'TOP001');
        $idproyek = session()->get('idproyek');
        $this->datalogin += [
            'kelolabop' => $data,
            'id_pbopr' => $id_pbopr,
            'idproyek' => $idproyek
        ];

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'kelolabiayaoperasional';
        return view('dashboard/kelolaproyek/kelolabiayaoperasional', $this->datalogin);
    }
    function laporanhpp()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $idproyek = session()->get('idproyek');
        $idajuan = session()->get('idajuan');
        $bb = new MaterialUtamaModel();
        $tk = new TenakerModel();
        $bop = new BOPModel();
        $bbrab = new PerhitunganMaterialModel();
        $tkrab = new PerhitunganTenakerRevisiModel();
        $boprab = new PerhitunganBOPRevisiModel();

        $sumbbrab = $bbrab->builder()->selectSum('total_harga')
            ->where('idajuan', $idajuan)->get()->getResultArray();
        $sumbbrab = $sumbbrab[0]['total_harga'];
        $sumtkrab = $tkrab->builder()->selectSum('total_gaji')
            ->where('idajuan', $idajuan)->get()->getResultArray();
        $sumtkrab = $sumtkrab[0]['total_gaji'];
        $sumboprab = $boprab->builder()->selectSum('tot_biaya')
            ->where('idajuan', $idajuan)->get()->getResultArray();
        $sumboprab = $sumboprab[0]['tot_biaya'];

        $sumbb = $bb->selectSum('total_harga')->where('idproyek', $idproyek)->find();
        $sumbb = $sumbb[0]['total_harga'];
        $sumtk = $tk->selectSum('total_gaji')->where('idproyek', $idproyek)->find();
        $sumtk = $sumtk[0]['total_gaji'];
        $sumbop = $bop->selectSum('tot_biaya')->where('idproyek', $idproyek)->find();
        $sumbop = $sumbop[0]['tot_biaya'];

        $biayaasli = (int)$sumbb + (int)$sumtk + (int)$sumbop;
        $biayaRAB = (int)($sumbbrab) + (int)($sumtkrab) + (int)$sumboprab;
        $selisih = $biayaRAB - $biayaasli;

        $_SESSION['aktif'] = 'laporanhpp';
        $this->datalogin += [
            'selisih' => $selisih,
            'biayaasli' => $biayaasli,
            'biayaRAB' => $biayaRAB,
            ''

        ];
        return view('dashboard/kelolaproyek/laporanhpp', $this->datalogin);
    }
    function backtodataproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }

        session()->set('kelolaproyek', '');
        session()->set('idproyek', '');
        session()->set('idajuan', '');
        return redirect()->to(base_url('admin/dataproyek'));
    }
    public function tampilkodeotomatis()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'idproyek' => $this->idproyek,
                'idtenaker' => $this->kodeotomatis('tenaker', 'idtenaker', 'TKJ001'),
                'idbeli' => $this->kodeotomatis('belibahan', 'idbelibahan', 'BBB001')

            ];
            echo json_encode($data);
        }
    }
    public function printhpp()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->tanggal_indonesia(date('Y-m-d'));
        $idajuan = session()->get('idajuan');
        $idproyek = session()->get('idproyek');
        $bb = new MaterialUtamaModel();
        $penyusun = new BahanBakuProsesModel();
        $tk = new TenakerModel();
        $bop = new BOPModel();

        $datapenyusun = $penyusun->builder()
            ->select('belibahan.harga_beli,belibahan.totalharga,pmprev.idmaterial,pmprev.namamp,pmprev.spesifikasimp,pmprev.satuanmp,pmprev.jumlahmp')
            ->join('perhitungan_materialpenyusunrev as pmprev', 'belibahan.idmaterialpenyusun=pmprev.idmaterialpenyusun')
            ->where('idproyek', $idproyek)
            ->get()->getResultArray();
        $databb = $bb->builder()
            ->select('material_utama.idmaterial,material_utama.hargamaterial,material_utama.total_harga, pm.namamaterial,pm.qtymaterial')
            ->join('perhitungan_material as pm', 'material_utama.idmaterial=pm.idmaterial')
            ->where('idproyek', $idproyek)
            ->get()->getResultArray();
        $datatk = $tk->builder()
            ->select('tenaker.gaji,tenaker.total_gaji,pt.jobdesk,pt.statuspekerjaan,pt.total_pekerja')
            ->join('perhitungantenakerrev as pt', 'tenaker.id_pbtenaker=pt.id_pbtenaker')
            ->where('idproyek', $idproyek)
            ->get()->getResultArray();
        $databop = $bop->builder()
            ->select('transaksibop.harga,transaksibop.tot_biaya,pb.namatrans,pb.quantity,pb.satuan')
            ->join('perhitunganboprev as pb', 'transaksibop.id_pbop=pb.id_pbop')
            ->where('idproyek', $idproyek)
            ->get()->getResultArray();

        $sumbb = $bb->selectSum('total_harga')->where('idproyek', $idproyek)->find();
        $sumbb = $sumbb[0]['total_harga'];
        $sumtk = $tk->selectSum('total_gaji')->where('idproyek', $idproyek)->find();
        $sumtk = $sumtk[0]['total_gaji'];
        $sumbop = $bop->selectSum('tot_biaya')->where('idproyek', $idproyek)->find();
        $sumbop = $sumbop[0]['tot_biaya'];
        $sumpenyusun = $penyusun->selectSum('totalharga')->where('idproyek', $idproyek)->find();
        $sumpenyusun = $sumpenyusun[0]['totalharga'];
        $total = (int)$sumbb + (int)$sumtk + (int)$sumbop;

        $proyekmodel = new ProyekModel();
        $builder = $proyekmodel->builder();
        $builder = $builder->select('*');
        $getdatauser = $builder->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan')->join('akun', 'pengajuan_proyek.user_id=akun.user_id')->where('idproyek', $idproyek)->get()->getResultArray();

        if (empty($sumbb) && empty($sumtk) && empty($sumbop) || empty($getdatauser)) {
            session()->setFlashdata('pesanprint', 'Lengkapi Data Terlebih Dahulu');
            return redirect()->to(base_url() . '/kelolaproyek/laporanhpp');
        } else {
            $data = [
                'bb' => $databb,
                'tk' => $datatk,
                'bop' => $databop,
                'tanggal' => $tanggal,
                'sumbb' => $sumbb,
                'sumtk' => $sumtk,
                'sumbop' => $sumbop,
                'sumpenyusun' => $sumpenyusun,
                'total' => $total,
                'user' => $getdatauser

            ];

            $dompdf = new Dompdf();

            // //     // instantiate and use the dompdf class
            $html = view('dashboard/kelolaProyek/printperhitunganbiaya2', $data);


            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'potrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser

            $dompdf->stream('Proposal Ajuan.pdf', array("Attachment" => false));
        }
    }
    // Pengelolaan Tenaga Kerja
    public function simpantenaker()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'namatenaker' => [
                    'label' => 'Nama Tenaga Kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'almttenaker' => [
                    'label' => 'ALamat Tenaga Kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'belum_bayar' => [
                    'label' => 'Field Ini',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sudah_bayar' => [
                    'label' => 'Field Ini',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $data = [
                    'errors' => [
                        'namatenaker' => $validation->getError('namatenaker'),
                        'almttenaker' => $validation->getError('almttenaker'),
                        'pekerjaan' => $validation->getError('pekerjaan'),
                        'gaji' => $validation->getError('gaji'),
                        'sudah_bayar' => $validation->getError('sudah_bayar'),
                        'belum_bayar' => $validation->getError('belum_bayar'),
                    ]
                ];
                echo json_encode($data);
            } else {
                $tenakermodel = new TenakerModel();
                $gaji = $this->request->getVar('gaji');
                $gaji = (int)(filter_var($gaji, FILTER_SANITIZE_NUMBER_INT));
                $belum_bayar = $this->request->getVar('belum_bayar');
                $belum_bayar = (int)(filter_var($belum_bayar, FILTER_SANITIZE_NUMBER_INT));
                $sudah_bayar = $this->request->getVar('sudah_bayar');
                $sudah_bayar = (int)(filter_var($sudah_bayar, FILTER_SANITIZE_NUMBER_INT));
                $simpandata = [
                    'idtenaker' => $this->request->getVar('idtenaker'),
                    'idproyek' => $this->request->getVar('idproyek'),
                    'namatenaker' => $this->request->getVar('namatenaker'),
                    'almttenaker' => $this->request->getVar('almttenaker'),
                    'pekerjaan' => $this->request->getVar('pekerjaan'),
                    'gaji' => $gaji,
                    'sudah_bayar' => $sudah_bayar,
                    'belum_bayar' => $belum_bayar,

                ];
                $tenakermodel->insert($simpandata);

                // query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                // optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $tenakermodel->builder();
                $hasil = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $hasil,
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    public function detailtenaker($idtk = false)
    {
        if ($this->request->isAJAX()) {
            $tenakermodel = new TenakerModel();
            $getdata = $tenakermodel->where('idproyek', $this->idproyek)->where('idtenaker', $idtk)->find();
            echo json_encode($getdata);
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    public function updatetenaker($idtk = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'namatenaker' => [
                    'label' => 'Nama Tenaga Kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'almttenaker' => [
                    'label' => 'ALamat Tenaga Kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'gaji' => [
                    'label' => 'Gaji',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'Pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'belum_bayar' => [
                    'label' => 'Field Ini',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'sudah_bayar' => [
                    'label' => 'Field Ini',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $data = [
                    'errors' => [
                        'namatenaker' => $validation->getError('namatenaker'),
                        'almttenaker' => $validation->getError('almttenaker'),
                        'pekerjaan' => $validation->getError('pekerjaan'),
                        'gaji' => $validation->getError('gaji'),
                        'sudah_bayar' => $validation->getError('sudah_bayar'),
                        'belum_bayar' => $validation->getError('belum_bayar'),
                    ]
                ];
                echo json_encode($data);
            } else {
                $tenakermodel = new TenakerModel();
                $gaji = $this->request->getVar('gaji');
                $gaji = (int)(filter_var($gaji, FILTER_SANITIZE_NUMBER_INT));
                $belum_bayar = $this->request->getVar('belum_bayar');
                $belum_bayar = (int)(filter_var($belum_bayar, FILTER_SANITIZE_NUMBER_INT));
                $sudah_bayar = $this->request->getVar('sudah_bayar');
                $sudah_bayar = (int)(filter_var($sudah_bayar, FILTER_SANITIZE_NUMBER_INT));
                $simpandata = [
                    'idproyek' => $this->request->getVar('idproyek'),
                    'namatenaker' => $this->request->getVar('namatenaker'),
                    'almttenaker' => $this->request->getVar('almttenaker'),
                    'pekerjaan' => $this->request->getVar('pekerjaan'),
                    'gaji' => $gaji,
                    'belum_bayar' => $belum_bayar,
                    'sudah_bayar' => $sudah_bayar,

                ];
                $tenakermodel->where('idtenaker', $idtk)->set($simpandata)->update();

                // query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                // optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah

                $builder = $tenakermodel->builder();
                $hasil = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $hasil,
                    'notifidtenaker' => $idtk,
                    'notifnamatenaker' => $this->request->getVar('namatenaker')
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    public function hapustenaker($idtenaker = false)
    {
        if ($this->request->isAjax()) {

            $tenakermodel = new TenakerModel();
            $tenakermodel->delete($idtenaker);
            $builder = $tenakermodel->builder();
            $hasil = $builder->db()->affectedRows();
            $baristerpengaruh = [
                'affected' => $hasil,
            ];
            echo json_encode($baristerpengaruh);
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    public function getdatatenaker($idtenaker = false)
    {
        if ($this->request->isAjax()) {
            $tenakermodel = new TenakerModel();

            $result = $tenakermodel->where('idtenaker', $idtenaker)->find();
            echo json_encode($result);
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    // End Pengelolaan Tenaker

    //Bahan Baku dalam Proses
    public function simpanbbproses()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'jumlah_beli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'tgl_beli' => [
                    'label' => 'Tanggal Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $data = [
                    'errors' => [
                        'jumlah_beli' => $validation->getError('jumlah_beli'),
                        'tgl_beli' => $validation->getError('tgl_beli'),
                    ]
                ];
                echo json_encode($data);
            } else {
                $bahanbakuproses = new BahanBakuProsesModel();
                $harga = $this->request->getVar('harga');
                $harga = (int)(filter_var($harga, FILTER_SANITIZE_NUMBER_INT));
                $jumlah_beli = $this->request->getVar('jumlah_beli');
                $simpandata = [
                    'idbelibahan' => $this->request->getVar('idbelibahan'),
                    'idproyek' => $this->request->getVar('idproyek'),
                    'id_pbb' => $this->request->getVar('id_pbb'),
                    'tgl_beli' => $this->request->getVar('tgl_beli'),
                    'harga' => $harga,
                    'jumlah_beli' => $jumlah_beli,

                ];
                $bahanbakuproses->insert($simpandata);

                // query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                // optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $bahanbakuproses->builder();
                $hasil = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $hasil,
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('kelolaproyek/bbdalamproses'));
        }
    }
    public function detailbbproses($id = '')
    {
        if ($this->request->isAJAX()) {
            $detailbbproses = new BahanBakuProsesModel();
            $builder = $detailbbproses->builder();
            $builder = $builder->select('*');
            $builder = $builder->join('proyek', 'belibahan.idproyek=proyek.idproyek')->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan')->having('belibahan.idbelibahan', $id)->having('belibahan.idproyek', $this->idproyek)->get();
            $getdata = $builder->getResultArray();
            echo json_encode($getdata);
        } else {
            return redirect()->to(base_url('kelolaproyek/bbdalamproses'));
        }
    }
    public function updatebbproses($id = false)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'namabahan' => [
                    'label' => 'Nama Bahan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'jumlah_beli' => [
                    'label' => 'Jumlah Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'tgl_beli' => [
                    'label' => 'Tanggal Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $data = [
                    'errors' => [
                        'namabahanss' => $validation->getError('namabahan'),
                        'harga' => $validation->getError('harga'),
                        'jumlah_beli' => $validation->getError('jumlah_beli'),
                        'tgl_beli' => $validation->getError('tgl_beli'),
                    ]
                ];
                echo json_encode($data);
            } else {
                $bahanbakuproses = new BahanBakuProsesModel();
                $harga = $this->request->getVar('harga');
                $harga = (int)(filter_var($harga, FILTER_SANITIZE_NUMBER_INT));
                $jumlah_beli = $this->request->getVar('jumlah_beli');
                $jumlah_beli = (int)(filter_var($jumlah_beli, FILTER_SANITIZE_NUMBER_INT));
                $simpandata = [
                    'namabahan' => $this->request->getVar('namabahan'),
                    'tgl_beli' => $this->request->getVar('tgl_beli'),
                    'ukuran' => $this->request->getVar('ukuran'),
                    'kualitas' => $this->request->getVar('kualitas'),
                    'jenis' => $this->request->getVar('jenis'),
                    'berat' => $this->request->getVar('berat'),
                    'ketebalan' => $this->request->getVar('ketebalan'),
                    'panjang' => $this->request->getVar('panjang'),
                    'harga' => $harga,
                    'jumlah_beli' => $jumlah_beli,

                ];
                $bahanbakuproses->where('idbelibahan', $id)->set($simpandata)->update();


                // query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                // optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
                $builder = $bahanbakuproses->builder();
                $hasil = $builder->db()->affectedRows();
                $baristerpengaruh = [
                    'affected' => $hasil,
                    'notifidbeli' => $this->request->getVar('idbelibahan'),
                    'notifnamabahan' => $this->request->getVar('namabahan'),
                ];
                echo json_encode($baristerpengaruh);
            }
        } else {
            return redirect()->to(base_url('kelolaproyek/bbdalamproses'));
        }
    }
    public function hapusbbproses($id = false)
    {
        if ($this->request->isAjax()) {

            $bbproses = new BahanBakuProsesModel();
            $bbproses->delete($id);
            $builder = $bbproses->builder();
            $hasil = $builder->db()->affectedRows();
            $baristerpengaruh = [
                'affected' => $hasil,
            ];
            echo json_encode($baristerpengaruh);
        } else {
            return redirect()->to(base_url('kelolaproyek/tenagakerja'));
        }
    }
    public function getdatabahanbaku($idpbb)
    {
        if ($this->request->isAJAX()) {

            $idajuan =  session()->get('idajuan');
            $union   = $this->db->table('perhitunganbahanbaku')->select('id_pbb, namabahan, ukuran, kualitas, jenis, berat, ketebalan, panjang, harga, jumlah_beli')->where('idajuan', $idajuan)->where('revisi_id', 1)->where('id_pbb', $idpbb);
            $builder = $this->db->table('perhitunganbbrevisi')->select('id_pbb, namabahan, ukuran, kualitas, jenis, berat, ketebalan, panjang, harga, jumlah_beli')->where('idajuan', $idajuan)->where('revisi_id', 3)->where('id_pbb', $idpbb);
            $data =  $builder->unionAll($union)->orderBy('idajuan', 'DESC')->get()->getResultArray();
            echo json_encode($data);
        } else {
            return redirect()->to(base_url('kelolaproyek/bbdalamproses'));
        }
    }
    public function getdetailmp($idmp)
    {
        if ($this->request->isAJAX()) {

            $belibahan = new BahanBakuProsesModel();
            $datapenyusun = $belibahan->builder()->select('belibahan.*,perhitungan_materialpenyusunrev.*')
                ->join('perhitungan_materialpenyusunrev', 'belibahan.idmaterialpenyusun=perhitungan_materialpenyusunrev.idmaterialpenyusun')
                ->where('perhitungan_materialpenyusunrev.idmaterialpenyusun', $idmp)->get()->getResultArray();
            echo json_encode($datapenyusun);
        }
    }
    public function getdetailmaterial($idmaterial)
    {
        if ($this->request->isAJAX()) {
            $materialutama = new PerhitunganMaterialModel();
            $mprevisi = new PerhitunganMPrevisi();
            $belibahan = new BahanBakuProsesModel();
            $datapenyusun = $belibahan->builder()->select('belibahan.harga_beli,belibahan.totalharga,perhitungan_materialpenyusunrev.*')
                ->join('perhitungan_materialpenyusunrev', 'belibahan.idmaterialpenyusun=perhitungan_materialpenyusunrev.idmaterialpenyusun')
                ->where('perhitungan_materialpenyusunrev.idmaterial', $idmaterial)->get()->getResultArray();
            $datamaterial = $materialutama->find($idmaterial);
            $totalmaterial = $belibahan->builder()->selectSum('totalharga')->join('perhitungan_materialpenyusunrev', 'belibahan.idmaterialpenyusun=perhitungan_materialpenyusunrev.idmaterialpenyusun')->where('idmaterial', $idmaterial)->get()->getResultArray();
            $totalmaterial = $totalmaterial[0]['totalharga'];
            // $datarevisi = $mprevisi->where('revisi_id', 3)->where('idmaterial', $idmaterial)->find();
            // $gtbr = $mprevisi->builder()->selectSum('totalmp')->where('idmaterial', $idmaterial)->where('revisi_id', 3)->get()->getResultArray();
            // $gtbr = $gtbr[0]['totalmp'];
            // dd($datapenyusun);
            $data = [
                'datamaterial' => $datamaterial,
                'datapenyusun' => $datapenyusun,
                'totalrevisi' => $totalmaterial,
                // 'datarevisi' => $datarevisi,
                // 'gtbr' => $gtbr
            ];
            // dd($datapenyusun);
            echo json_encode($data);
        }
    }
    public function getdatamp($id)
    {
        if ($this->request->isAjax()) {

            $revisimp = new PerhitunganMPrevisi();
            $data = $revisimp->find($id);
            echo json_encode($data);
        }
    }
    public function simpanbelibb()
    {
        $belibb = new BahanBakuProsesModel();
        $materialutama = new MaterialUtamaModel();
        $idbeli = $this->kodeotomatis('belibahan', 'idbeli', 'BBB001');
        $idproyek = $this->request->getVar('idproyek');
        $idmaterial = $this->request->getvar('idmaterial');
        $idmaterialpenyusun = $this->request->getVar('idmaterialpenyusun');
        $namamp = $this->request->getvar('namamp');
        $tgl_beli = $this->request->getvar('tgl_beli');
        $harga_beli = (int)filter_var($this->request->getvar('harga'), FILTER_SANITIZE_NUMBER_INT);
        $totalharga = (int)filter_var($this->request->getvar('totalharga'), FILTER_SANITIZE_NUMBER_INT);
        $belibb->insert([
            'idbeli' => $idbeli,
            'idproyek' => $idproyek,
            'idmaterialpenyusun' => $idmaterialpenyusun,
            'harga_beli' => $harga_beli,
            'tgl_beli' => $tgl_beli,
            'namamp' => $namamp,
            'totalharga' => $totalharga,

        ]);
        $gettotal1 = $belibb->builder()->selectSum('totalharga')
            ->join('perhitungan_materialpenyusunrev', 'belibahan.idmaterialpenyusun=perhitungan_materialpenyusunrev.idmaterialpenyusun')
            ->where('idmaterial', $idmaterial)->get()->getResultArray();
        if (empty($gettotal1[0]['totalharga'])) {
            $totalsemua = 0;
        } else {
            $totalsemua = (int)$gettotal1[0]['totalharga'];
        }
        $materialutama->builder()->where('idmaterial', $idmaterial)->set('hargamaterial', $totalsemua)->update();
        $datamaterial = $materialutama->builder()->select('perhitungan_material.qtymaterial,material_utama.hargamaterial')
            ->join('perhitungan_material', 'material_utama.idmaterial=perhitungan_material.idmaterial')
            ->where('material_utama.idmaterial', $idmaterial)->get()->getResultArray();
        $hargamaterial = $datamaterial[0]['hargamaterial'];
        $qtymaterial = $datamaterial[0]['qtymaterial'];
        $totalmaterial = (int)($hargamaterial) * (int)($qtymaterial);
        $materialutama->builder()->where('idmaterial', $idmaterial)->set('total_harga', $totalmaterial)->update();
        $row = $belibb->builder()->db()->affectedRows();
        if ($row >= 1) {
            session()->setFlashdata('berhasil', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('gagal', 'Gagal Disimpan');
        }
        return redirect()->to(base_url('kelolaproyek/bbmaterialpenyusun/' . $idmaterial));
    }
    public function GetTenaker($id_pbtenaker)
    {
        if ($this->request->isAJAX()) {
            $tk = new PerhitunganTenakerRevisiModel();
            $getdata = $tk->find($id_pbtenaker);
            echo json_encode($getdata);
        }
    }
    public function SewaTenaker()
    {
        $tk = new TenakerModel();
        $idsewatenaker = $this->request->getvar('idsewatenaker');
        $id_pbtenaker = $this->request->getvar('id_pbtenaker');
        $idproyek = $this->request->getvar('idproyek');
        $gaji = $this->request->getvar('gaji');
        $gaji = filter_var($gaji, FILTER_SANITIZE_NUMBER_INT);
        $tanggal = $this->request->getVar('tanggal');
        $total_gaji = $this->request->getvar('total_gaji');
        $total_gaji = filter_var($total_gaji, FILTER_SANITIZE_NUMBER_INT);


        $tk->insert([
            'id_sewatenaker' => $idsewatenaker,
            'id_pbtenaker' => $id_pbtenaker,
            'idproyek' => $idproyek,
            'gaji' => $gaji,
            'total_gaji' => $total_gaji,
            'tanggal' => $tanggal
        ]);
        $row = $tk->builder()->db()->affectedRows();
        if ($row >= 1) {

            session()->setFlashdata('berhasil', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('gagal', 'Gagal Disimpan');
        }
        return redirect()->to(base_url('kelolaproyek/tenagakerja'));
    }
    public function getbop($id = false)
    {
        if ($this->request->isAjax()) {
            $bop = new PerhitunganBOPRevisiModel();
            $getdata = $bop->where('id_pbop', $id)->find();
            echo json_encode($getdata);
        }
    }
    public function BayarBOP()
    {
        $bop = new BOPModel();
        $id_pbopr = $this->request->getVar('id_pbopr');
        $id_pbop = $this->request->getVar('id_pbop');
        $idproyek = $this->request->getvar('idproyek');
        $tanggal = $this->request->getVar('tanggal');
        $harga = $this->request->getvar('harga');
        $harga = filter_var($harga, FILTER_SANITIZE_NUMBER_INT);
        $tot_biaya = $this->request->getvar('tot_biaya');
        $tot_biaya = filter_var($tot_biaya, FILTER_SANITIZE_NUMBER_INT);
        // dd($harga);
        $bop->insert([
            'id_pbopr' => $id_pbopr,
            'id_pbop' => $id_pbop,
            'idproyek' => $idproyek,
            'tanggal' => $tanggal,
            'harga' => $harga,
            'tot_biaya' => $tot_biaya
        ]);
        $row = $bop->builder()->db()->affectedRows();
        if ($row >= 1) {

            session()->setFlashdata('berhasil', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('gagal', 'Gagal Disimpan');
        }
        return redirect()->to(base_url(base_url('kelolaproyek/kelolabiayaoperasional')));
    }
    public function getdetailmaterialpenyusun($id)
    {
        if ($this->request->isAJAX()) {
            $mprab = new PerhitunganMPrevisi();
            $mpasli = new BahanBakuProsesModel();

            $datamprab = $mprab->where('idmaterialpenyusun', $id)->find();
            $datampasli = $mpasli->builder()->select('belibahan.harga_beli,belibahan.totalharga,perhitungan_materialpenyusunrev.*')->join('perhitungan_materialpenyusunrev', 'belibahan.idmaterialpenyusun=perhitungan_materialpenyusunrev.idmaterialpenyusun')->where('belibahan.idmaterialpenyusun', $id)->get()->getResultArray();

            $data = [
                'datamprab' => $datamprab,
                'datampasli' => $datampasli,
            ];
            echo json_encode($data);
        }
    }
    public function getdetailtenaker($id)
    {
        if ($this->request->isAjax()) {
            $tkasli = new TenakerModel();
            $tkRAB = new PerhitunganTenakerRevisiModel();
            $datatkasli = $tkasli->where('id_pbtenaker', $id)->find();
            $datatkrab = $tkRAB->where('id_pbtenaker', $id)->find();

            $data = [
                'datatkasli' => $datatkasli,
                'datatkrab' => $datatkrab
            ];
            echo json_encode($data);
        }
    }
    public function getdetailbop($id)
    {
        if ($this->request->isAjax()) {
            $boprab = new PerhitunganBOPRevisiModel();
            $bopasli = new BOPModel();
            $databopasli = $bopasli->where('id_pbop', $id)->find();
            $databoprab = $boprab->where('id_pbop', $id)->find();

            $data = [
                'databopasli' => $databopasli,
                'databoprab' => $databoprab
            ];
            echo json_encode($data);
        }
    }
    public function SimpanProgress()
    {
        $progress = new ProgressProyekModel();
        $idprogress = $this->kodeotomatis('progress_proyek', 'idprogress', 'PGS001');
        $idproyek = $this->request->getVar('idproyek');
        $tanggal = $this->request->getVar('tanggal');
        $pekerjaan = $this->request->getVar('pekerjaandiselesaikan');
        $persentase = $this->request->getVar('persentase');
        $file = $this->request->getFile('uploadfile');
        $getnamerandomname = $file->getRandomName();
        $file->move('fileadmin', $getnamerandomname);
        $progress->insert([
            'idprogress' => $idprogress,
            'idproyek' => $idproyek,
            'tanggal' => $tanggal,
            'pekerjaandiselesaikan' => $pekerjaan,
            'persentase' => $persentase,
            'gambar' => $getnamerandomname
        ]);
        $affected = $progress->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('gagal', 'Gagal Disimpan');
        }
        return redirect()->to(base_url('kelolaproyek/progressproyek'));
    }
    public function hapusprogress($id)
    {
        $progress = new ProgressProyekModel();
        $progress->delete($id);
        $affected = $progress->builder()->db()->affectedRows();
        if ($affected >= 1) {
            session()->setFlashdata('berhasil', 'Berhasil Disimpan');
        } else {
            session()->setFlashdata('gagal', 'Gagal Disimpan');
        }
        return redirect()->to(base_url('kelolaproyek/progressproyek'));
    }
    public function printperhitunganbiaya()
    {
    }
}
