<?php
session_start();
require "../Database/connect.php";

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
}

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
 
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `keranjang` WHERE nama = '$product_name' AND user_id = '$user_id'") or die('query failed');
 
    if(mysqli_num_rows($check_cart_numbers) > 0){
        echo "<script>
            alert('Produk telah ditambahkan ke keranjang!');
            </script>";
    }else{
       mysqli_query($conn, "INSERT INTO `keranjang`(user_id, nama, harga, foto, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
       echo "<script>
            alert('Produk berhasil ditambahkan ke keranjang!');
            </script>";
    }
}

// Sorting
$sortby = 'nama';
$sorttype = 'asc';

if(isset($_GET['sort'])){
    $sortby = $_GET['sortby'];
    $sorttype = $_GET['sorttype'];
}

$select_products = mysqli_query($conn, "SELECT * FROM `produk` ORDER BY $sortby $sorttype") or die('query failed');


if(mysqli_num_rows($select_products) > 0){
    while($fetch_products = mysqli_fetch_assoc($select_products)){
        
    }
} else {
    echo '<p class="empty">Produk tidak ditemukan!</p>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Produk - ANIPAT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

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
                <a href="product.php" class="nav-item nav-link active">Produk</a>
                <a href="cart.php" class="nav-item nav-link">Keranjang</a>
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


    <!-- Products Start -->
    <div class="container-fluid py-2">
        <div class="container">
            <div class="products">
                <div class="border-start border-5 border-primary ps-5 mb-4" style="max-width: 100%;">
                    <h3 class="text-primary text-uppercase">Produk ANIPAT</h3>
                    <h1 class="display-5 text-uppercase mb-0">Produk Kebutuhan Hewan Anda</h1>
                </div>
                <div class="bottom-bar">
                    <!-- searching -->
                    <div class="search-container">
                        <form action="" method="post">
                        <input type="text" placeholder="Cari produk.." name="search">
                        <button type="submit" name="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="search-container mb-3">
                        <!-- Sorting -->
                        <form class="asc" action="" method="get">
                            <label for="sortby">
                                <select name="sortby" id="sortby" class="btn btn-primary py-2 px-2 align-items-center mt-2">
                                    <option value="nama" <?php if($sortby == 'nama') echo 'selected'; ?>>Nama Produk</option>
                                    <option value="harga" <?php if($sortby == 'harga') echo 'selected'; ?>>Harga Produk</option>
                                </select>
                                <select name="sorttype" id="sorttype" class="btn btn-primary py-2 px-2 align-items-center mt-2">
                                    <option value="asc" <?php if($sorttype == 'asc') echo 'selected'; ?>>Terbawah</option>
                                    <option value="desc" <?php if($sorttype == 'desc') echo 'selected'; ?>>Teratas</option>
                                </select>
                                <button type="submit" name="sort">Urutkan<i class="fa fa-sort align-items-center mt-1 ps-2"></i></button>
                            </label>
                        </form>
                    </div>
                </div>
                <div class="box-container">
                    <!-- searching -->
                    <?php
                        if(isset($_POST['submit'])){
                            $search_item = $_POST['search'];
                            $products = mysqli_query($conn, "SELECT * FROM `produk` WHERE nama LIKE '%{$search_item}%'") or die('query failed');
                            if(mysqli_num_rows($products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($products)){
                    ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="<?php echo $fetch_products['foto']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['nama']; ?></div>
                        <div class="price">Rp<?php echo $fetch_products['harga']; ?></div>
                        <div class="stock"><?php echo $fetch_products['ketersediaan_stok']; ?></div>
                        <input type="number" min="1" name="product_quantity" value="1" class="form-control bg-light border-0 px-3 py-2 align-items-center mt-3" style="width: 100%;">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nama']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['harga']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['foto']; ?>">
                        <input type="submit" value="Tambah" name="add_to_cart" class="btn btn-primary py-2 px-3 align-items-center mt-3" style="width: 100%; height: 40px;">
                    </form>
                    <?php
                                }
                            }else{
                                echo '<p class="empty">Produk tidak ditemukan!</p>';
                            }
                        }
                    ?>
                    <?php
                        // Sorting
                        if(isset($_GET['sort'])){
                        $sortby = $_GET['sortby'];
                        $sorttype = $_GET['sorttype'];

                        $query = "SELECT * FROM `produk` ORDER BY $sortby $sorttype";
                        }else{
                            $query = "SELECT * FROM `produk`";
                        }

                        $select_products = mysqli_query($conn, $query) or die('query failed');
                        if(mysqli_num_rows($select_products) > 0){
                            while($fetch_products = mysqli_fetch_assoc($select_products)){
                    ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="img/<?php echo $fetch_products['foto']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['nama']; ?></div>
                        <div class="price">Rp<?php echo $fetch_products['harga']; ?></div>
                        <div class="stock"><?php echo $fetch_products['ketersediaan_stok']; ?></div>
                        <input type="number" min="1" name="product_quantity" value="1" class="form-control bg-light border-0 px-3 py-2 align-items-center mt-3" style="width: 100%;">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['nama']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['harga']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['foto']; ?>">
                        <input type="submit" value="Tambah" name="add_to_cart" class="btn btn-primary py-2 px-3 align-items-center mt-3" style="width: 100%; height: 40px;">
                    </form>
                    <?php
                            }
                        }else{
                            echo '<p class="empty">Produk tidak ditemukan!</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
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