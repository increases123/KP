<?php
session_start();
Class Action {

	private $db;
	private $mail;

	public function __construct() {
		ob_start();
		include 'config.php';
		include 'kirim-email.php';
		$this->mail = new MyMail();
		$this->db = $conn;
	}

	function __destruct() {
		$this->db->close();
		ob_end_flush();
	}

	function daftar() {
		extract($_POST);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$token = bin2hex(random_bytes(50));
		$data = "nama = '$nama' ";
		$data .= ", email = '$email' ";
		$data .= ", password = '$password' ";
		$data .= ", level = '3' ";
		$data .= ", verified = '0' ";
		$data .= ", token = '$token' ";
		$chk = $this->db->query("SELECT * FROM users where email = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$this->mail->aktivasi_akun($nama, $email, $token);
			$qry =$this->db->query("SELECT * FROM users WHERE email = '$email'");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'password' && !is_numeric($key) && $key != 'token')
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function logout() {
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header('location:../index.php');
	}

	function login() {
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where email = '".$email."' ");
		if($qry->num_rows > 0) {
			$row = $qry->fetch_array();
			if (password_verify($password, $row['password'])) {
				foreach ($row as $key => $value) {
					if($key != 'password' && !is_numeric($key) && $key != 'token')
						$_SESSION['login_'.$key] = $value;
				}
				return 1;
			} else {
				return 3;
			}
		}
	}

	function lupa_password() {
		extract($_POST);
		$token = bin2hex(random_bytes(50));
		$data = ", email = '$email' ";
		$data .= ", token = '$token' ";
		$chk = $this->db->query("SELECT * FROM users where email = '$email' ")->num_rows;
		if($chk > 0) {
			$this->db->query("UPDATE users SET token='$token' WHERE email='$email'");
			$this->mail->lupa_password('',$email, $token);
			return 1;
		}
		return 3;
	}

	function reset_password() {
		extract($_POST);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$data = "password = '$password' ";
		$data .= ", email = '$email' ";
		if($this->db->query("SELECT * FROM users where email = '$email' ")->num_rows > 0) {
			$this->db->query("UPDATE users SET password = '$password', token='' WHERE email = '$email'");
			return 1;
		} else {
			return 3;
		}
	}

	function kirim_jadwal() {
		extract($_POST);
		$nama = $_POST["nama"];
		$email = $_POST["email"];
		$poshari = explode(',', $_POST['hari_tanggal']);
		$hari = $poshari[0];
		$jam = $_POST['jam'];
		$slot_id = $this->db->query("SELECT slot_id FROM slots WHERE hari = '$hari' and jam = '$jam'")->fetch_row()[0];
		$data = "hari_tanggal = '$hari_tanggal' ";
		$data .= ", jam = '$jam' ";
		$data .= ", user_id = '$user_id' ";
		$data .= ", slot_id = '$slot_id' ";
		$data .= ", status = '0' ";
		// $save = $this->db->query("INSERT INTO bookings set ".$data);
		if($this->db->query("INSERT INTO bookings set ".$data)){
			$this->mail->permintaan_jadwal($nama, $email);
			$this->mail->notif_jadwal_admin($nama, $email);
			return 1;
		}
		return 2;
	}

	function terima_app() {
		extract($_POST);
		$user_id = $this->db->query("SELECT user_id FROM bookings WHERE booking_id = '$id'")->fetch_row()[0];
		$nama = $this->db->query("SELECT nama, email FROM users WHERE user_id = '$user_id'")->fetch_row()[0];
		$email = $this->db->query("SELECT nama, email FROM users WHERE user_id = '$user_id'")->fetch_row()[1];
		$qry = $this->db->query("UPDATE bookings set status = 1 where booking_id = ".$id);
		if($qry)
		$this->mail->terima_jadwal($nama, $email);
		return 1;
	}

	function tolak_app() {
		extract($_POST);
		$user_id = $this->db->query("SELECT user_id FROM bookings WHERE booking_id = '$id'")->fetch_row()[0];
		$nama = $this->db->query("SELECT nama, email FROM users WHERE user_id = '$user_id'")->fetch_row()[0];
		$email = $this->db->query("SELECT nama, email FROM users WHERE user_id = '$user_id'")->fetch_row()[1];
		$qry = $this->db->query("UPDATE bookings set status = 2 where booking_id = ".$id);
		if($qry)
		$this->mail->tolak_jadwal($nama, $email);
		return 1;
	}

	function tambah_jadwal(){
		extract($_POST);
		$data_slot = explode(', ', $slot_jam);
		$data = " hari = '$hari' ";
		$data .= ", nama_slot = '$data_slot[0]' ";
		$data .= ", jam = '$data_slot[1]' ";
		if(empty($slot_id)){
			$save = $this->db->query("INSERT INTO slots set ".$data);
		}else{
			$save = $this->db->query("UPDATE slots set ".$data." where slot_id = ".$slot_id);
		}
		if($save){
			return 1;
		}
	}

	function hapus_jadwal(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM slots where slot_id = ".$id);
		if($delete)
			return 1;
	}

	function selesai_app(){
		extract($_POST);
		try {
			$this->db->autocommit(FALSE);
			$this->db->query("UPDATE bookings set status = 3 where booking_id = '$id'");
			$this->db->query("INSERT INTO bookings_history (booking_id,user_id,slot_id,hari_tanggal,jam,status,dibuat) SELECT booking_id,user_id,slot_id,hari_tanggal,jam,status,dibuat FROM bookings WHERE booking_id = '$id'");
			$this->db->query("DELETE FROM bookings where booking_id = '$id'");
			$this->db->commit();
			$this->db->autocommit(TRUE);
			return 1;
		} catch (\Throwable $e) {
			$this->db->rollback();
			$this->db->autocommit(TRUE);
			throw $e;
			return 2;
		}
	}

}
