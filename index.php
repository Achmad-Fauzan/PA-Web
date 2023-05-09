<!-- PHP Session -->
<?php
session_start();
require "../projek_akhir/Database/connect.php";
$alert = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM user WHERE username='$username' AND pass='$password' AND roles='$role'";
    $result = mysqli_query($conn, $query);
    $cekuser = mysqli_num_rows($result);

    if($cekuser > 0){
        $ambildatarole = mysqli_fetch_assoc($result);
        $username = $ambildatarole['username'];

        if($role=='customer'){
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'customer';
            $_SESSION['user_id'] = 'user_id';
            echo "<script>
            alert('Berhasil login!');
            </script>";
            header('location: ../projek_akhir/Customer/index.php');
        }else if($username=='admin' && $password=='admin'){
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'admin';
            $_SESSION['user_id'] = 'user_id';
            echo "<script>
            alert('Berhasil login!');
            </script>";
            header('location: ../projek_akhir/Admin/index.php');
        }else if($username=='staff' && $password=='staff'){
            $_SESSION['log'] ='Logged';
            $_SESSION['role'] = 'staff';
            $_SESSION['user_id'] = 'user_id';
            echo "<script>
            alert('Berhasil login!');
            </script>";
            header('location: ../projek_akhir/Staff/index.php');
        }
    }else{
        $alert = "Username/Password/Role tidak sesuai!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login ANIPAT</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Stylesheet -->
        <link href="../projek_akhir/Login/css/style.css" rel="stylesheet">
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
                        <h2>Login</h2>
                        <form method="post">
                            <p>
                                Username
                                <input type="text" placeholder="Masukan username" name="username" required>
                            </p>
                            <p>
                                Password
                                <input type="password" placeholder="Masukan password" name="password" required>
                            </p>
                            <p>
                                Role
                            <select class="select" name="role">
                                <option value="customer" name="customer">Customer</option>
                                <option value="admin" name="admin">Admin</option>
                                <option value="staff" name="staff">Staff</option>
                            </select>
                            </p>
                            <h6>
                                <?php echo $alert ?>
                            </h6>
                            <p>
                                <input class="btn" type="submit" name="login" value="MASUK" />
                            </p>
                            <p>
                                Belum punya akun?
                                <a href="../projek_akhir/Login/register.php">Buat akun.</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
