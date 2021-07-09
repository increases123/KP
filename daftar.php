<?php
session_start();
if(isset($_SESSION['login_user_id']))
	header('location:index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Daftar - Pendopo Umi Faridah Alathas</title>
	<?php include './layout/headerauth.php'; ?>
</head>

<body class="bg-gradient-primary">
	<div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
					<div class="col-lg-7">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Daftar</h1>
							</div>
							<form action="" class="user" id="form_daftar">
								<div id="alertplace"></div>
								<div class="form-group">
									<input type="text" name="nama" class="form-control form-control-user" id="nama" placeholder="Nama Lengkap" required autofocus>
								</div>
								<div class="form-group">
									<input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Alamat Email Valid" required>
								</div>
								<div class="text-center small mb-3" id="alertplacepwd"></div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
									</div>
									<div class="col-sm-6">
										<input type="password" name="cpassword" class="form-control form-control-user" id="cpassword" placeholder="Konfirmasi Password" required>
									</div>
								</div>
								<button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
							</form>
							<hr>
							<div class="text-center">
								<a class="small" href="lupa-password.php">Lupa Password?</a>
							</div>
							<div class="text-center">
								<span class="small">Sudah punya akun? </span><a class="small" href="login.php">Silakan Login</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#form_daftar').submit(function(e){
			e.preventDefault();
			$('#form_daftar button[type="submit"]').attr('disabled',true).html('Memproses...');
			if($(this).find('.alert-danger').length > 0 ) {
				$(this).find('.alert-danger').remove();
			}
			$.ajax({
				url:'lib/ajax.php?action=daftar',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp) {
					if(resp == 1) {
						location.replace("index.php");
					} else {
						showalert('Email sudah terdaftar.','alert-danger');
						$('#form_daftar button[type="submit"]').removeAttr('disabled').html('Daftar');
					}
				}
			})
		})
	</script>
</body>

</html>
