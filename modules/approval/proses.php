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
				$kode_transaksi 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	= explode('-',$tanggal);
				$tanggal_transaksi	= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$kode_part       	= mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
				$kode_part			= explode("|",$kode_part)[0];	
				$qty    			= mysqli_real_escape_string($mysqli, trim($_POST['qty']));
				//$total_stok      	= mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
				
				$created_user    	= $_SESSION['id_user'];

				// perintah query untuk menyimpan data ke tabel mutasi keluar
				$query = mysqli_query($mysqli, "INSERT INTO is_part_consump(
													kode_request,
													tanggal,
													kode_item,
													nama_item,
													qty,
													created_user) 
												VALUES(
													'$kode_transaksi',
													'$tanggal_transaksi',
													'$kode_part',
													'$nama_part',
													'$qty','
													$created_user')") or die(
												json_encode(array( 
													'error' => array(
														'message' => "Error on \modules\part-keluar\proses.php, line : 29\n".mysqli_error($mysqli) ))));

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
				$query = mysqli_query($mysqli, "DELETE FROM is_part_consump 
												WHERE id='$id'") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\approval\proses.php, line : 93\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
				}
			}
			else if ($_POST['act']=='update') {
				$id = $_POST['id'];
				$qty = $_POST['qty'];
				// perintah query untuk menghapus data pada tabel part
				$query = mysqli_query($mysqli, "UPDATE is_part_consump SET qty=$qty
												WHERE id='$id'") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\approval\proses.php, line : 111\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_approval&form=add")));
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
			else if ($_POST['act']=='approved') {
				$id = $_POST['id'];
				
				$query = mysqli_query($mysqli, "SELECT a.id, a.tanggal, a.kode_request, a.kode_item, b.satuan, b.nama_part, a.qty, a.created_user, a.created_date FROM is_part_consump a LEFT OUTER JOIN is_part b ON a.kode_item=b.kode_part WHERE a.kode_request='$id'") or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 168\n".mysqli_error($mysqli) ))));
				
				while($data = mysqli_fetch_assoc($query)){
				    //ubah baris menjadi approved
				    mysqli_query($mysqli, "UPDATE is_part_consump SET is_approved='1', approved_user='" . $_SESSION['id_user'] . "', approved_date='" . date('Y-m-d H:i:s') . "' WHERE id=" . $data['id']) or die(json_encode(array('error' => array('message' => "Error on \modules\approval\proses.php, line : 172\n".mysqli_error($mysqli) ))));
				    
				    //kurangi stok is_part
				    mysqli_query($mysqli, "UPDATE is_part SET stok=stok- " . $data['qty']  . " WHERE kode_part='" . $data['kode_item'] . "'") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));
				    
				    //masukkan ke table is_part_trans
				    mysqli_query($mysqli, "INSERT INTO is_part_trans(tanggal_transaksi, kode_transaksi, referensi, kode_request, kode_part, satuan, nama, qty, harga, created_user, created_date) VALUES('" . $data['tanggal']. "', '" . $data['kode_request'] . "', 'ISSUE', '', '" .  $data['kode_item'] . "', '" . $data['satuan'] . "', '" . $data['nama_part'] . "', -" . $data['qty'] . ", 0, '" .  $data['created_user'] . "', '" . $data['created_date'] . "')") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));
				    
				}

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_keluar&form=add")));
				}
			}
			else if ($_POST['act']=='reject') {
				$id = $_POST['id'];
				
				$query = mysqli_query($mysqli, "SELECT id, qty, kode_item FROM is_part_consump WHERE kode_request='$id'") or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 150\n".mysqli_error($mysqli) ))));
				
				while($data = mysqli_fetch_assoc($query)){
				    //ubah baris menjadi reject
				    mysqli_query($mysqli, "UPDATE is_part_consump SET is_approved='0', approved_user='" . $_SESSION['id_user'] . "' WHERE id=" . $data['id']) or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 161\n".mysqli_error($mysqli) ))));
				}

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_keluar&form=add")));
				}
			}	
		} 		
	}       
?>