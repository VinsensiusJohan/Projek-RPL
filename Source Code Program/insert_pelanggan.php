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
    <title>Insert Pelanggan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<form action="" method="post">
    <table>
        <tr>
            <td><label>Name</label></td>
            <td><input type="text" name="nama" placeholder="Nama" required></td>
        </tr>
        <tr>
            <td><label>No. HP</label></td>
            <td><input type="text" name="no_hp" placeholder="Nomor Handphone" required></td>
        </tr>
        <tr>
            <td><label>Alamat</label></td>
            <td><input type="text" name="alamat" placeholder="Alamat" required></td>
        </tr>
    </table>
    <button type="submit" onclick="return confirm_save();">Submit</button>
</form>    

<?php
    include "koneksi.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $query = mysqli_query($connect,"insert into pelanggan 
                values('','$nama','$no_hp','$alamat')") 
                or die (mysqli_error($connect));

        if($query){
            echo "<script>Swal.fire({title:'Berhasil',text:'Berhasil memasukan data pelanggan',
                icon:'succes',confirmButtonText: 'OK'})</script>";
        }
        else {
            echo "<script>Swal.fire({title:'Gagal',text:'Gagal memasukan data pelanggan',
                icon:'error',confirmButtonText: 'OK'})</script>";
        }
    mysqli_close($connect);
    }
?>

<script>
function confirm_save(){
    Swal.fire({
        title:"Simpan ?",
        text:'',
        icon:'question',
        showDenyButton:true,
        confirmButtonText:'Ya',
        denyButtonText:'Tidak'
    }).then((result) =>{
        if(result.isConfirmed){
            document.forms[0].submit();
        }
        else if(result.isDenied){
            return false;
        }
    });
    return false;
}
</script>
<button type="button" onclick="window.history.back();">Kembali</button>
</body>
</html>