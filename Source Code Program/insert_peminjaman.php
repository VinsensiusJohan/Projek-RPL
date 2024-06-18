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
    <title>Peminjaman</title>
</head>
<body>
<form action="" method="post">
    <table>
        <tr>
            <td><label>Nama</label></td>
            <td><input type="text" name="nama" placeholder="Nama" required></td>
        </tr>
        <tr>
            <td><label>Judul</label></td>
            <td><input type="text" name="judul" placeholder="Judul" required></td>
        </tr>
        <tr>
            <td><label>Tanggal Pinjam</label></td>
            <td><input type="date" name="tgl_pinjam" required></td>
        </tr>
        <tr>
            <td><label>Tanggal Kembali</label></td>
            <td><input type="date" name="tgl_kembali" required></td>
        </tr>
        <tr>
            <td><label>Lama Pinjam</label></td>
            <td><input type="text" name="lama_pinjam" required></td>
        </tr>
        <tr>
            <td><label>Status</label></td>
            <td><select name="status" required>
                <option value="Dipinjam">Dipinjam</option>
                <option value="Dikembalikan">Dikembalikan</option>
            </select></td>
        </tr>
    </table>
    <button type="submit">Submit</button>
</form>
<button type="button" onclick="window.history.back();">Kembali</button>
</body>
</html>

<?php 
include "koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama = $_POST['nama'];
    $judul = $_POST['judul'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $lama_pinjam = $_POST['lama_pinjam'];
    $status = $_POST['status'];

    if(!is_numeric($lama_pinjam)){
        echo "<script>Swal.fire({title:'Error',text:'Lama peminjaman harus berupa angka',
        icon:'error',confirmButtonText: 'OK'})</script>";
        exit();
    }

    $sql_check_buku = "Select * from buku where judul = '$judul'";
    $result_buku = $connect->query($sql_check_buku);
    if($result_buku->num_rows == 0){
        echo '<script>alert("Judul tidak valid"); window.history.back();</script>';
        exit();
    }else{
        $baris_buku = $result_buku->fetch_assoc();
        if($baris_buku['status'] == 'Kosong'){
            echo '<script>alert("Buku sedang kosong"); window.history.back();</script>';
            exit();
        }else{
            $id_buku = $baris_buku['id_buku'];
        }
    }
    
    $sql_check_pelanggan = "select * from pelanggan where nama = '$nama'";
    $result_pelanggan = $connect->query($sql_check_pelanggan);
    if($result_pelanggan->num_rows == 0){
        echo '<script>alert("Anggota tidak ada");  window.history.back();</script>';
        exit();
    }else{
        $baris_pelanggan = $result_pelanggan->fetch_assoc();
        $id_pelanggan = $baris_pelanggan['id_pelanggan'];
    }

    $query_peminjaman = mysqli_query($connect,"insert into peminjaman 
            values('','$id_pelanggan','$id_buku','$tgl_pinjam','$tgl_kembali','$lama_pinjam','$status')") 
            or die (mysqli_error($connect));
    
    if($query_peminjaman){
        echo '<script>alert("Input berhasil !!!"); window.history.back();</script>';
    }
    else {
        echo '<script>alert("Input gagal !!!"); window.history.back();</script>';
    }

    $query_update_buku = "update buku set status = 
                    'Kosong' where id_buku = '$id_buku'"
                    or die(mysqli_error($connect));
    $result_query_update_buku = $connect->query($query_update_buku);
    if($result_query_update_buku){
        echo '<script>alert("Update berhasil !!!"); window.history.back();</script>';
    }else {
        echo '<script>alert("Update gagal !!!"); window.history.back();</script>';
    }
}


?>