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
            $kode_part  = mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
            $nama_part  = mysqli_real_escape_string($mysqli, trim($_POST['nama_part']));
            $kode_suplier  = mysqli_real_escape_string($mysqli, trim($_POST['kode_suplier']));
            $group 		= mysqli_real_escape_string($mysqli, trim($_POST['group']));;//str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['harga_beli'])));
            $kategori 	= mysqli_real_escape_string($mysqli, trim($_POST['kategori']));;//str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['harga_jual'])));
            $satuan     = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
            $harga      = priceclean(mysqli_real_escape_string($mysqli, trim($_POST['harga'])));

            $created_user = $_SESSION['id_user'];

            // perintah query untuk menyimpan data ke tabel part
            $query = mysqli_query($mysqli, "INSERT INTO is_part(kode_part, kode_suplier, nama_part, `group`, kategori , satuan, harga, created_user, updated_user) 
                                            VALUES('$kode_part','$kode_suplier','$nama_part','$group','$kategori','$satuan', '$harga', '$created_user','$created_user')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    

            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=part&alert=1");
            }   
        }   
    }
    
    elseif ($_POST['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode_part'])) {
                // ambil data hasil submit dari form
                $kode_part  = mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
                $nama_part  = mysqli_real_escape_string($mysqli, trim($_POST['nama_part']));
                $kode_suplier  = mysqli_real_escape_string($mysqli, trim($_POST['kode_suplier']));
                $group 		= mysqli_real_escape_string($mysqli, trim($_POST['group']));//str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['harga_beli'])));
                $kategori 	= mysqli_real_escape_string($mysqli, trim($_POST['kategori']));//str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['harga_jual'])));
                $satuan     = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
				// $stok		= str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['stok'])));
				// $stok_level	= str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['stok_level'])));				
                $stok		= priceclean(mysqli_real_escape_string($mysqli, trim($_POST['stok'])));
				$stok_level	= priceclean(mysqli_real_escape_string($mysqli, trim($_POST['stok_level'])));	
                $harga      = priceclean(mysqli_real_escape_string($mysqli, trim($_POST['harga'])));
                $updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel part
                $query = mysqli_query($mysqli, "UPDATE is_part SET  nama_part       = '$nama_part',
                                                                    kode_suplier    = '$kode_suplier',
                                                                    `group`      	= '$group',
																	kategori		= '$kategori',
                                                                    satuan          = '$satuan',
																	stok			= '$stok',
																	stok_level		= '$stok_level',
																	harga		    = '$harga',
                                                                    updated_user    = '$updated_user'
                                                              WHERE kode_part       = '$kode_part'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));

                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=part&alert=2");
                }         
            }
        }
    }

    elseif (  $_POST['act']=='delete') {
        if ( isset($_POST['id'])) {
            $kode_part = $_POST['id'];
    
            // perintah query untuk menghapus data pada tabel part
            $query = mysqli_query($mysqli, "DELETE FROM is_part WHERE kode_part='$kode_part'")
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