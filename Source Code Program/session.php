<?php
session_start();
$username = $_GET["username"];
if(empty($_SESSION["username"])){
    header("location:login.php?msg=need_login");
}
elseif($username == 'penjaga'){
    header("location:penjaga.php"); 
}elseif ($username == 'admin') {
    header("location:pemilik.php"); 
}
