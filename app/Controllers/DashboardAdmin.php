<?php

namespace App\Controllers;



use App\Models\ModelLogin;
use App\Models\AjuanProyekModel;
use App\Models\PerhitunganBBModel;
use App\Models\PerhitunganBBRevisiModel;
use App\Models\PerhitunganBOPModel;
use App\Models\PerhitunganTenakerModel;
use App\Models\ProyekModel;
use App\Models\ProgressProyekModel;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


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
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
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
        $getdata = $modelajuan->where('status_id', '2')->findAll();
        $modelajuan = new AjuanProyekModel();
        $builder = $this->db->table('pengajuan_proyek');
        $builder->select('*');
        $builder->select('status_ajuan.keterangan');
        $builder->join('status_ajuan', 'pengajuan_proyek.status_id=status_ajuan.status_id');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $builder->where('idajuan', $id);
        $query = $builder->get();
        $datakirim = $query->getResultArray();
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
        $builder = $this->db->table('proyek');
        $builder->select('*');
        $builder->join('pengajuan_proyek', 'proyek.idajuan=pengajuan_proyek.idajuan');
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query = $builder->get();
        $hasil = $query->getResultArray();
        if (empty($hasil)) {
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
            'proyek' => $hasil,
            'tablekosong' => $tablekosong
        ];


        return view('dashboard/admin/dataproyek', $this->datalogin);
    }
    public function message()
    {

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $_SESSION['aktif'] = 'message';
        return view('dashboard/admin/message', $this->datalogin);
    }
    public function perhitunganbiayarevisi()
    {
        $perhitunganbb = new PerhitunganBBModel();
        $perhitungantenaker = new PerhitunganTenakerModel();
        $perhitunganbop = new PerhitunganBOPModel();
        $getidpbb = $perhitunganbb->select('id_pbb')->findAll();
        $getidpbtenaker = $perhitungantenaker->select('id_pbtenaker')->findAll();
        $getidpbop =  $perhitunganbop->select('id_pbop')->findAll();

        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $this->datalogin += [
            'getidpbb' => $getidpbb,
            'getidpbtenaker' => $getidpbtenaker,
            'getidpbop' => $getidpbop,
        ];
        $_SESSION['aktif'] = 'perhitunganbiayarevisi';
        return view('dashboard/admin/perhitunganrevisi', $this->datalogin);
    }
    public function perhitunganbiaya()
    {

        $modelajuan = new AjuanProyekModel();
        $getData = $modelajuan->where('status_id', '2')->findAll();
        if (isset($_SESSION['aktif'])) {
            unset($_SESSION['aktif']);
        };
        $this->datalogin += [
            'dataajuan' => $getData,
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
        $sudahbayar = $this->request->getVar('sudahbayar');
        $belumbayar = $this->request->getVar('belumbayar');
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

        echo json_encode($getdata);
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

                ];
                $perhitunganbbmodel->insert($simpandata);
                //query  builder untuk memberitahu bahwa ada baris data yang bertambah di database, 
                //optional jika mau dipakai, mengembalikan nilai 1 jika data bertambah 0 jika tidak bertambah
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
                $simpandata = [
                    'id_pbtenaker' => $id_pbtenaker,
                    'idajuan' => $this->request->getVar('idajuantk'),
                    'jenispekerjaan' => $this->request->getVar('jenispekerjaan'),
                    'gaji' => $gaji,
                    'hari' => $this->request->getVar('hari'),
                    'total_pekerja' => $this->request->getVar('totalpekerja'),
                    'total_gaji' => $totalgaji

                ];
                $perhitungantenakermodel->insert($simpandata);
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
                $simpandata = [
                    'id_pbop' => $id_pbop,
                    'idajuan' => $this->request->getVar('idajuanbop'),
                    'namatrans' => $this->request->getVar('namatransaksi'),
                    'tot_biaya' => $totbiaya,

                ];
                $perhitunganbopmodel->insert($simpandata);
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
    public function redirectkelola($idproyek)
    {
        session()->set('kelolaproyek', 'true');
        session()->set('idproyek', $idproyek);
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
            return redirect()->to(base_url('admin/perhitunganbiaya'));
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
}
