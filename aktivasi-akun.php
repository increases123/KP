<!DOCTYPE html>
<html lang="en">

<head>
	<title>Aktivasi Akun - Pendopo Umi Faridah Alathas</title>
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
                                    <?php
                                    require_once 'lib/config.php';
                                    if (isset($_GET['token'])) {
                                        $token = $_GET['token'];
                                        $sql = "SELECT * FROM users WHERE token='$token' AND verified=0 LIMIT 1";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $user = mysqli_fetch_assoc($result);
                                            $query = "UPDATE users SET verified=1 WHERE token='$token'";
                                            if (mysqli_query($conn, $query)) {
                                                session_start();
                                                if (isset($_SESSION['login_verified'])) {
                                                unset($_SESSION['login_verified']);
                                                session_regenerate_id();
                                                $_SESSION["login_verified"] = 1;
                                                session_write_close();
                                                }
                                                echo "Sedang memverifikasi.....";
                                                header( "refresh:5;url=index.php" );
                                                exit(0);
                                            }
                                        } else {
                                            echo "Email sudah terverifikasi!";
                                            header( "refresh:5;url=index.php" );
                                            exit(0);
                                        }
                                    } else {
                                        echo "Token tidak terdaftar!";
                                    }
                                    $conn->close();
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
