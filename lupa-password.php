<?php
session_start();
if(isset($_SESSION['login_user_id']))
	header('location:index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Lupa Password - Pendopo Umi Faridah Alathas</title>
    <?php include './layout/headerauth.php'; ?>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Lupa Password?</h1>
                                        <p class="mb-4">Silakan isi email yang Anda gunakan saat mendaftar
                                            dan kami akan mengirim email untuk mereset Password!</p>
                                    </div>
                                    <form action="" id="lupa_password" class="user">
                                        <div id="alertplace"></div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control form-control-user" placeholder="Masukkan alamat email..." required autofocus>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="daftar.php">Daftar</a>
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
        </div>
    </div>
    <script>
    $('#lupa_password').submit(function(e){
        e.preventDefault()
        $('#lupa_password button[type="submit"]').attr('disabled',true).html('Memproses...');
        if($(this).find('.alert-danger').length > 0 )
            $(this).find('.alert-danger').remove();
        $.ajax({
            url:'lib/ajax.php?action=lupa_password',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp) {
                console.log(resp)
                if(resp == 1) {
                    showalert('Email Reset Password sukses terkirim','alert-success');
                    $('#lupa_password button[type="submit"]').removeAttr('disabled').html('Reset Password');
                } else {
                    showalert('Email tidak terdaftar','alert-danger');
                    $('#lupa_password button[type="submit"]').removeAttr('disabled').html('Reset Password');
                }
            }
        })
    })
    </script>
</body>

</html>
