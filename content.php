<div id="content">
	<?php include 'layout/topbar.php'; ?>
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center">
			<div id="alertplace"></div>
			<?php if ($_SESSION['login_verified'] != 1): ?>
			<div class="alert alert-warning alert-dismissible fade show center-block" role="alert">
				<p>Silakan verifikasi alamat email Anda! Klik tombol "Verifikasi Akun" yang telah kami kirim ke <strong><?php echo $_SESSION['login_email']; ?></strong>.<br />Anda baru bisa membuat jadwal konsultasi setelah email terverifikasi. Terimakasih.</p>
				<button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php endif;?>
		</div>
		<?php $page = isset($_GET['page']) ? $_GET['page'] :'beranda'; ?>
		<?php include './halaman/' . $page . '.php'; ?>
	</div>
</div>
<style>
.alert {
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  text-align: center;
  top: 1em;
  width: 80%;
  z-index: 1;
}
</style>