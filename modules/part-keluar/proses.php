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
				$nama_part			= mysqli_real_escape_string($mysqli, trim($_POST['nama_part']));
				$satuan			    = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
				$qty    			= mysqli_real_escape_string($mysqli, trim($_POST['qty']));
				//$total_stok      	= mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
				$group              = mysqli_real_escape_string($mysqli, trim($_POST['group']));
				
				$created_user    	= $_SESSION['id_user'];

				// query cari satuan dari item
				$query_item = mysqli_query($mysqli, "SELECT nama_part, satuan, stok FROM is_part WHERE kode_part = '$kode_part'") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\approval\proses.php, line : 93\n".mysqli_error($mysqli) ))));
				$data_item = mysqli_fetch_row($query_item);
				if($data_item){
					$satuan = $data_item[1];
					$stok = $data_item[2];
				} else{
					$satuan = '';
					$stok = 0;
				}

				// echo("qty" .$qty. ", stok". $stok);exit;
				if($qty > $stok){
					$is_stok = 1;
					echo json_encode(array("is_stok" => $is_stok));
				} else {
					$is_stok = 0;
					// perintah query untuk menyimpan data ke tabel mutasi keluar
					$query = mysqli_query($mysqli, "INSERT INTO is_part_consump(
														kode_request,
														tanggal,
														kode_item,
														nama_item,
														qty,
														`group`,
														satuan,
														created_user) 
													VALUES(
														'$kode_transaksi',
														'$tanggal_transaksi',
														'$kode_part',
														'$nama_part',
														'$qty',
														'$group',
														'$satuan',
														'$created_user')") or die(
													json_encode(array( 
														'error' => array(
															'message' => "Error on \modules\part-keluar\proses.php, line : 51\n".mysqli_error($mysqli) ))));
					
					//ubah baris menjadi approved
					// mysqli_query($mysqli, "UPDATE is_part_consump SET is_approved='1', approved_user='" . $_SESSION['id_user'] . "', approved_date='" . date('Y-m-d H:i:s') . "' WHERE id=" . $data['id']) or die(json_encode(array('error' => array('message' => "Error on \modules\approval\proses.php, line : 172\n".mysqli_error($mysqli) ))));
						
					//kurangi stok is_part
					// mysqli_query($mysqli, "UPDATE is_part SET stok=stok- " . $qty  . " WHERE kode_part='" . $kode_part . "'") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));
					
					//masukkan ke table is_part_trans
					// mysqli_query($mysqli, "INSERT INTO is_part_trans(tanggal_transaksi, kode_transaksi, referensi, kode_request, kode_part, satuan, nama, qty, harga, created_user, created_date) VALUES('" . date('Y-m-d H:i:s') . "', '" . $kode_transaksi . "', 'ISSUE', '', '" .  $kode_part . "', '" . $satuan . "', '" . $nama_part. "', -" . $qty . ", 0, '" .  $created_user . "', '" . date('Y-m-d H:i:s') . "')") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));

					// cek query
					if ($query) {
							echo json_encode(array(
								// "is_stok" => $is_stok,
								"result" => array('location'=>"..//..//main.php?module=form_part_masuk&form=add")));
					}  
				}
			} 
			else if ($_POST['act'] =='save') {
			    $new_name = '';
			 //   print_r($_FILES['bukti']['name']);exit;
    		    if($_FILES['bukti']['name']!=''){
    		        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
    		        
    		        $new_name = uniqid() . '.' . $ext;
    		        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
    		    }
				$id = $_POST['id'];
				// get data
				$query = mysqli_query($mysqli, "SELECT a.id, a.tanggal, a.kode_request, a.kode_item, a.`group`, b.satuan, b.nama_part, a.qty, a.created_user, a.created_date FROM is_part_consump a LEFT OUTER JOIN is_part b ON a.kode_item=b.kode_part WHERE a.kode_request='$id'") or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 168\n".mysqli_error($mysqli) ))));
				

				while($data = mysqli_fetch_assoc($query)){
				    //ubah baris menjadi approved
				    mysqli_query($mysqli, "UPDATE is_part_consump SET is_approved='1', approved_user='" . $_SESSION['id_user'] . "', approved_date='" . date('Y-m-d H:i:s') . "' WHERE id=" . $data['id']) or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 107\n".mysqli_error($mysqli) ))));
				    
				    //kurangi stok is_part
				    mysqli_query($mysqli, "UPDATE is_part SET stok=stok- " . $data['qty']  . " WHERE kode_part='" . $data['kode_item'] . "'") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));
				    
				    //masukkan ke table is_part_trans
				    mysqli_query($mysqli, "INSERT INTO is_part_trans(tanggal_transaksi, kode_transaksi, referensi, kode_request, kode_part, satuan, nama, qty, harga, created_user, created_date, bukti, `group`) VALUES('" . $data['tanggal']. "', '" . $data['kode_request'] . "', 'ISSUE', '', '" .  $data['kode_item'] . "', '" . $data['satuan'] . "', '" . $data['nama_part'] . "', -" . $data['qty'] . ", 0, '" .  $data['created_user'] . "', '" . $data['created_date'] . "', '$new_name', '" . $data['group'] . "')") or die(json_encode(array('error' => array('message' => "Error on  \modules\part-keluar\proses.php, line : 113\n".mysqli_error($mysqli) ))));
				    
				}
				// cek query
				if ($query) {                       
					// jika berhasil tampilkan pesan berhasil simpan data
					//header("location: ../../main.php?module=part_masuk&alert=1");
					echo json_encode(array(
							"result" => array('location'=>"main.php?module=part_keluar")));
				}
			}
			else if ($_POST['act']=='del') {
				$id = $_POST['id'];
				// $qty = $_POST['qty'];
				// query cari satuan dari item
				// $query_item = mysqli_query($mysqli, "SELECT kode_item FROM is_part_consump WHERE id = '$id'") or die(
				// 	json_encode(array(
				// 			'error' => array(
				// 				'message' => "Error on \modules\approval\proses.php, line : 93\n".mysqli_error($mysqli) ))));
				// $data_item = mysqli_fetch_row($query_item);
				// if($data_item){
				// 	$kode_part = $data_item[0];
				// } else{
				// 	$kode_part = '';
				// }

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
    		else if ($_POST['act']=='del_all') {
    			$id 			= $_POST['id'];
				
				$query = mysqli_query($mysqli, "SELECT a.id, a.tanggal, a.kode_request, a.kode_item, b.satuan, b.nama_part, a.qty, a.created_user, a.created_date FROM is_part_consump a LEFT OUTER JOIN is_part b ON a.kode_item=b.kode_part WHERE a.kode_request='$id'") or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 168\n".mysqli_error($mysqli) ))));
				

				while($data = mysqli_fetch_assoc($query)){
				    //tambahkan stok is_part
				    mysqli_query($mysqli, "UPDATE is_part SET stok=stok+ " . $data['qty']  . " WHERE kode_part='" . $data['kode_item'] . "'") or die(json_encode(array('error' => array('message' => "Error on  \modules\approval\proses.php, line : 175\n".mysqli_error($mysqli) ))));
				    
				    
				}
				$query_is_trans = mysqli_query($mysqli, "DELETE FROM is_part_trans
    											WHERE kode_transaksi='$id' ") or die(
    											json_encode(array(
    													'error' => array(
    														'message' => "Error on \modules\part-keluar\proses.php, line : 113\n".mysqli_error($mysqli) ))));

    			$query = mysqli_query($mysqli, "DELETE FROM is_part_consump
    											WHERE kode_request='$id' ") or die(
    											json_encode(array(
    													'error' => array(
    														'message' => "Error on \modules\part-keluar\proses.php, line : 113\n".mysqli_error($mysqli) ))));
    
    			// cek hasil query
    			if ($query) {
    				// jika berhasil tampilkan pesan berhasil delete data
    				//header("location: ../../main.php?module=form_part_masuk&form=add");
    					echo json_encode(array(
    						"result" => array('location'=>"main.php?module=part_keluar")));
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
														'message' => "Error on \modules\part-masuk\proses.php, line : 217\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query1) {
						echo json_encode(array(
							"result" => array('location'=>"..//..//main.php?module=form_part_masuk&form=add")));
				}  
			}
			else if ($_POST['act']=='approved') {
				$id = $_POST['id'];
				
				$query = mysqli_query($mysqli, "SELECT a.id, a.tanggal, a.kode_request, a.kode_item, a.`group`, b.satuan, b.nama_part, a.qty, a.created_user, a.created_date FROM is_part_consump a LEFT OUTER JOIN is_part b ON a.kode_item=b.kode_part WHERE a.kode_request='$id'") or die(json_encode(array('error' => array('message' => "Error on \modules\part-keluar\proses.php, line : 168\n".mysqli_error($mysqli) ))));
				
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