<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

function priceclean($price)
{
    $price = str_replace(",", "", $price);
    return $price;
}
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
            $kode_resto  = mysqli_real_escape_string($mysqli, trim($_POST['kode_resto']));
            $nama_resto  = mysqli_real_escape_string($mysqli, trim($_POST['nama_resto']));

            $created_by = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel part
            $query = mysqli_query($mysqli, "INSERT INTO is_resto(kode_resto, nama_resto, created_by, updated_by) 
                                            VALUES('$kode_resto','$nama_resto','$created_by','$created_by')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=resto&alert=1");
            }   
        }   
    }
    
    elseif ($_POST['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_resto'])) {
                // ambil data hasil submit dari form
                $kode_resto  = mysqli_real_escape_string($mysqli, trim($_POST['kode_resto']));
                $nama_resto  = mysqli_real_escape_string($mysqli, trim($_POST['nama_resto']));

                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel part
                $query = mysqli_query($mysqli, "UPDATE is_resto SET  nama_resto     = '$nama_resto',
                                                                    updated_by    = '$updated_user'
                                                              WHERE kode_resto       = '$kode_resto'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=resto&alert=2");
                }         
            }
        }
    }

    elseif (  $_POST['act']=='delete') {
        if ( isset($_POST['id'])) {
            $kode_resto = $_POST['id'];
    
            // perintah query untuk menghapus data pada tabel part
            $query = mysqli_query($mysqli, "DELETE FROM is_resto WHERE kode_resto='$kode_resto'")
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