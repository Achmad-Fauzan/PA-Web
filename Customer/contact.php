<?php
session_start();
require "../Database/connect.php";
$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
}

if(isset($_POST['kirim'])){
    $username = $_POST['username'];
    $number = $_POST['nomor'];
    $message = $_POST['msg'];
    
    $query = mysqli_query($conn,"SELECT * FROM kontak WHERE username = '$username' AND 'nomor' = '$number'") or die('query failed');

    if(mysqli_num_rows($query) > 0){
        echo "<script>
        alert('Anda telah mengirimkan pesan!');
        </script>";
    }else{
        mysqli_query ($conn, "INSERT INTO kontak (user_id, username, nomor, pesan) VALUES('$user_id', '$username', '$number', '$message')") or die('query failed');
        echo "<script>
        alert('Pesan telah dikirim, terima kasih!');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kontak - ANIPAT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0 mb-5">
        <a href="index.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>ANIPAT</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Beranda</a>
                <a href="about.php" class="nav-item nav-link">Tentang</a>
                <a href="service.php" class="nav-item nav-link">Layanan</a>
                <a href="product.php" class="nav-item nav-link">Produk</a>
                <a href="cart.php" class="nav-item nav-link">Keranjang</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Akun Pengguna</a>
                    <div class="dropdown-menu m-0">
                        <a href="../Login/logout.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link active nav-contact bg-primary text-dark px-5 ms-lg-5">KONTAK<i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Kontak</h6>
                <h1 class="display-5 text-uppercase mb-0">Kirim Pesan Pada Kami</h1>
            </div>
            <div class="row ">
                <div class="col-lg-7">
                    <form method="post">
                        <div class="row g-3">
                            <!-- <div class="col-12">
                                <input type="text" class="form-control bg-light border-0 px-4" placeholder="Nama" style="height: 55px;" name="nama" required>
                            </div> -->
                            <div class="col-12">
                                <input type="text" class="form-control bg-light border-0 px-4" placeholder="Username" style="height: 55px;" name="username" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control bg-light border-0 px-4" placeholder="Nomor Hp" style="height: 55px;" name="nomor" required>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control bg-light border-0 px-4 py-3" rows="8" placeholder="Pesan" name="msg" required></textarea>
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary py-2 px-3" style="width: 100%; height: 40px;" name="kirim" value="KIRIM"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex align-items-center mb-2">
                        <img src="img/blog-1.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Hubungi Kami</h5>
                    <p class="mb-4">Layanan perawatan untuk hewan kesayangan Anda.</p>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>Jl. Suwandi No. C2</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>anipat@gmail.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+628 5312 3456 789</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Akses Link</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#">Beranda</a>
                        <a class="text-body mb-2" href="#">Tentang Kami</a>
                        <a class="text-body mb-2" href="#">Layanan Kami</a>
                        <a class="text-body" href="#">Kontak Kami</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Sosial Media</h5>
                    <div class="d-flex">
                    <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-facebook"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i class="bi bi-linkedin"></i></a>
                        <a class="btn btn-outline-primary btn-square" href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Kritik & Saran</h5>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" placeholder="Email Anda">
                            <button class="btn btn-primary">Registrasi</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 text-center text-body">
                    <a class="text-body" href="">Terms & Conditions</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Privacy Policy</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Customer Support</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Payments</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Help</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">FAQs</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white-50 py-4">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white" href="#">Kelompok 1</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white" href="https://htmlcodex.com">HTML Codex</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>