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
    <title>Edit Delete Pelanggan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<form action="" method="post">
    <table>
        <tr>
            <td><label>Nama Pelanggan</label></td>
            <td><input type="text" name="nama" placeholder="Nama Pelanggan"></td>
            <td><button type="submit" name="edit">Edit</button></td>
            <td><button type="submit" name="delete">Delete</button></td>
        </tr>
    </table>
</form>
<?php
include "koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["edit"])) {
    $nama = $_POST['nama'];
    $sql_check_pelanggan = "select * from pelanggan where nama = '$nama'";
    $result_pelanggan = $connect->query($sql_check_pelanggan);
    if($result_pelanggan->num_rows == 0){
        echo "<script>Swal.fire({title:'Error',text:'Nama Pelanggan tidak valid',
            icon:'error',confirmButtonText: 'OK'})</script>";
        exit();
    }else{
        $data = $result_pelanggan->fetch_assoc();
        ?>
        <form action="" method="post" id="input_baru">
        <table>
            <tr><label><?php echo $data['nama']; ?></label></tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama_baru" value="<?php echo $data['nama']; ?>" required></td>
            </tr>
            <tr>
                <td>Nomor Handphone</td>
                <td><input type="text" name="no_hp" value="<?php echo $data['nomer_hp']; ?>" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" required></td>
            </tr>
            <input type="hidden" name="id_pelanggan" value="<?php echo $data['id_pelanggan']; ?>">
        </table>
        <button type="submit" name="ubah" onclick="return confirm_save(input_baru);">Ubah</button>
        </form>
        <?php
    }
    } 
    
    elseif (isset($_POST["delete"])) {
    $nama = $_POST['nama'];
    $sql_check_pelanggan = "select * from pelanggan where nama = '$nama'";
    $result_pelanggan = $connect->query($sql_check_pelanggan);
    if($result_pelanggan->num_rows == 0){
        echo "<script>Swal.fire({title:'Error',text:'Nama Pelanggan tidak valid',
            icon:'error',confirmButtonText: 'OK'})</script>";
        exit();
    }else{
        $query_del = "delete from pelanggan where nama = '$nama'";
        if($connect->query($query_del) === true){
            echo "<script>Swal.fire({title:'Berhasil',text:'Berhasil menghapus data',
                icon:'succes',confirmButtonText: 'OK'})</script>";
        }else{
            echo "<script>Swal.fire({title:'Gagal',text:'Gagal menghapus data',
                icon:'error',confirmButtonText: 'OK'})</script>";
            exit();
        }
    }
    }

    elseif(isset($_POST['ubah'])){
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_baru = $_POST['nama_baru'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $query_edit = "update pelanggan set nama = '$nama_baru', nomer_hp = '$no_hp', alamat = '$alamat' where id_pelanggan = '$id_pelanggan'";
    if($connect->query($query_edit) === true){
        echo "<script>Swal.fire({title:'Berhasil',text:'Update data berhasil',
            icon:'succes',confirmButtonText: 'OK'})</script>";
    }else{
        echo "<script>Swal.fire({title:'Gagal',text:'Update data gagal',
            icon:'error',confirmButtonText: 'OK'})</script>";
        exit();
    }
    }
    mysqli_close($connect);
}
?>
</body>
<button type="button" onclick="window.history.back();">Kembali</button>
</html>