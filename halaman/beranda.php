<div class="row">
	<div class="col-lg-12">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary text-capitalize"><?php echo isset($_GET['page']) ? dash($_GET['page']) : dash('beranda') ?></h6>
			</div>
			<div class="card-body">
				Selamat Datang Kembali <strong><?php echo $_SESSION['login_nama'];?></strong> !
			</div>
		</div>
	</div>
</div>
