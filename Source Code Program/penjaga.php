<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:login.php?msg=need_login");
}
elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:login.php?msg=unauthorized_access");
}

?>

<html>
<head>
    <title>Penjaga</title>
</head>
<body>
    <button type="button" onclick="window.location.href='see_buku.php'">Lihat Buku</button>
    <button type="button" onclick="window.location.href='see_peminjaman.php'">Lihat Peminjaman</button>
    <button type="button" onclick="window.location.href='see_pelanggan.php'">Lihat Pelanggan</button>
    <button type="button" onclick="window.location.href='insert_peminjaman.php'">Buat Peminjaman</button>
    <button type="button" onclick="window.location.href='edit_peminjaman.php'">Pengembalian</button>
    <button type="button" onclick="window.location.href='insert_pelanggan.php'">Input Pelanggan</button>
    <button type="button" onclick="window.location.href='edit_delete_pelanggan.php'">Edit Pelanggan</button> 
    <button type="button" onclick="window.location.href='logout.php'">Logout</button>
</body>

</html>