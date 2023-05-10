<?php
session_start();
require "../Database/connect.php";

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ANIPAT Admin Transaksi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>M<span>odern</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpg)"></div>
                <h4>Admin</h4>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="index.php">
                            <span class="las la-home"></span>
                            <small>Dasbor</small>
                        </a>
                    </li>
                    <li>
                       <a href="produk.php">
                            <span class="las la-user-alt"></span>
                            <small>Produk</small>
                        </a>
                    </li>                    
                    <li>
                       <a href="transaksi.php" class="active">
                            <span class="las la-clipboard-list"></span>
                            <small>Transaksi</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class="las la-search"></span>
                    </label>                    
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/3.jpg)"></div>
                        <a href="../index.php">
                            <span class="las la-power-off"></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <main>
            <div class="page-header">
                <h1>Dasbor</h1>
                <small>Dasbor / Transaksi</small>
            </div>
            <?php
            $select = mysqli_query($conn, "SELECT * FROM pembayaran");
            ?>
            <div class="product-display">
                <table class="product-display-table">
                    <thead>
                    <tr>
                        <th>Id Transaksi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Nomor Hp</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <?php while($row = mysqli_fetch_assoc($select)){ ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['nomor_hp']; ?></td>
                        <td><?php echo $row['metode_pembayaran']; ?></td>
                        <td>Rp<?php echo $row['total_pembayaran']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php 
                    }      
                ?>
                </table>
            </div>
    </div>

            <?php?>
</body>
</html>