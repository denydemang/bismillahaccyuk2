<?php



namespace App\Controllers;

use App\Models\ModelLogin;
use App\Models\TokensModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class LupaPassword extends BaseController
{

    public function kirimemailgantipw($emailpenerima, $token)
    {
        $link = 'http://localhost:8080/lupapassword/formgantipw/' . $token;
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
            // $mail->addAttachment($path);         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Permintaan Pergantian Password ';
            $mail->Body    = '<h1>Dear Klien,</h1>
                            <h2>Kami Mendapat Permintaan Untuk Pergantian Kata Sandi , Reset Kata Sandi Anda Melalui Link Berikut</h2> <a href="' . $link . '"><button style="background-color:purple">Klik Disini</button></a>';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            session()->setFlashdata('pesanemail', 'Email Pergantian Password Berhasil Dikirim Silakan Cek Kotak Masuk Atau Spam Email');
            return redirect()->to(base_url('lupapassword'));
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            session()->setFlashdata('pesanemail',  $mail->ErrorInfo);
            return redirect()->to(base_url('lupapassword'));
        }
    }
    public function index()
    {

        return view('lupapassword/kirimemail');
    }

    public function getuserinfo($email)
    {
        $user = new ModelLogin();
        $data = $user->where('email', $email)->first();
        return $data;
    }
    public function insertToken($userid = '')
    {
        $acak = substr(sha1(rand()), 0, 30);
        $token = $acak . '_' . $userid;
        $tokenmodel = new TokensModel();
        $tokenmodel->insert([
            'id' => '',
            'token' => $token,
            'user_id' => $userid
        ]);
    }
    public function kirimpassword()
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getVar('emailpemulihan');
            $getdatauser = $this->getuserinfo($email);
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'emailpemulihan' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ]
            ]);
            if (!$valid) {
                $data = [
                    'errorrequired' => $validation->getError('emailpemulihan')
                ];
                echo json_encode($data);
            } elseif (empty($getdatauser)) {
                $data = [
                    'emptyemail' => 'Email Tidak Terdaftar'
                ];
                echo json_encode($data);
            } else {
                $this->insertToken($getdatauser['user_id']);
                $tokensmodel = new TokensModel();
                $token = $tokensmodel->builder()->select('token')
                    ->where('user_id', $getdatauser['user_id'])->orderBy('id', 'desc')->limit(1)
                    ->get()->getResultArray();
                $data = [
                    'email' => $email,
                    'token' => $token[0]['token'],

                ];
                echo json_encode($data);
            }
        } else {
            return redirect()->to(base_url('lupapassword'));
        }
    }
    public function formgantipw($tokens = '')
    {
        $modeltokens = new TokensModel();
        $data = $modeltokens->where('token', $tokens)->find();
        if (empty($data)) {
            echo 'Anda Memasuki Wilayah Terlarang Silakan Kembali Ketempat Semula';
        } else {
            $pecah = explode('_', $tokens);
            $user_id = $pecah[1];
            $data = [
                'user_id' => $user_id,
            ];
            return view('lupapassword/gantipassword', $data);
        }
    }
    public function updatepassword()
    {
        $user = new ModelLogin();
        $tokens = new TokensModel();

        $passwordbaru = $this->request->getVar('passwordbaru');
        $Password = password_hash($passwordbaru, PASSWORD_BCRYPT);
        $user_id = $this->request->getVar('user_id');
        $user->builder()->set('password', $Password)->where('user_id', $user_id)->update();
        $builder = $user->builder();
        $getaffectedrow = $builder->db()->affectedRows();

        $tokens->builder()->where('user_id', $user_id)->delete();

        if ($getaffectedrow == 1) {
            session()->setFlashdata('pesanupdatepw', 'Sandi Berhasil Diupdate! Loginlah Dengan Sandi Terbaru');
        } else {
            session()->setFlashdata('pesanupdatepw', 'Sandi Gagal Diupdate!');
        }
        return redirect()->to(base_url('login'));
    }
}
