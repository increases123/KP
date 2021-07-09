<?php
ob_start();
$action = $_GET['action'];
include 'action.php';
$crud = new Action();

if($action == 'daftar'){
	$save = $crud->daftar();
	if($save)
		echo $save;
}

if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}

if($action == 'lupa_password'){
	$lupa = $crud->lupa_password();
	if($lupa)
		echo $lupa;
}

if($action == 'reset_password'){
	$rst_passwd = $crud->reset_password();
	if($rst_passwd)
		echo $rst_passwd;
}

if($action == "kirim_jadwal"){
	$save = $crud->kirim_jadwal();
	if($save)
		echo $save;
}

if($action == "terima_app"){
	$save = $crud->terima_app();
	if($save)
		echo $save;
}

if($action == "tolak_app"){
	$save = $crud->tolak_app();
	if($save)
		echo $save;
}

if($action == "tambah_jadwal"){
	$save = $crud->tambah_jadwal();
	if($save)
		echo $save;
}

if($action == "hapus_jadwal"){
	$save = $crud->hapus_jadwal();
	if($save)
		echo $save;
}

if($action == "selesai_app"){
	$save = $crud->selesai_app();
	if($save)
		echo $save;
}
