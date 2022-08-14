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
    function bbdalamproses()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'bbdalamproses';
        return view('dashboard/kelolaproyek/bbdalamproses', $this->datalogin);
    }
    function tenagakerja()

    {


        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'tenagakerja';

        return view('dashboard/kelolaproyek/tenagakerja', $this->datalogin);
    }
    function progressproyek()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
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
        $_SESSION['aktif'] = 'pembayaranproyek';
        return view('dashboard/kelolaproyek/pembayaranproyek', $this->datalogin);
    }
    function penggunaanmesin()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'penggunaanmesin';
        return view('dashboard/kelolaproyek/penggunaanmesin', $this->datalogin);
    }
    function laporanhpp()

    {
        if (session()->get('kelolaproyek') != 'true') {
            return redirect()->to(base_url('admin'));
        }
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        }
        $_SESSION['aktif'] = 'laporanhpp';
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
                        'namabahan' => $validation->getError('namabahan'),
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
                    'idbelibahan' => $this->request->getVar('idbelibahan'),
                    'idproyek' => $this->request->getVar('idproyek'),
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
}
