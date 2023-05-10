<?php
require "../Database/connect.php";
session_start();

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
};

if(isset($_POST['order_btn'])){

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];
    $metode = $_POST['metode'];
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE user_id = '$user_id'");
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['nama'].' ('.$cart_item['quantity'].')';
            $sub_total = ($cart_item['harga'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `pembayaran` WHERE nama = '$nama' AND alamat = '$alamat' AND nomor_hp = '$nomor' AND metode_pembayaran = '$metode' AND total_produk = '$total_products' AND total_pembayaran = '$cart_total'");

    if($cart_total == 0){
        echo "<script>
            alert('Keranjang Anda kosong!');
            </script>";
    }else{
        if(mysqli_num_rows($order_query) > 0){
            echo "<script>
            alert('Pembayaran telah dilakukan!');
            </script>";
        }else{
            mysqli_query($conn, "INSERT INTO `pembayaran` (user_id, nama, alamat, nomor_hp, metode_pembayaran, total_produk, total_pembayaran, tanggal) VALUES('$user_id', '$nama', '$alamat', '$nomor', '$metode', '$total_products', '$cart_total', now())");
            echo "<script>
            alert('Pembayaran berhasil!');
            </script>";
            mysqli_query($conn, "DELETE FROM `keranjang` WHERE user_id = '$user_id'");
        }
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pembayaran - ANIPAT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
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
                <a href="cart.php" class="nav-item nav-link active">Keranjang</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Akun Pengguna</a>
                    <div class="dropdown-menu m-0">
                        <a href="../Login/logout.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">KONTAK <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <a href="cart.php"><h6 class="text-primary text-uppercase">Keranjang Saya</h6></a> 
                <h1 class="display-5 text-uppercase mb-0">Proses Pembayaran</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <form method="post">
                        <div class="row g-3">
                            <div class="col-12">
                                <span>Nama</span>
                                <input type="text" name="nama" class="form-control bg-light border-0 px-4" placeholder="Nama lengkap" style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <span>Alamat Lengkap</span>
                                <textarea name="alamat" class="form-control bg-light border-0 px-4 py-3" rows="5" placeholder="Alamat lengkap"></textarea required>
                            </div>
                            <div class="col-12">
                                <span>Nomor Handphone</span>
                                <input type="text" name="nomor" class="form-control bg-light border-0 px-4" placeholder="Nomor Handphone" style="height: 55px;" required>
                            </div>
                            <!-- <div class="col-12">
                                <span>Tanggal Pembelian</span>
                                <input type="date" name="tanggal" value="mm/dd/2023" min="2023-01-01" max="2023-12-31" class="form-control bg-light border-0 px-4" style="height: 55px;">
                            </div> -->
                            <div class="col-12">
                                <span>Metode Pembayaran</span>
                                <select name="metode" class="form-control bg-light border-0 px-4" style="height: 55px;" required>
                                <option value="cod">Cash On Delivery</option>
                                <option value="credit">Credit Card</option>
                                <option value="mbanking">M-Banking</option>
                                <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit" name="order_btn">Bayar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="bg-light mb-5 p-5">
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-start">
                                <h6 class="text-uppercase mb-1">Detail Pembayaran</h6>
                                <table>
                                    <tr>
                                        <?php  
                                        $total = 0;
                                        $select_cart = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE user_id = '$user_id'");
                                        if(mysqli_num_rows($select_cart) > 0){
                                            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                                                $total_price = ($fetch_cart['harga'] * $fetch_cart['quantity']);
                                                $total += $total_price;
                                        ?>
                                        <tr>
                                            <td><img src="img/<?php echo $fetch_cart['foto']; ?>" height="100"></td>
                                            <td><?php echo $fetch_cart['nama']?></td>
                                            <td><?php echo 'Rp'.$fetch_cart['harga']; ?></td>
                                            <td><?php echo '/'.'x'.$fetch_cart['quantity']; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        }else{
                                            echo "<script>
                                            alert('Keranjang Anda kosong!');
                                            </script>";
                                        }
                                        ?>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2"><b>Jumlah Produk :</b></td>
                                        <td><b><?php echo $total_products; ?></b></td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="2"><b>Total Pembayaran :</b></td>
                                        <td><b>Rp<?php echo $total; ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

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