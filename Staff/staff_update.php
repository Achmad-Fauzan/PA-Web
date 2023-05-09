<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;
   $product_stok = $_POST['product_stok'];

   if(empty($product_name) || empty($product_price) || empty($product_image) || empty($product_stok)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE produk SET nama='$product_name', harga='$product_price', 
      foto='$product_image', ketersediaan_stok='$product_stok'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         header('location:produk.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">
   <div class="admin-product-form-container centered">

      <?php
         
         $select = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
         while($row = mysqli_fetch_assoc($select)){

      ?>
      
      <form action="" method="post" enctype="multipart/form-data">
         <h3 class="title">Edit Data Produk</h3>
         <input type="text" class="box" name="product_name" value="<?php echo $row['nama']; ?>" placeholder="enter the product name">
         <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['harga']; ?>" placeholder="enter the product price">
         <input type="text" class="box" name="product_stok" value="<?php echo $row['ketersediaan_stok']; ?>" placeholder="enter the product stok">
         <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
         <input type="submit" value="Edit Produk" name="update_product" class="btn">
         <a href="produk.php" class="btn">Kembali</a>
      </form>
      <?php }; ?>
   </div>
</div>

</body>
</html>