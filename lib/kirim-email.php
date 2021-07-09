<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/SMTP.php';

class MyMail extends PHPMailer {
    private $_host = 'smtp.gmail.com';
    private $_user = 'saidagil1022@gmail.com';
    private $_password = 'Saidagil123';

    function __construct($exceptions=true) {
        $this->Host = $this->_host;
        $this->Username = $this->_user;
        $this->Password = $this->_password;
        $this->Port = 587;
        $this->SMTPAuth = true;
        $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->isSMTP();
        $this->isHTML(true);
        $this->SMTPDebug = SMTP::DEBUG_OFF;
        $this->From = 'saidagil1022@gmail.com';
        $this->FromName = "Pendopo Umi Faridah Alathas";
        parent::__construct($exceptions);
    }

    function aktivasi_akun($nama, $email, $token) {
        $message = file_get_contents('../assets/template-email/aktivasi-akun.html');
        $message = str_replace('%nama%', $nama, $message);
        $message = str_replace('%email%', $email, $message);
        $message = str_replace('%token%', $token, $message);

        $this->addAddress($email, $nama);
        $this->Subject = 'Aktivasi Akun';
        $this->MsgHTML($message);

        return $this->send();
    }
    function lupa_password($nama, $email, $token) {
        $message = file_get_contents('../assets/template-email/lupa-password.html');
        $message = str_replace('%nama%', $nama, $message);
        $message = str_replace('%email%', $email, $message);
        $message = str_replace('%token%', $token, $message);

        $this->addAddress($email, $nama);
        $this->Subject = 'Reset Password';
        $this->MsgHTML($message);

        return $this->send();
    }
    function permintaan_jadwal($nama, $email) {
        $message = file_get_contents('../assets/template-email/permintaan-jadwal.html');
        $message = str_replace('%nama%', $nama, $message);

        $this->addAddress($email, $nama);
        $this->Subject = 'Permintaan Jadwal';
        $this->MsgHTML($message);

        return $this->send();
    }
    function notif_jadwal_admin($nama, $email) {
        $message = file_get_contents('../assets/template-email/notif-jadwal-baru-ke-admin.html');
        $message = str_replace('%nama%', $nama, $message);
        $message = str_replace('%email%', $email, $message);
        $this->ClearAllRecipients();

        $this->addAddress('said.agil102@gmail.com', 'Admin');
        $this->Subject = 'Permintaan Jadwal Baru';
        $this->MsgHTML($message);

        return $this->send();
    }
    function terima_jadwal($nama, $email) {
        $message = file_get_contents('../assets/template-email/terima-jadwal.html');
        $message = str_replace('%nama%', $nama, $message);

        $this->addAddress($email, $nama);
        $this->Subject = 'Terima Jadwal';
        $this->MsgHTML($message);

        return $this->send();
    }
    function tolak_jadwal($nama, $email) {
        $message = file_get_contents('../assets/template-email/tolak-jadwal.html');
        $message = str_replace('%nama%', $nama, $message);

        $this->addAddress($email, $nama);
        $this->Subject = 'Tolak Jadwal';
        $this->MsgHTML($message);

        return $this->send();
    }
}
