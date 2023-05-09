<!-- PHP Session -->
<?php
session_start();
require "../Database/connect.php";
$alert = "";

if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];
    $role = $_POST['role'];
    
    $query = "SELECT * FROM user WHERE username='$username' AND pass='$password'";
    $result = mysqli_query($conn, $query);
    $cekuser = mysqli_num_rows($result);

    if($cekuser > 0){
        $alert = "Username telah digunakan!";
    }else{
        if($password != $cpassword){
            $alert = "Password tidak sama!";
        }else{
            $query = mysqli_query ($conn, "INSERT INTO `user`(nama, username, pass, cpass, roles) VALUES('$nama', '$username', '$password', '$cpassword', '$role')");
            echo "<script>
            alert('Registrasi berhasil!');
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Register - ANIPAT</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="wrapper login-3">
            <div class="container">
                <div class="col-left">
                    <div class="login-text">
                        <!-- <h2><img src="../projek_akhir/Login/img/logo.png" alt="Logo"></h2> -->
                    </div>
                </div>
                <div class="col-right">
                    <div class="login-form">
                        <h2>Register</h2>
                        <form method="post">
                            <p>
                                Nama
                                <input type="text" placeholder="Masukan nama lengkap" name="nama" required>
                            </p>
                            <p>
                                Username
                                <input type="text" placeholder="Masukan username" name="user" required>
                            </p>
                            <p>
                                Password
                                <input type="password" placeholder="Masukan password" name="pass" required>
                            </p>
                            <p>
                                Konfirmasi Password
                                <input type="password" placeholder="Masukan ulang password" name="cpass" required>
                            </p>
                            <p>
                                Role
                            <select class="select" name="role">
                                <option value="customer" name="customer">Customer</option>
                            </select>
                            </p>
                            <h6>
                                <?php echo $alert ?>
                            </h6>
                            <p>
                                <input class="btn" type="submit" name="register" value="REGISTRASI" />
                            </p>
                            <p>
                                Sudah punya akun?
                                <a href="../index.php">Login.</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>