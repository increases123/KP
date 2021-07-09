<!DOCTYPE html>
<html lang="en">

<head>
	<title>Reset Password - Pendopo Umi Faridah Alathas</title>
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
								<h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
							</div>
                            <?php
                                $token = $_GET['token'];
                                $email = $_GET['email'];
								require_once 'lib/config.php';
                                $sql = "SELECT * FROM users WHERE token='$token' AND email='$email' LIMIT 1";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                            ?>
							<form action="" class="user" id="reset_password">
								<div id="alertplace"></div>
								<div class="text-center small mb-3" id="alertplacepwd"></div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password Baru" required autofocus>
									</div>
									<div class="col-sm-6">
										<input type="password" name="cpassword" class="form-control form-control-user" id="cpassword" placeholder="Konfirmasi Password Baru" required>
									</div>
								</div>
                                <input type="hidden" name="email" value="<?php echo $email;?>"/>
								<button type="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
							</form>
                            <?php } else {
								header('location: index.php');
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="./assets/js/custom.js"></script>
	<script>
	$('#reset_password').submit(function(e){
		e.preventDefault()
		$('#reset_password button[type="submit"]').attr('disabled',true).html('Memproses...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'lib/ajax.php?action=reset_password',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp) {
				console.log(resp)
				if(resp == 1) {
					showalert('Reset password sukses','alert-success');
					$('#reset_password button[type="submit"]').attr('disabled',true).html('Mengalihkan...');
					setTimeout(function() {
						window.location.href = 'index.php';
					}, 5000);
				} else {
					showalert('Gagal mereset password','alert-danger');
					$('#reset_password button[type="submit"]').removeAttr('disabled').html('Reset Password');
				}
			}
		})
	})
	</script>
</body>

</html>
