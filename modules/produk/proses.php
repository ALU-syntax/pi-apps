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
	else if (isset($_POST['act'])){
		if ($_POST['act'] == "insert")  {
			// ambil data hasil submit dari form
			$kode_produk 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_produk']));
			$nama_produk  = mysqli_real_escape_string($mysqli, trim($_POST['nama_produk']));
			$group  = mysqli_real_escape_string($mysqli, trim($_POST['group']));
			$qty = mysqli_real_escape_string($mysqli, trim($_POST['qty']));
			$created_user = $_SESSION['id_user'];
			$valueBtnSimpan = $_POST['btnSimpan'];
			if ($valueBtnSimpan == "Hapus") {
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_produk WHERE created_user = '$created_user'")
												or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));
				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil simpan data
					header("location: ../../main.php?module=form_produk&form=add");
				}
			} else if ($valueBtnSimpan == "Hapus Item") {
				$id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_produk WHERE id = '$id'")
												or die(json_encode(array( 
													'error' => array(
														'message' => "Error on \modules\produk\proses.php, line : 29\n".mysqli_error($mysqli) ))));
				if ($query) {
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_produk&form=add")));
				}
			} else if ($valueBtnSimpan == "Tambah") {
				$part_kode_name = mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
				$part = explode("|", $part_kode_name);
				$kode_part = $part[0];
				$nama_part = $part[1];
				$query = mysqli_query($mysqli, "INSERT INTO is_temp_produk(
					kode_produk,
					nama_produk,
					kode_part,
					nama_part,
					qty,
					`group`,
					created_user
				) 
				VALUES(
					'$kode_produk',
					'$nama_produk',
					'$kode_part',
					'$nama_part',
					'$qty',
					'$group',
					'$created_user')") or die(
				json_encode(array( 
					'error' => array(
						'message' => "Error on \modules\produk\proses.php, line : 31\n".mysqli_error($mysqli) ))));
				if ($query) {
					// jika berhasil tampilkan pesan berhasil simpan data
					header("location: ../../main.php?module=form_produk&form=add");
				}
			} else {
				// perintah query untuk menyimpan data ke tabel part masuk
				$success = false;
				
				try
				{
					mysqli_autocommit($mysqli, false);

					mysqli_query($mysqli, "INSERT INTO is_produk(
						kode_produk,
						nama_produk,
						`group`,
						created_user) 
					VALUES(
						'$kode_produk',
						'$nama_produk',
						'$group',
						'$created_user')") or throws("Error on \modules\produk\proses.php, line :84\n".mysqli_error($mysqli));

					mysqli_query($mysqli, "INSERT INTO is_produk_part(
													kode_produk,
													kode_part,
													qty
												) 
												SELECT 
													'$kode_produk' kode_produk,
													kode_part,
													qty
												FROM is_temp_produk where created_user='$created_user' ") or throws("Error on \modules\produk\proses.php, line :93\n".mysqli_error($mysqli)); 
					
					
					mysqli_query($mysqli, "DELETE FROM is_temp_produk 
													WHERE created_user = '$created_user'") or throws("Error on \modules\part-request\proses.php, line :105\n".mysqli_error($mysqli)); ;
					mysqli_commit($mysqli);
					$success = true;
				}
				catch(Exception $e) 
				{
					mysqli_rollback($mysqli);
				}
				finally{
					mysqli_autocommit($mysqli,true);
				}

				if ($success) {
					header("location: ../../main.php?module=produk&alert=1");
				} else {
					header("location: ../../main.php?module=produk&alert=4");
				}
			}  
		} 
		
		else if ($_POST['act'] =='update') {
			$valueBtnSimpan = $_POST['btnSimpan'];
			$kode_produk  = mysqli_real_escape_string($mysqli, trim($_POST['kode_produk']));
			$nama_produk  = mysqli_real_escape_string($mysqli, trim($_POST['nama_produk']));
			$group  = mysqli_real_escape_string($mysqli, trim($_POST['group']));
			$qty = mysqli_real_escape_string($mysqli, trim($_POST['qty']));
			$user = $_SESSION['id_user'];
			$valueBtnSimpan = $_POST['btnSimpan'];
			if ($valueBtnSimpan == "Hapus") {
				$query = mysqli_query($mysqli, "DELETE FROM is_produk_part WHERE kode_produk='$kode_produk'")
											or die('Ada kesalahan pada query delete : '.mysqli_error($mysqli));
				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil simpan data
					header("location: ../../main.php?module=form_produk&form=edit&kode=".$kode_produk);
				}
			} else if ($valueBtnSimpan == "Hapus Item") {
				$id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
				$query = mysqli_query($mysqli, "DELETE FROM is_produk_part WHERE id = '$id'")
												or die(json_encode(array( 
													'error' => array(
														'message' => "Error on \modules\produk\proses.php, line : 133åå\n".mysqli_error($mysqli) ))));
				if ($query) {
					echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_produk&form=edit&kode=".$kode_produk)));
				}
			} else if ($valueBtnSimpan == "Tambah") {
				$part_kode_name = mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
				$part = explode("|", $part_kode_name);
				$kode_part = $part[0];
				$nama_part = $part[1];
				$query = mysqli_query($mysqli, "INSERT INTO is_produk_part(
					kode_produk,
					kode_part,
					qty
				) 
				VALUES(
					'$kode_produk',
					'$kode_part',
					'$qty')") or die(
				json_encode(array( 
					'error' => array(
						'message' => "Error on \modules\produk\proses.php, line : 147\n".mysqli_error($mysqli) ))));
				if ($query) {
					// jika berhasil tampilkan pesan berhasil simpan data
					header("location: ../../main.php?module=form_produk&form=edit&kode=".$kode_produk);
				}
			} else {
				// perintah query untuk menyimpan data ke tabel part masuk
				$query = mysqli_query($mysqli, "UPDATE is_produk SET
					nama_produk='$nama_produk',
					`group`='$group',
					updated_user='$user'
					WHERE kode_produk='$kode_produk'") or throws("Error on \modules\produk\proses.php, line :171\n".mysqli_error($mysqli));

				if ($query) {
					header("location: ../../main.php?module=produk&alert=1");
				}
			} 
		}
		elseif (  $_POST['act']=='delete') {
			if ( isset($_POST['id'])) {
				$kode_produk = $_POST['id'];
				$success = false;
				// perintah query untuk menghapus data pada tabel produk
				try
				{
					mysqli_autocommit($mysqli, false);

					mysqli_query($mysqli, "DELETE FROM is_produk WHERE kode_produk='$kode_produk'")
						or throws("Error on \modules\produk\proses.php, line :191\n".mysqli_error($mysqli));

					mysqli_query($mysqli, "DELETE FROM is_produk_part
													WHERE kode_produk = '$kode_produk'") or throws("Error on \modules\part-request\proses.php, line :194\n".mysqli_error($mysqli)); ;
					mysqli_commit($mysqli);
					$success = true;
				}
				catch(Exception $e) 
				{
					mysqli_rollback($mysqli);
				}
				finally{
					mysqli_autocommit($mysqli,true);
				}
	
				// cek hasil query
				if ($success) {
					// jika berhasil tampilkan pesan berhasil delete data
					echo "sukses";
				} else {
					echo "Gagal hapus produk";
				}
			}
		}
	}       
?>