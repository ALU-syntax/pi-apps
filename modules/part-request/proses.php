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
				$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				$tanggal_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	= explode('-',$tanggal_transaksi);
				$tanggal			= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$jatuh_tempo  = mysqli_real_escape_string($mysqli, trim($_POST['jatuh_tempo']));
				$exp             	= explode('-',$jatuh_tempo);
				$jatuh_tempo        = $exp[2]."-".$exp[1]."-".$exp[0];
				
				$kode_part       	= mysqli_real_escape_string($mysqli, trim($_POST['kode_part']));
				$kode_suplier			  = mysqli_real_escape_string($mysqli, trim($_POST['kode_suplier']));	
        
				$nama_part       	= mysqli_real_escape_string($mysqli, trim($_POST['nama_part']));
				$nama_suplier		= mysqli_real_escape_string($mysqli, trim($_POST['nama_suplier']));	
				$qty    			      = mysqli_real_escape_string($mysqli, trim($_POST['qty']));
				$harga    			    = mysqli_real_escape_string($mysqli, trim($_POST['harga']));
				//$total_stok      	= mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
				$diskon             = mysqli_real_escape_string($mysqli, trim($_POST['diskon']));
				$pajak              = mysqli_real_escape_string($mysqli, trim($_POST['pajak']));
				$jumlah             = mysqli_real_escape_string($mysqli, trim($_POST['jumlah']));
				
				$created_user    	= $_SESSION['id_user'];
				$tipe				      = mysqli_real_escape_string($mysqli, trim($_POST['tipe']));
				$status				    = 1;
				//$status_bayar       = mysqli_real_escape_string($mysqli, trim($_POST['status_bayar']));
				
				$ket				      = mysqli_real_escape_string($mysqli, trim($_POST['ket']));
				$satuan				      = mysqli_real_escape_string($mysqli, trim($_POST['satuan']));
        
				// perintah query untuk menyimpan data ke tabel part masuk
				$query = mysqli_query($mysqli, "INSERT INTO is_temp_req(
													kode_request,
													keterangan,
													tanggal,
													jatuh_tempo,
													kode_part,
                          nama_item,
                          satuan,
													qty,
                          harga,
                          diskon,
                          pajak,
                          jumlah,
                          kode_suplier,
                          suplier,
													created_user,
													status,
													tipe,
													status_bayar) 
												VALUES(
													'$kode_request',
													'$ket',
													'$tanggal',
													'$jatuh_tempo',
													'$kode_part',
                          '$nama_part',
                          '$satuan',
													'$qty',
                          '$harga',
                          $diskon,
                          $pajak,
                          $jumlah,
                          '$kode_suplier',
                          '$nama_suplier',
													'$created_user',
													'$status', 
													'$tipe',
													'Unpaid')" ) or die(
												json_encode( array( 
													'error' => array(
														'message' => "Error on \modules\part-request\proses.php, action add row line 67\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query) {
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_request&form=add")));
				}  
			} 
			else if ($_POST['act'] =='save') {
			    $new_name = '';
			    
			    /*if($_FILES['bukti']['name']!=''){
			        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
			        
			        $new_name = uniqid() . '.' . $ext;
			        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
			    }*/
			    
			    
				$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['no_po'])); //mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				$tanggal_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	= explode('-',$tanggal_transaksi);
				$tanggal			= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$jatuh_tempo        = mysqli_real_escape_string($mysqli, trim($_POST['jatuh_tempo']));
				$exp                = explode('-', $jatuh_tempo);
				$jatuh_tempo        = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
				
				
				$created_user    	= $_SESSION['id_user'];
				$tipe				  = mysqli_real_escape_string($mysqli, trim($_POST['tipe']));
				//$status_bayar       = mysqli_real_escape_string($mysqli, trim($_POST['status_bayar']));
				$status				= 1;
				$ket				= mysqli_real_escape_string($mysqli, trim($_POST['descr']));//mysqli_real_escape_string($mysqli, trim($_POST['ket']));
				
				if ($tipe == 'STOK') $status = 3 ;


				try
				{
					mysqli_autocommit($mysqli, false);
					mysqli_query($mysqli, "INSERT INTO is_part_req(
													kode_request,
													keterangan,
													tanggal,
													jatuh_tempo,
													kode_part,
													nama_item,
													satuan,
													qty,
													harga,
													diskon,
													pajak,
													jumlah,
													remain_receipt,
													kode_suplier,
													suplier,
													created_user,
													status,
													tipe,
													status_bayar) 
												SELECT 
													'$kode_request' kode_request,
													'$ket' ket,
													'$tanggal' tanggal,
													'$jatuh_tempo' jatuh_tempo,
													kode_part,
													nama_item,
													satuan,
													qty,
													harga,
													diskon,
													pajak,
													jumlah,
													qty,
													kode_suplier,
													suplier,
													created_user,
													'$status' status,
													'$tipe' tipe,
													'Unpaid'
												FROM is_temp_req ") or throws("Error on \modules\part-request\proses.php, line :123\n".mysqli_error($mysqli)); 
					
					
					mysqli_query($mysqli, "DELETE FROM is_temp_req 
													WHERE created_user = '$created_user'") or throws("Error on \modules\part-request\proses.php, line :128\n".mysqli_error($mysqli)); ;
					mysqli_commit($mysqli);
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_request&alert=1")));
				}
				catch(Exception $e) 
				{
					mysqli_rollback($mysqli);
					echo json_encode(array(
						'error' => array(
									'message' =>  $e->getMessage().mysqli_error($mysqli) )));

				}
				finally{mysqli_autocommit($mysqli,true);}
				/*
				$query = mysqli_query($mysqli, "INSERT INTO is_part_req(
													kode_request,
													keterangan,
													tanggal,
													kode_part,
													nama_item,
													satuan,
													qty,
													harga,
													remain_receipt,
													kode_suplier,
													suplier,
													created_user,
													status,
													tipe) 
												SELECT 
													'$kode_request' kode_request,
													'$ket' ket,
													'$tanggal' tanggal,
													kode_part,
													nama_item,
													satuan,
													qty,
													harga,
													qty,
													kode_suplier,
													suplier,
													created_user,
													'$status' status,
													'$tipe' tipe
												FROM is_temp_req ") or die(
												json_encode( array(
														'error' => array(
															'message' => "Error on \modules\part-request\proses.php, action save line 123\n".mysqli_error($mysqli) ))));

				
				
				// cek query
				if ($query) {
					$created_user    	= $_SESSION['id_user'];
					// perintah query untuk mengubah data pada tabel part
					$query1 = mysqli_query($mysqli, "DELETE FROM is_temp_req 
													WHERE created_user = '$created_user'") or die(json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-request\proses.php, line : 160\n".mysqli_error($mysqli) ))));

					// cek query
					if ($query1) {                       
						// jika berhasil tampilkan pesan berhasil simpan data
						//header("location: ../../main.php?module=part_masuk&alert=1");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=part_request&alert=1")));
					}
				}   	
				*/
			}else if($_POST['act']=='update'){
			    $new_name = '';
			    
			    if($_FILES['bukti']['name']!=''){
			        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
			        
			        $new_name = uniqid() . '.' . $ext;
			        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
			    }
			    
			    
				$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['no_po'])); //mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				$tanggal_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	= explode('-',$tanggal_transaksi);
				$tanggal			= $exp[2]."-".$exp[1]."-".$exp[0];
				
				$jatuh_tempo        = mysqli_real_escape_string($mysqli, trim($_POST['jatuh_tempo']));
				$exp                = explode('-', $jatuh_tempo);
				$jatuh_tempo        = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
				
				
				$created_user    	= $_SESSION['id_user'];
				$tipe				  = mysqli_real_escape_string($mysqli, trim($_POST['tipe']));
				$status				= 1;
				//$status_bayar       = mysqli_real_escape_string($mysqli, trim($_POST['status_bayar']));
				$ket				= mysqli_real_escape_string($mysqli, trim($_POST['descr']));//mysqli_real_escape_string($mysqli, trim($_POST['ket']));
				
				if($new_name!=''){
				    mysqli_query($mysqli, "UPDATE is_part_req SET 
                        keterangan='$ket',
						tanggal='$tanggal',
						jatuh_tempo='$jatuh_tempo',
						status='$status',
						tipe='$tipe', 
						bukti='$new_name' WHERE kode_request='$kode_request'") or die(json_encode(array('error' => array('message'=> "Error on \modules\part-masuk\proses.php, line : 248\n".mysqli_error($mysqli) ))));
				}
				else{
				    mysqli_query($mysqli, "UPDATE is_part_req SET 
                        keterangan='$ket',
						tanggal='$tanggal',
						jatuh_tempo='$jatuh_tempo',
						status='$status',
						tipe='$tipe' WHERE kode_request='$kode_request'") or die(json_encode(array('error' => array('message'=> "Error on \modules\part-masuk\proses.php, line : 257\n".mysqli_error($mysqli) ))));   
				}
				
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_request&alert=1")));
				
			}else if ($_POST['act']=='del') {
				$created_user   = $_SESSION['id_user'];
				$id 			= $_POST['id'];
				// perintah query untuk menghapus data pada tabel part
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_req 
												WHERE id='$id' ") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 196			\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
				}
			}else if ($_POST['act']=='del_all') {
				$id 			= $_POST['id'];
				
				$query = mysqli_query($mysqli, "DELETE FROM is_part_req 
												WHERE kode_request='$id' ") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 293\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=part_request")));
				}
			}else if($_POST['act']=='pay'){
			    $new_name = '';
			    
			    if($_FILES['bukti']['name']!=''){
			        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
			        
			        $new_name = uniqid() . '.' . $ext;
			        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
			    }
			    
			    
				$kode_request 		= mysqli_real_escape_string($mysqli, trim($_POST['id'])); //mysqli_real_escape_string($mysqli, trim($_POST['kode_request']));
				
				if($new_name!=''){
				    mysqli_query($mysqli, "UPDATE is_part_req SET 
						status_bayar='Paid',
						bukti='$new_name' WHERE kode_request='$kode_request'") or die(json_encode(array('error' => array('message'=> "Error on \modules\part-masuk\proses.php, line : 248\n".mysqli_error($mysqli) ))));
				}
				
				
				echo json_encode(array(
						"result" => array('location'=>"main.php?module=part_request&alert=1")));
			    
			}
		} 		
	}
?>