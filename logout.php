<?php 
ob_start();
session_start();
include 'db/config.php'; 
unset($_SESSION['type']);
header("location: ".ADMIN_URL."/index.php"); 
?>
