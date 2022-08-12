<?php

namespace App\Controllers;

use App\Models\AjuanProyekModel;
use App\Models\PerhitunganBBRevisiModel;
use App\models\PerhitunganBBModel;
use App\Models\PerhitunganBOPModel;
use App\models\PerhitunganBOPRevisiModel;
use App\models\PerhitunganTenakerModel;
use App\models\PerhitunganTenakerRevisiModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Dashboard extends BaseController
{

    protected $user_id,
        $kirimemail,
        $nama,
        $email,
        $alamat,
        $notelp,
        $username,
        $db,
        $jumlahdataakun,
        $jumlahajuan,
        $jumlahproyek,
        $datalogin,
        $idproyek;
    public function __construct()

    {


        $this->db = \Config\Database::connect();

        //query builder untuk mendapatkan jumlah baris data di tabel akun
        $builder = $this->db->table('akun');
        $builder->selectCount('user_id');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahdataakun = $getjumlahdata[0]->user_id;
        // end query builder untuk mendapatkan jumlah baris data di tabel akun


        //query buider untuk mendapatkan jumlah baris data di table proyek
        $builder = $this->db->table('proyek');
        $builder->selectCount('idproyek');
        $jumlahdata = $builder->get();
        $jumlahdata->getRow();
        $getjumlahdata = $jumlahdata->getResultObject();
        $this->jumlahproyek = $getjumlahdata[0]->idproyek;

        //query builder untuk mendapatkan jumlah baris data di table ajuan
        $builder = $this->db->table('pengajuan_proyek');
        $builder->selectCount('idajuan');
        $builder->where('status_id', '1');
        $jumlahajuan = $builder->get();
        $jumlahajuan->getRow();
        $getjumlahajuan = $jumlahajuan->getResultObject();
        $this->jumlahajuan = $getjumlahajuan[0]->idajuan;
        //end query builder untuk mendapatkan jumlah baris data di table ajuan

        //menginput data user yang login
        $this->username = session()->get('username');
        $this->nama = session()->get('nama');
        $this->alamat = session()->get('alamat');
        $this->notelp = session()->get('notelp');
        $this->user_id = session()->get('user_id');
        $this->email = session()->get('email');
        //masukkan ke variable data login admin
        $this->datalogin = [
            'judul' => '',
            'user_id' => $this->user_id,
            'email' => $this->email,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'notelp' => $this->notelp,
            'username' => $this->username,


        ];
        //untuk mendapatkan data progress dan ajuan proyek berdasarkan user yang login
        $data = $this->datalogin['user_id'];
        $ajuanproyekmodel = new AjuanProyekModel();
        $builder = $ajuanproyekmodel->builder();
        $builder->join('akun', 'pengajuan_proyek.user_id=akun.user_id');
        $query = $builder->where('pengajuan_proyek.user_id', $data)->get();
        $ajuanklien = $query->getResultArray();

        $ajuanditerima = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '2')->find();
        $ajuanditolak = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '3')->find();
        $ajuandikerjakan = $ajuanproyekmodel->where('user_id', $data)->where('status_id', '4')->find();
        $this->datalogin += [
            'ajuanditerima' => $ajuanditerima,
            'ajuanditolak' => $ajuanditolak,
            'ajuandikerjakan' => $ajuandikerjakan,
            'ajuanklien' => $ajuanklien
        ];
        //end untuk mendapatkan data progress dan ajuan proyek berdasarkan user yang login


    }
    public function kirimemaildanfile($emailpenerima, $pesan, $path, $subject)
    {
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'adikajayaengineering22@gmail.com';                     //SMTP username
            $mail->Password   = 'ijejtxsayksqluwi';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('adikajayaengineering22@gmail.com', 'PT Adika Jaya Engineering');
            $mail->addAddress($emailpenerima);     //Add a recipient            //Name is optional

            //Attachments
            $mail->addAttachment($path);         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $pesan;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            return 1;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return $mail->ErrorInfo;
        }
    }


    public function index()
    {
        $this->datalogin += [
            'jumlahdataakun' => $this->jumlahdataakun,
            'jumlahajuan' => $this->jumlahajuan,
            'jumlahproyek' => $this->jumlahproyek
        ];
        $this->kodeotomatis('akun', 'user_id', 'usr001');
        if (session()->idlevel == 1) {

            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            };
            $_SESSION['aktif'] = 'welcome';

            $this->datalogin['judul'] = 'Dashboard Admin';
            $this->datalogin += [
                'jumlahdataakun' => $this->jumlahdataakun,
                'jumlahajuan' => $this->jumlahajuan
            ];

            return view('dashboard/admin/welcome', $this->datalogin);
        } else {
            if (isset($_SESSION['aktif'])) {
                unset($_SESSION['aktif']);
            }
            $_SESSION['aktif'] = 'home';
            $this->datalogin['judul'] = 'Dashboard Klien';
            return view('dashboard/klien/welcome', $this->datalogin);
        };
    }
    public function gettotbiaya($idajuan)
    {

        $bahanbaku = new PerhitunganBBModel();
        $tenaker     = new PerhitunganTenakerModel();
        $bop     = new PerhitunganBOPModel();
        $gettotbb = $bahanbaku->builder()->selectSum('total_harga')->where('idajuan', $idajuan)->where('revisi_id', '1')->get()->getResultArray();
        $gettottk = $tenaker->builder()->selectSum('total_gaji')->where('idajuan', $idajuan)->where('revisi_id', '1')->get()->getResultArray();
        $gettotbop = $bop->builder()->selectSum('tot_biaya')->where('idajuan', $idajuan)->where('revisi_id', '1')->get()->getResultArray();

        $bbrevisi = new PerhitunganBBRevisiModel();
        $tkrevisi = new PerhitunganTenakerRevisiModel();
        $boprevisi = new PerhitunganBOPRevisiModel();
        $getotbbrevisi = $bbrevisi->builder()->selectSum('perhitunganbbrevisi.total_harga')
            ->join('perhitunganbahanbaku', 'perhitunganbbrevisi.id_pbb=perhitunganbahanbaku.id_pbb')
            ->where('idajuan', $idajuan)->where('perhitunganbbrevisi.revisi_id', '3')->get()->getResultArray();

        $getottkrevisi = $tkrevisi->builder()->selectSum('perhitungantenakerrevisi.total_gaji')
            ->join('perhitungantenaker', 'perhitungantenakerrevisi.id_pbtenaker=perhitungantenaker.id_pbtenaker')
            ->where('idajuan', $idajuan)->where('perhitungantenakerrevisi.revisi_id', '3')->get()->getResultArray();

        $getotboprevisi = $boprevisi->builder()->selectSum('perhitunganboprevisi.tot_biaya')
            ->join('perhitunganbop', 'perhitunganboprevisi.id_pbop=perhitunganbop.id_pbop')
            ->where('idajuan', $idajuan)->where('perhitunganboprevisi.revisi_id', '3')->get()->getResultArray();

        $jumlahbiayatotal = (intval($gettotbb[0]['total_harga']) + intval($gettottk[0]['total_gaji']) + intval($gettotbop[0]['tot_biaya']));
        $jumlahbiayarevisitotal = (intval($getotbbrevisi[0]['total_harga']) + intval($getottkrevisi[0]['total_gaji']) + intval($getotboprevisi[0]['tot_biaya']));
        $totalbiaya = $jumlahbiayatotal + $jumlahbiayarevisitotal;
        return $totalbiaya;
    }
    public function GetJumlahBBRevisi($idpbb)
    {
        $perhitunganrevisimodel = new PerhitunganBBRevisiModel();
        $builder = $perhitunganrevisimodel->builder();
        $get = $builder->like('id_pbb', $idpbb)->countAllResults();
        return $get;
    }
    function tanggal_indonesia($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
}
