<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:login.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:login.php?msg=unauthorized_access");
}
include "koneksi.php";

$idbuku = $_GET["idbuku"];
if ($idbuku == 0) {
    $_SESSION["idbuku2"] = [];
} else {
    $index = array_search($idbuku, $_SESSION["idbuku2"]);
    unset($_SESSION["idbuku2"][$index]);
    array_values($_SESSION["idbuku2"]);
    $_SESSION["idbuku2"] = array_unique($_SESSION["idbuku2"]);
}
header("location:insert_peminjaman2.php");
