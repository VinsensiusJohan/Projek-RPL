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
    <title>Edit Peminjaman</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<label>Status : Dikembalikan</label>
<table border=1>
    <tr>
        <td>ID Peminjaman</td>
        <td>ID Pelanggan</td>
        <td>ID Buku</td>
        <td>Tanggal Pinjam</td>
        <td>Tanggal Kembali</td>
        <td>Lama Pinjam</td>
        <td>Status</td>
    </tr>
    <?php
    include "koneksi.php";
    $query = mysqli_query($connect,"Select * from peminjaman where status = 'Dikembalikan'");
    while($data = mysqli_fetch_array($query)){
    ?>
    <tr>
        <td><?php echo $data['id_peminjaman']; ?></td>
        <td><?php echo $data['id_pelanggan']; ?></td>
        <td><?php echo $data['id_buku']; ?></td>
        <td><?php echo $data['tgl_pinjam']; ?></td>
        <td><?php echo $data['tgl_kembali']; ?></td>
        <td><?php echo $data['lama_pinjam']; ?></td>
        <td><?php echo $data['status']; ?></td>
    </tr>
    <?php } ?>
</table>    
<label>Status : Dipinjam</label>
<table border=1>
    <tr>
        <td>ID Peminjaman</td>
        <td>ID Pelanggan</td>
        <td>ID Buku</td>
        <td>Tanggal Pinjam</td>
        <td>Tanggal Kembali</td>
        <td>Lama Pinjam</td>
        <td>Status</td>
    </tr>
    <?php
    include "koneksi.php";
    $query = mysqli_query($connect,"Select * from peminjaman where status = 'Dipinjam'");
    while($data = mysqli_fetch_array($query)){
    ?>
    <tr>
        <td><?php echo $data['id_peminjaman']; ?></td>
        <td><?php echo $data['id_pelanggan']; ?></td>
        <td><?php echo $data['id_buku']; ?></td>
        <td><?php echo $data['tgl_pinjam']; ?></td>
        <td><?php echo $data['tgl_kembali']; ?></td>
        <td><?php echo $data['lama_pinjam']; ?></td>
        <td><?php echo $data['status']; ?></td>
    </tr>
    <?php } ?>
</table>    

<form action="" method="post">
    <label>ID Peminjaman</label>
    <input type="text" name="id_pinjam" required>
    <select name="status" required>
        <option value="Dipinjam">Dipinjam</option>
        <option value="Dikembalikan">Dikembalikan</option>
    </select>
    <button type="submit">Submit</button>
</form>


<?php 
include "koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id_pinjam'];
    $get_id = mysqli_query($connect, "select id_buku from peminjaman where id_peminjaman = '$id'");
    $id_row = $get_id->fetch_assoc();
    $id_buku = $id_row['id_buku'];

    $status_input = $_POST['status'];
        if($status_input == 'Dikembalikan'){
        $query_update_buku = "update buku set status = 'Tersedia' where id_buku = '$id_buku'"or die(mysqli_error($connect));
        $result_query_update_buku = $connect->query($query_update_buku);
        $query_update_peminjaman = mysqli_query($connect, "update peminjaman set status = 'Dikembalikan' where id_peminjaman = '$id'");
        if($result_query_update_buku){
            echo '<script>alert("Update berhasil !!!" $status_input;); window.history.back(); </script>';
        }else {
            echo '<script>alert("Update gagal !!!"); window.history.back();</script>';
        }
    }
}
?>
<button type="button" onclick="window.history.back();">Kembali</button>
</body>
</html>