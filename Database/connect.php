<?php
$conn = mysqli_connect("localhost", "root", "", "pet-shop");
if(!$conn){
    die("Gagal terhubung :".mysqli_connect_error());
}
?>