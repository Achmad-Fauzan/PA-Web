<?php
session_start();
unset($_SESSION['log']);
unset($_SESSION['role']);
header('location: ../index.php');
die();
?>