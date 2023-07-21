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
	else {
		if (isset($_POST['act'])) {
			if ($_POST['act']=="add")  {
				// ambil data hasil submit dari form
				$kode_transaksi 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_transaksi']));
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tanggal_transaksi']));
				$exp             	= explode('-',$tanggal);
				$tanggal_transaksi	= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$kode_part       	= mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
				$kode_part			= explode("|",$kode_part)[0];	
				$qty    			= mysqli_real_escape_string($mysqli, trim($_POST['qty']));
				//$total_stok      	= mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
				
				$created_user    	= $_SESSION['id_user'];

				// perintah query untuk menyimpan data ke tabel part masuk
				$query = mysqli_query($mysqli, "INSERT INTO is_temp_in(
													kode_transaksi,
													tanggal_transaksi,
													kode_part,
													qty,
													created_user) 
												VALUES(
													'$kode_transaksi',
													'$tanggal_transaksi',
													'$kode_part',
													'$qty','
													$created_user')") or die(
												json_encode(array( 
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 29\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query) {
						echo json_encode(array(
							"result" => array('location'=>"..//..//main.php?module=form_part_masuk&form=add")));
				}  
			} 
			else if ($_POST['act'] =='save') {
				$query = mysqli_query($mysqli, "INSERT INTO is_part_trans(
													kode_transaksi,
													tanggal_transaksi,
													kode_part,
													qty,
													created_user) 
												SELECT 
													kode_transaksi,
													tanggal_transaksi,
													kode_part,
													qty,
													created_user 
												FROM is_temp_in") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 43\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query) {
					$created_user    	= $_SESSION['id_user'];
					// perintah query untuk mengubah data pada tabel part
					$query1 = mysqli_query($mysqli, "DELETE FROM is_temp_in
													WHERE created_user = '$created_user'") or die( 
													json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 54\n".mysqli_error($mysqli) ))));

					// cek query
					if ($query1) {                       
						// jika berhasil tampilkan pesan berhasil simpan data
						//header("location: ../../main.php?module=part_masuk&alert=1");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
					}
				}   
			}
			else if ($_POST['act']=='del') {
				$id = $_POST['id'];
				// perintah query untuk menghapus data pada tabel part
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_in 
												WHERE id='$id'") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 72\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
				}
			}
			else if ($_POST['act']=="mr")  {
				// ambil data hasil submit dari form
				$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tanggal_transaksi']));
				$exp             	= explode('-',$tanggal);
				$tanggal_transaksi	= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$created_user    	= $_SESSION['id_user'];
				
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_in 
												WHERE created_user='$created_user'") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 72\n".mysqli_error($mysqli) ))));


				// perintah query untuk menyimpan data ke tabel part masuk
				$query1 = mysqli_query($mysqli, "INSERT INTO is_temp_in(
													part_req_id,
													tanggal_transaksi,
													kode_part,
													qty,
													created_user) 
												SELECT
													id,
													'$tanggal_transaksi',
													kode_part,
													qty,
													$created_user
												FROM is_part_req where kode_request = '$kode_request' AND status = 0;") or die(
												json_encode(array( 
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 29\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query1) {
						echo json_encode(array(
							"result" => array('location'=>"..//..//main.php?module=form_part_masuk&form=add")));
				}  
			} 
				
		} 		
	}       
?>