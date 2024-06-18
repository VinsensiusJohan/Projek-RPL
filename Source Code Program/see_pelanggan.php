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
    <title>Pelanggan</title>
</head>
<body>
    <table border=1>
        <tr>
            <td>ID</td>
            <td>Nama</td>
            <td>No HP</td>
            <td>Alamat</td>
        </tr>
        <?php
        include "koneksi.php";
        $query = mysqli_query($connect,"Select * from pelanggan");
        while($data = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?php echo $data['id_pelanggan']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['nomer_hp']; ?></td>
            <td><?php echo $data['alamat']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
<button type="button" onclick="window.history.back();">Kembali</button>

</html>