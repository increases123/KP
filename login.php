<?php
session_start();
if(isset($_SESSION['login_user_id']))
	header('location:index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login - Pendopo Umi Faridah Alathas</title>
	<?php include './layout/headerauth.php' ?>
</head>

<body class="bg-gradient-primary">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12 col-md-9">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4">Selamat Datang, Silakan Login</h1>
									</div>
									<form action="" id="form_login" class="user">
										<div id="alertplace"></div>
										<div class="form-group">
											<input type="email" name="email" id="email" class="form-control form-control-user" placeholder="Alamat email..." required autofocus>
										</div>
										<div class="form-group">
											<input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Password" required>
										</div>
										<button type="submit" class="btn btn-primary btn-user btn-block">
											Login
										</button>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="lupa-password.php">Lupa Password?</a> atau 
										<a class="small" href="daftar.php">Daftar</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="./assets/js/custom.js"></script>
	<script>
	$('#form_login').submit(function(e){
		e.preventDefault()
		$('#form_login button[type="submit"]').attr('disabled',true).html('Memproses...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'lib/ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				console.log(resp)
				if(resp == 1){
					location.href = 'index.php';
				}else{
					showalert('Email atau Password salah','alert-danger');
					$('#form_login button[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
	</script>
</body>

</html>
