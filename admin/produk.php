<?php

session_start();
require "../Database/connect.php";

$user_id = $_SESSION['user_id'];

// Akses keamanan link
if(!isset($_SESSION['role'])){
    header('location: ../index.php');
    die();
}

if(isset($_POST['add_product'])){
    $product_category = $_POST['product_category'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = '../projek_akhir/admin/img/'.$product_image;
    $product_stok = $_POST['product_stok'];

    if(empty($product_name) || empty($product_price) || empty($product_image)){
        $message[] = 'Form tidak boleh kosong!';
    }else{
        $insert = "INSERT INTO produk (kategori_id, nama, harga, foto, ketersediaan_stok) VALUES('$product_category', '$product_name', '$product_price', '$product_image', '$product_stok')";
        echo $product_category;
        echo $product_name;
        echo $product_price;
        echo $product_image;
        echo $product_stok;
        $upload = mysqli_query($conn,$insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'Produk berhasil ditambahkan!';
        }else{
            $message[] = 'Produk tidak dapat ditambahkan!';
        }
    }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
   header('location:produk.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ANIPAT Admin Produk</title>
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
                <h4>Admin</h4>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="index.php" >
                            <span class="las la-home"></span>
                            <small>Dasbor</small>
                        </a>
                    </li>
                    <li>
                       <a href="" class="active">
                            <span class="las la-user-alt"></span>
                            <small>Produk</small>
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
                <small>Dasbor / Produk</small>
            </div>

        <?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}
?>
   
<div class="container">
   <div class="admin-product-form-container">
      <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
         <h3>Tambah Produk Baru</h3>
         <input type="text" placeholder="Masukan kategori produk" name="product_category" class="box">
         <small>*Makanan = 1, Aksesoris = 2</small>
         <input type="text" placeholder="Masukan nama produk" name="product_name" class="box">
         <input type="number" placeholder="Masukan harga produk" name="product_price" class="box">
         <input type="text" placeholder="Masukan ketersediaan produk" name="product_stok" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="Tambah Produk">
      </form>
   </div>

   <?php
   $select = mysqli_query($conn, "SELECT * FROM produk");
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Gambar Produk</th>
            <th>Kategori Produk</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Stok produk</th>
            <th>Aksi</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['foto']; ?>" width="100px" alt=""></td>
            <td><?php echo $row['kategori_id']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td>Rp<?php echo $row['harga']; ?></td>
            <td><?php echo $row['ketersediaan_stok']; ?></td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> Edit </a>
               <a href="produk.php?delete=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Hapus produk?');">Hapus</a>
            </td>
         </tr>
      <?php 
            }      
      ?>
      </table>
   </div>

</div>


</body>

<script scr="../js/admin_script.js"></script>

</body>
</html>