<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:login.php?msg=need_login");
} elseif ($_SESSION['username'] != 'penjaga') {
    session_destroy();
    header("location:login.php?msg=unauthorized_access");
}
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Tambah Pelanggan</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #0766ad;">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Tambah Pelanggan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #0766ad;">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="penjaga.php">Halaman Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="see_pelanggan.php">Data Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="insert_peminjaman.php">Buat Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="pengembalian.php">Pengembalian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="logout.php">Keluar</a>
                        </li>
                </div>
            </div>
        </div>
    </nav>
    <br><br><br>
    <button type="button" class="ms-3" onclick="window.history.back();">Kembali</button>
    <br>
    <div class="container-sm">

        <form action="" method="post">
            <table class="table">
                <tr>
                    <td><label>Nama</label></td>
                    <td><input type="text" name="nama" placeholder="nama Pelanggan" required></td>
                </tr>
                <tr>
                    <td><label>Nomor HP</label></td>
                    <td><input type="text" name="nohp" placeholder="Nomor HP" required></td>
                </tr>
                <tr>
                    <td><label>Alamat</label></td>
                    <td><input type="text" name="alamat" placeholder="Alamat" required></td>
                </tr>

            </table>
            <button class="btn btn-primary mb-10" type="submit" onclick="if(!confirm('Simpan data pelanggan ini?')){ event.preventDefault() }">Submit</submit>
        </form>
    </div>
    <?php

    if (isset($_POST['nama']) && isset($_POST['nohp']) && isset($_POST['alamat'])) {
        $nama = $_POST['nama'];
        $noHP = $_POST['nohp'];
        $alamat = $_POST['alamat'];
        include "koneksi.php";

        $query = mysqli_query($connect, "INSERT INTO `pelanggan`( `nama`, `nomer_hp`, `alamat`) VALUES ('$nama','$noHP','$alamat')")
            or die(mysqli_error($connect));
        mysqli_close($connect);

        echo '<script> window.location.href = "see_pelanggan.php";</script>';
    }
    ?>

</body>


</html>