<?php
$conn = mysqli_connect("localhost", "root", "", "petshop");
if(!$conn){
    die("Gagal terhubung :".mysqli_connect_error());
}
?>