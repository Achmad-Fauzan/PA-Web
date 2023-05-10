<?php
session_start();
require "../Database/connect.php";

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ANIPAT Staff Dasbor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>ANI<span>PAT</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpg)"></div>
                <h4>Staff</h4>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="index.php">
                            <span class="las la-cash-register"></span>
                            <small>Transaksi</small>
                        </a>
                    </li>
                    <li>
                        <a href="reservation.php" class="active">
                            <span class="las la-calendar"></span>
                            <small>Reservasi</small>
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
                <h1>Reservasi</h1>
                <small>Reservasi Layanan</small>
            </div>
            <?php
            $select = mysqli_query($conn, "SELECT * FROM reservasi");
            ?>
            <div class="product-display">
                <table class="product-display-table">
                    <thead>
                    <tr>
                        <th>Id User</th>
                        <th>Nama</th>
                        <th>Nomor Hp</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                    </tr>
                    </thead>
                    <?php while($row = mysqli_fetch_assoc($select)){ ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['nomor']; ?></td>
                        <td><?php echo $row['layanan']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['jam']; ?></td>
                    </tr>
                    <?php 
                    }      
                ?>
                </table>
            </div>
        </main>
    </div>
</div>
    <?php?>
</body>

</html>