<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
else if ( array_key_exists('act', $_POST) && isset($_POST['act']) ){
    if ( $_POST['act']=='insert') {
        if (isset($_POST['simpan'])) {
            // ambil data hasil submit dari form
            $no1  = mysqli_real_escape_string($mysqli, trim($_POST['no']));
            $resto  = mysqli_real_escape_string($mysqli, trim($_POST['resto']));
            $tanggal_input  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
			$exp            = explode('-',$tanggal_input);
			$tanggal	    = $exp[2]."-".$exp[1]."-".$exp[0];
			$value			= mysqli_real_escape_string($mysqli, trim($_POST['value']));

            $created_user = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel part
            $query = mysqli_query($mysqli, "INSERT INTO is_sales(no, resto,tanggal, value) 
                                            VALUES('$no1','$resto','$tanggal','$value')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=sales&alert=1");
            }   
        }   
    }
    
    elseif (  $_POST['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['no'])) {
            // ambil data hasil submit dari form
            $no             = mysqli_real_escape_string($mysqli, trim($_POST['no']));
            $resto			= mysqli_real_escape_string($mysqli, trim($_POST['resto']));
            $tanggal_input  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
			$exp            = explode('-',$tanggal_input);
			$tanggal	    = $exp[2]."-".$exp[1]."-".$exp[0];
			$value			= mysqli_real_escape_string($mysqli, trim($_POST['value']));

            $updated_user = $_SESSION['id_user'];

            // perintah query untuk mengubah data pada tabel part
            $query = mysqli_query($mysqli, "UPDATE is_sales SET  resto       = '$resto',                                                                  
																 tanggal	 = '$tanggal',
                                                                 value       = '$value'															                                                                
                                                                 WHERE no    = '$no'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=sales&alert=2");
                }         
            }
        }
    }

    elseif (  $_POST['act']=='delete') {
        if ( isset($_POST['no'])) {
            $no = $_POST['no'];
    
            // perintah query untuk menghapus data pada tabel part
            $query = mysqli_query($mysqli, "DELETE FROM is_sales WHERE no='$no'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                 echo "sukses";
            }
        }
    }       
}       
?>