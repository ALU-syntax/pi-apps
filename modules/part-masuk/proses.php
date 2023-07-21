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
		if ($_POST['act'] == "add")  {
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
												'$qty',
												'$created_user')") or die(
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
		    $new_name = '';
			    
		    if($_FILES['bukti']['name']!=''){
		        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
		        
		        $new_name = uniqid() . '.' . $ext;
		        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
		    }
		    
		    
			$created_user    	= $_SESSION['id_user'];
			$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
			$kode_transaksi 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_transaksi']));
			//$no_po 				= mysqli_real_escape_string($mysqli, trim($_POST['no_po']));
			$no_sj 				= mysqli_real_escape_string($mysqli, trim($_POST['no_sj']));
			
			try{
				/*
				$query_id = mysqli_query($mysqli, "SELECT cast (RIGHT(kode_transaksi,7),int) as kode FROM is_invoice where tipe = 'Purch' year(creadedon) = year(now())
											ORDER BY kode_transaksi DESC LIMIT 1")
											or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

				$count = mysqli_num_rows($query_id);
				
				if($count > 0)
				{
					$data = mysqli_fetch_assoc($query_id);
					$kode 		= $data['kode'] +1;
					$tahun      = date("Y");
					$buat_id    = str_pad($kode, 7, "0", STR_PAD_LEFT);
					$nomor 		= "-$tahun-$buat_id";
					
				}
				else
				{
					$kode 		= 1;
					$tahun      = date("Y");
					$buat_id    = str_pad($kode, 7, "0", STR_PAD_LEFT);
					$nomor 		= "TR-$tahun-$buat_id";
				}
				*/
				
				mysqli_autocommit($mysqli, false);
				mysqli_query($mysqli, "INSERT INTO is_part_trans(
											no_sj,
											referensi,
											kode_request,
											kode_transaksi,
											tanggal_transaksi,
											kode_part,
											satuan,
											nama,
											qty,
											harga,
											kode_suplier,
											created_user,
											bukti) 
										SELECT 
											'$no_sj',
											'RECEIPT',
											'$kode_request',
											'$kode_transaksi',
											tanggal_transaksi,
											kode_part,
											satuan,
											nama,
											qty,
											harga,
											kode_suplier,
											'$created_user',
											'$new_name'
										FROM is_temp_in WHERE created_user='" . $created_user . "'") or throws("Error on \modules\part-masuk\proses.php, line :58\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line : 114\n".mysqli_error($mysqli) ))));*/
													
				mysqli_query($mysqli, "INSERT INTO is_invoice(
											tanggal,
											kode_suplier,
											suplier,
											nomor,
											referensi,
											tipe,
											amount,
											lunas,
											lampiran,
											createdby) 
										SELECT 
											tanggal_transaksi,
											(select a.kode_suplier from is_part_req a where a.kode_request = kode_request limit 1) as kode,
											(select a.suplier from is_part_req a where a.kode_request = kode_request limit 1)as suplier,
											'$kode_transaksi' ,
											'$no_sj',
											'Purch',
											qty * harga,
											if(tipe = 'CASH',1,0),
											'' as lamp,
											'$created_user' 
										FROM is_temp_in WHERE created_user='" . $created_user . "'") or throws("Error on \modules\part-masuk\proses.php, line :58\n".mysqli_error($mysqli)); 
											
				mysqli_query($mysqli, "UPDATE is_part_req
										INNER JOIN is_temp_in
										ON 
											is_part_req.id = is_temp_in.part_req_id
										SET
											is_part_req.status = IF(is_part_req.remain_receipt - is_temp_in.qty = 0, 2, 1),
											is_part_req.remain_receipt = is_part_req.remain_receipt - is_temp_in.qty WHERE is_temp_in.created_user='" . $created_user . "';") or throws("Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
											'error' => array(
												'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));
												*/
				mysqli_query($mysqli, "DELETE FROM is_temp_in
										WHERE created_user = '$created_user'") or throws("Error on \modules\part-masuk\proses.php, line :91\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
											'error' => array(
												'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));
											*/
				mysqli_commit($mysqli);
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
			}
			catch(Exception $e) {
				mysqli_rollback($mysqli);
				echo json_encode(array(
					'error' => array(
						'message' => $e->getMessage().mysqli_error($mysqli) )));
			}
			finally{mysqli_autocommit($mysqli,true);}
			/*
			// cek query
			if ($query) {
				mysqli_autocommit($mysqli,true);
				
				$created_user    	= $_SESSION['id_user'];
				// perintah query untuk mengubah data pada tabel part
				$query1 = mysqli_query($mysqli, "UPDATE is_part_req
												INNER JOIN is_temp_in
												ON 
													is_part_req.id = is_temp_in.part_req_id
												SET
													is_part_req.status = IF(is_part_req.remain_receipt - is_temp_in.qty = 0, 3, 1),
													is_part_req.remain_receipt = is_part_req.remain_receipt - is_temp_in.qty,
													is_part_req.remain_issue = is_part_req.remain_issue + is_temp_in.qty;") or die( 
												json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));

				
				
				$query1 = mysqli_query($mysqli, "DELETE FROM is_temp_in
												WHERE created_user = '$created_user'") or die( 
												json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query1) {                       
					// jika berhasil tampilkan pesan berhasil simpan data
					//header("location: ../../main.php?module=part_masuk&alert=1");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
				}
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
			} */  
		}
		else if ($_POST['act'] =='update_all') {
		    $new_name = '';
			    
		    if($_FILES['bukti']['name']!=''){
		        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
		        
		        $new_name = uniqid() . '.' . $ext;
		        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
		    }
		    
			$no_sj 				= mysqli_real_escape_string($mysqli, trim($_POST['no_sj']));
			$kode_transaksi 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_transaksi']));
			
			if($new_name=='')
			    mysqli_query($mysqli, "UPDATE is_part_trans SET no_sj='" . $no_sj . "' 
										WHERE kode_transaksi = '" . $kode_transaksi . "'") or throws("Error on \modules\part-masuk\proses.php, line :234\n".mysqli_error($mysqli));
			else
		        mysqli_query($mysqli, "UPDATE is_part_trans SET no_sj='" . $no_sj . "', bukti='" . $new_name . "' WHERE kode_transaksi = '" . $kode_transaksi . "'") or throws("Error on \modules\part-masuk\proses.php, line :237\n".mysqli_error($mysqli));
		
			echo json_encode(array("result" => array('location'=>"main.php?module=part_masuk&alert=1")));
			
			
		}
		
		
		else if ($_POST['act'] == 'save_issue') {
			$created_user    	= $_SESSION['id_user'];
			$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
			$kode_transaksi 	= mysqli_real_escape_string($mysqli, trim($_POST['kode_transaksi']));
			$keterangan 		= mysqli_real_escape_string($mysqli, trim($_POST['keterangan']));
			try{
				mysqli_autocommit($mysqli, false);
				mysqli_query($mysqli, "INSERT INTO is_part_trans(
											referensi,
											kode_request,
											kode_transaksi,
											tanggal_transaksi,
											kode_part,
											qty,
											keterangan,
											created_user) 
										SELECT 
											'ISSUE',
											'$kode_request',
											'$kode_transaksi',
											tanggal_transaksi,
											kode_part,
											-qty,
											'$keterangan',
											'$created_user' 
										FROM is_temp_out") or throws("Error on \modules\part-masuk\proses.php, line :153\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line : 52\n".mysqli_error($mysqli) ))));
											*/
				mysqli_query($mysqli, "UPDATE is_part_req
										INNER JOIN is_temp_out
										ON 
											is_part_req.id = is_temp_out.part_req_id
										SET
											is_part_req.status = IF(is_part_req.remain_issue - is_temp_out.qty = 0, 4, 3),
											/*is_part_req.remain_receipt = is_part_req.remain_receipt - is_temp_out.qty,*/
											is_part_req.remain_issue = is_part_req.remain_issue - is_temp_out.qty;") or throws("Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));
											*/
				mysqli_query($mysqli, "DELETE FROM is_temp_out
										WHERE created_user = '$created_user'") or throws("Error on \modules\part-masuk\proses.php, line :186\n".mysqli_error($mysqli)); /*
											die( json_encode(array(
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));
											*/
				mysqli_commit($mysqli);
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
			}
			catch(Exception $e) {
				mysqli_rollback($mysqli);
				echo json_encode(array(
					'error' => array(
						'message' => $e->getMessage().mysqli_error($mysqli) )));
			}
			finally{mysqli_autocommit($mysqli,true);}
			/*
			// cek query
			if ($query) {
				mysqli_autocommit($mysqli,true);
				
				$created_user    	= $_SESSION['id_user'];
				// perintah query untuk mengubah data pada tabel part
				$query1 = mysqli_query($mysqli, "UPDATE is_part_req
												INNER JOIN is_temp_in
												ON 
													is_part_req.id = is_temp_in.part_req_id
												SET
													is_part_req.status = IF(is_part_req.remain_receipt - is_temp_in.qty = 0, 3, 1),
													is_part_req.remain_receipt = is_part_req.remain_receipt - is_temp_in.qty,
													is_part_req.remain_issue = is_part_req.remain_issue + is_temp_in.qty;") or die( 
												json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));

				
				
				$query1 = mysqli_query($mysqli, "DELETE FROM is_temp_in
												WHERE created_user = '$created_user'") or die( 
												json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line :73\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query1) {                       
					// jika berhasil tampilkan pesan berhasil simpan data
					//header("location: ../../main.php?module=part_masuk&alert=1");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
				}
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_masuk&alert=1")));
			} */  
		}
		
		else if ($_POST['act'] == 'update') {
			$id = $_POST['id'];
			$tbl = $_POST['table'];
			$field = $_POST['field'];
			$value = $_POST['value'];
			// perintah query untuk menghapus data pada tabel part
			$query = mysqli_query($mysqli, "Update $tbl 
											SET $field = '$value'
											WHERE id='$id'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 150\n".mysqli_error($mysqli) ))));

			// cek hasil query
			if ($query) {
				// jika berhasil tampilkan pesan berhasil delete data
				//header("location: ../../main.php?module=form_part_masuk&form=add");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
			}
		}
		
		else if ($_POST['act'] == 'del') {
			$id = $_POST['id'];
			// perintah query untuk menghapus data pada tabel part
			$query = mysqli_query($mysqli, "DELETE FROM is_temp_in 
											WHERE id='$id'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 150\n".mysqli_error($mysqli) ))));

			// cek hasil query
			if ($query) {
				// jika berhasil tampilkan pesan berhasil delete data
				//header("location: ../../main.php?module=form_part_masuk&form=add");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
			}
		}
		else if ($_POST['act'] == 'del_update') {
			$id = $_POST['id'];
		
			// perintah query untuk menghapus data pada tabel part
			$query = mysqli_query($mysqli, "DELETE FROM is_part_trans 
											WHERE id='$id'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 358\n".mysqli_error($mysqli) ))));

			// cek hasil query
			if ($query) {
				// jika berhasil tampilkan pesan berhasil delete data
				//header("location: ../../main.php?module=form_part_masuk&form=add");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
			}
		}
		
		else if ($_POST['act']=='del_all') {
			$id 			= $_POST['id'];
			
			$query = mysqli_query($mysqli, "DELETE FROM is_part_trans
											WHERE kode_transaksi='$id' ") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 358\n".mysqli_error($mysqli) ))));

			// cek hasil query
			if ($query) {
				// jika berhasil tampilkan pesan berhasil delete data
				//header("location: ../../main.php?module=form_part_masuk&form=add");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_request")));
			}
		}
		
		else if ($_POST['act'] == 'del_issue') {
			$id = $_POST['id'];
			// perintah query untuk menghapus data pada tabel part
			$query = mysqli_query($mysqli, "DELETE FROM is_temp_out 
											WHERE id='$id'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 168\n".mysqli_error($mysqli) ))));

			// cek hasil query
			if ($query) {
				// jika berhasil tampilkan pesan berhasil delete data
				//header("location: ../../main.php?module=form_part_masuk&form=add");
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=form_part_masuk_issue&form=add")));
			}
		}
		
		else if ($_POST['act'] == "select")  {
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
														'message' => "Error on \modules\part-masuk\proses.php, line : 178\n".mysqli_error($mysqli) ))));


			// perintah query untuk menyimpan data ke tabel part masuk
			$query1 = mysqli_query($mysqli, "INSERT INTO is_temp_in(
												part_req_id,
												tanggal_transaksi,
												kode_part,
												nama,
												tipe,
												qty,
												satuan,
												harga,
												kode_suplier,
												created_user) 
											SELECT
												id,
												'$tanggal_transaksi',
												kode_part,
												nama_item,
												tipe,
												remain_receipt,
												satuan,
												harga,
												kode_suplier,
												$created_user
											FROM is_part_req where kode_request = '$kode_request' AND remain_receipt > 0;") or die(
											json_encode(array( 
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line : 182\n".mysqli_error($mysqli) ))));

			// cek query
			if ($query1) {
					echo json_encode(array(
						"result" => array('location'=>"..//..//main.php?module=form_part_masuk&form=add")));
			}  
		} 
		
		else if ($_POST['act'] == "select_po")  {
		    $kode_suplier = $_POST['kode_suplier'];
		    
		    $query = mysqli_query($mysqli, "SELECT DISTINCT(req.kode_request) FROM is_part_req req LEFT OUTER JOIN is_part_trans trans ON req.kode_request=trans.kode_request WHERE trans.kode_request IS NULL AND req.kode_suplier='" . $kode_suplier . "'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 426\n".mysqli_error($mysqli) ))));
		    echo '<option value=""></option>';
		    while ($data = mysqli_fetch_assoc($query)) { 
		        echo '<option value="' . $data['kode_request']  . '">' . $data['kode_request'] . '</option>';
		    }
		} 
			
		else if ($_POST['act'] == "mr_issue")  {
			// ambil data hasil submit dari form
			$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
			$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tanggal_transaksi']));
			$exp             	= explode('-',$tanggal);
			$tanggal_transaksi	= $exp[2]."-".$exp[1]."-".$exp[0];
			
			$created_user    	= $_SESSION['id_user'];
			
			$query = mysqli_query($mysqli, "DELETE FROM is_temp_out
											WHERE created_user='$created_user'") or die(
											json_encode(array(
													'error' => array(
														'message' => "Error on \modules\part-masuk\proses.php, line : 215\n".mysqli_error($mysqli) ))));


			// perintah query untuk menyimpan data ke tabel part masuk
			$query1 = mysqli_query($mysqli, "INSERT INTO is_temp_out(
												part_req_id,
												tanggal_transaksi,
												kode_part,
												qty,
												created_user) 
											SELECT
												id,
												'$tanggal_transaksi',
												kode_part,
												remain_issue,
												$created_user
											FROM is_part_req where kode_request = '$kode_request' AND remain_issue > 0;") or die(
											json_encode(array( 
												'error' => array(
													'message' => "Error on \modules\part-masuk\proses.php, line : 223\n".mysqli_error($mysqli) ))));

			// cek query
			if ($query1) {
					echo json_encode(array(
						"result" => array('location'=>"..//..//main.php?module=form_part_masuk_issue&form=add")));
			}  
		} 
	}       
?>