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
	//print_r($_POST);
    if ( $_POST['act']=='insert') {
        if (isset($_POST['simpan'])) {
            // ambil data hasil submit dari form
			$kode  		= mysqli_real_escape_string($mysqli, trim($_POST['kode']));
            $nama_vend  = mysqli_real_escape_string($mysqli, trim($_POST['nama_suplier']));
            $group  	= mysqli_real_escape_string($mysqli, trim($_POST['group']));
            $alamat  	= mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
            $telepon    = mysqli_real_escape_string($mysqli, trim($_POST['telepon']));
            $email      = mysqli_real_escape_string($mysqli, trim($_POST['email']));
            $no_rekening= mysqli_real_escape_string($mysqli, trim($_POST['no_rekening']));
            $pic        = mysqli_real_escape_string($mysqli, trim($_POST['pic']));
            $top        = mysqli_real_escape_string($mysqli, trim($_POST['top']));
            
            
			
            $created_user = $_SESSION['id_user'];
            // perintah query untuk menyimpan data ke tabel part
            $query = mysqli_query($mysqli, "INSERT INTO is_suplier (
											`kode`,
											`nama`,
											`alamat`,
											`group`,
											`telepon`,
											`email`,
											`no_rekening`,
											`pic`,
											`top`,
											`createdBy`)
                                            VALUES( 
											'$kode',
											'$nama_vend',
											'$alamat',
											'$group',
											'$telepon',
											'$email',
											'$no_rekening',
											'$pic',
											$top,
											'$created_user')")
                                            or die('Ada kesalahan pada query insert : '.mysqli_error($mysqli));    
            // cek query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil simpan data
                header("location: ../../main.php?module=vend&alert=1");
            }   
        }   
    }
    
    else if ($_POST['act']=='update') {
        if (isset($_POST['simpan'])) {
            if (isset($_POST['kode'])) {
                // ambil data hasil submit dari form
                $kode  = mysqli_real_escape_string($mysqli, trim($_POST['kode']));
                $nama  = mysqli_real_escape_string($mysqli, trim($_POST['nama']));
                $group 		= mysqli_real_escape_string($mysqli, trim($_POST['group']));//str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['harga_beli'])));
                $alamat 	= mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
                $telepon    = mysqli_real_escape_string($mysqli, trim($_POST['telepon']));
                $no_rekening= mysqli_real_escape_string($mysqli, trim($_POST['no_rekening']));
                $email      = mysqli_real_escape_string($mysqli, trim($_POST['email']));
                $pic        = mysqli_real_escape_string($mysqli, trim($_POST['pic']));
                $top        = mysqli_real_escape_string($mysqli, trim($_POST['top']));
                
                
				$updated_user = $_SESSION['id_user'];

                // perintah query untuk mengubah data pada tabel part
                $query = mysqli_query($mysqli, "UPDATE is_suplier SET  `nama`       = '$nama',
                                                                    `group`      	= '$group',
																	`alamat`		= '$alamat',
																	`telepon`       = '$telepon',
																	`email`         = '$email',
																	`no_rekening`   = '$no_rekening',
																	`pic`           = '$pic',
																	`top`           = $top,
																	`updatedBy`		= '$updated_user'
                                                              WHERE kode       		= '$kode'")
                                                or die('Ada kesalahan pada query update : '.mysqli_error($mysqli));
                // cek query
                if ($query) {
                    // jika berhasil tampilkan pesan berhasil update data
                    header("location: ../../main.php?module=vend&alert=2");
                }         
            }
        }
    }

    else if (  $_POST['act']=='delete') {
        if ( isset($_POST['no'])) {
            $kode = $_POST['no'];
            // perintah query untuk menghapus data pada tabel suplier
            $query = mysqli_query($mysqli, "DELETE FROM is_suplier WHERE kode='$kode'")
                                            or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));

            // cek hasil query
            if ($query) {
                // jika berhasil tampilkan pesan berhasil delete data
                echo 'sukses';
                 //header("location: ../../main.php?module=vend&alert=3");
            }
        }
    } 
}       
?>