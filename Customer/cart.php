<!-- PHP Session -->
<?php
require "../Database/connect.php";
session_start();

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
};

if(isset($_POST['update_cart'])){
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE `keranjang` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'cart quantity updated successfully!';
}
 
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `keranjang` WHERE id = '$remove_id'") or die('query failed');
    header('location:cart.php');
}
   
 if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `keranjang` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
 } 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ANIPAT</title>
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

    <!-- Cart Start -->
    <div class="container">
        <div class="shopping-cart">
            <h1 class="heading">Keranjang Saya</h1>
            <table>
                <thead>
                    <th></th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    <?php
                    $total = 0;                
                    $carts = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE user_id = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($carts) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($carts)){
                    ?>
                    <tr>
                        <td><img src="<?php echo $fetch_cart['foto']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['nama']?></td>
                        <td><?php echo $fetch_cart['harga']?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']?>">
                                <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity'];?>">
                                <input type="submit" name="update_cart" value="Ubah" class="btn btn-primary py-2 px-3">
                            </form>
                        </td>
                        <td>
                            Rp<?php echo $sub_total = ($fetch_cart['harga'] * $fetch_cart['quantity']);?>
                        </td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['id']?>"
                        class="btn btn-primary py-2 px-3" onclick="return confirm('Hapus item?');">Hapus</a></td>
                    </tr>
                    <?php
                    $total += $sub_total;
                        }
                    }else{
                        echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">Tidak ada item yang ditambahkan</td></tr>';
                    }
                    ?>
                    <tr class="table-bottom">
                        <td colspan="4"> <b>Total Pembayaran :</b></td>
                        <td>Rp<?php echo $total; ?></td>
                        <td><a href="cart.php?delete_all" onclick="return confirm('Hapus semua item?');" class="btn btn-primary py-2 px-3 <?php echo ($total > 1)?'':'disabled'; ?>">Hapus Semua</a></td>
                    </tr>
                </tbody>
            </table>
            <div class="cart-btn">  
                <a href="#" class="btn btn-primary py-2 px-3 <?php echo ($total > 1)?'':'disabled'; ?>">Proses Pembayaran</a>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <!-- Product Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h3 class="text-primary text-uppercase">Rekomendasi lainnya</h3>
            </div>
            <div class="owl-carousel product-carousel">
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/aks-1.png" alt="">
                        <h6 class="text-uppercase">Kalung Bel</h6>
                        <h5 class="text-primary mb-0">Rp35.000,00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-2.png" alt="">
                        <h6 class="text-uppercase">Royal Canin Golden Retriever for Cat Adult 1.5kg</h6>
                        <h5 class="text-primary mb-0">Rp245.000,00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-3.png" alt="">
                        <h6 class="text-uppercase">Royal Canin Medium for Cat Adult 1.5kg</h6>
                        <h5 class="text-primary mb-0">Rp205.000,00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-4.png" alt="">
                        <h6 class="text-uppercase">Whiskas for Cat Adult 1+ 1.2kg</h6>
                        <h5 class="text-primary mb-0">Rp120.000,00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-2.png" alt="">
                        <h6 class="text-uppercase">Whiskas Tuna for Cat Adult 80gr</h6>
                        <h5 class="text-primary mb-0">Rp65.000,00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product End -->

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