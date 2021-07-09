<?php
ini_set('display_errors', 0);
$conn = mysqli_connect("localhost","root","","kpkudb") OR die("Koneksi ke server gagal: ". mysqli_connect_error());
header('Cache-Control: no-cache, no-store, must-revalidate');
$namasistem = "Pendopo Umi Faridah Alathas";

function auto_cr($year = 'auto') {
	if(intval($year) == 'auto'){ $year = date('Y'); }
	if(intval($year) == date('Y')){ return 'Copyright &copy; ' . intval($year); }
	if(intval($year) < date('Y')){ return 'Copyright &copy; ' . intval($year) . ' - ' . date('Y'); }
	if(intval($year) > date('Y')){ return 'Copyright &copy; ' . date('Y'); }
}

function showalert ($text,$tipe) {
	echo "<div class=\"alert alert-".$tipe."\" alert-dismissible fade show\" role=\"alert\">
	".$text."
	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Tutup\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
}

function base_url() {
	return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/kpku/";
}

function dash($teks) {
	return str_replace('-',' ',$teks);
}
