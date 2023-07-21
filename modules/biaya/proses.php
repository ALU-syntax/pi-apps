<?php
	session_start();
	// Panggil koneksi database.php untuk koneksi database
	require_once "../../config/database.php";

	// fungsi untuk pengecekan status login user 
	// jika user belum login, alihkan ke halaman login dan tampilkan pesan = 1
	if (empty($_SESSION['username']) && empty($_SESSION['password']))	{
		echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
	}
	// jika user sudah login, maka jalankan perintah untuk insert, update, dan delete
	else {
		if (isset($_POST['act'])) {
			if ($_POST['act']=="add")  {
				// ambil data hasil submit dari form
				$no 		  = mysqli_real_escape_string($mysqli, trim($_POST['no']));
				$tanggal_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	  = explode('-',$tanggal_transaksi);
				$tanggal			      = $exp[2]."-".$exp[1]."-".$exp[0];
				
				
				$harga    			    = mysqli_real_escape_string($mysqli, trim($_POST['harga']));
				//$total_stok      	= mysqli_real_escape_string($mysqli, trim($_POST['total_stok']));
				
				$created_user    	= $_SESSION['id_user'];
				$tipe				      = mysqli_real_escape_string($mysqli, trim($_POST['tipe']));
				$status				    = 1;
				$ket				      = mysqli_real_escape_string($mysqli, trim($_POST['ket']));
				$resto				      = mysqli_real_escape_string($mysqli, trim($_POST['resto']));
        
				// perintah query untuk menyimpan data ke tabel part masuk
				$query = mysqli_query($mysqli, "INSERT INTO is_temp_inv(
													tanggal,
													nomor,
													tipe,
													keterangan,
													resto,
													amount,
													createdby) 
												VALUES(
													'$tanggal',
													'$no',
													'$tipe',
													'$ket',
													'$resto',
													'$harga',
													'$created_user'
													)" ) or die(
												json_encode( array( 
													'error' => array(
														'message' => "Error on \modules\part-request\proses.php, line : 67\n".mysqli_error($mysqli) ))));

				// cek query
				if ($query) {
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_biaya&form=add")));
				}  
			} 
			else if ($_POST['act'] =='save') {
			    $new_name = '';
			    
			    if($_FILES['bukti']['name']!=''){
			        $ext = pathinfo($_FILES['bukti']['name'])['extension'];
			        
			        $new_name = uniqid() . '.' . $ext;
			        move_uploaded_file($_FILES['bukti']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/piapps/images/upload/' . $new_name);
			    }
			    
			    
				$no 		= mysqli_real_escape_string($mysqli, trim($_POST['no']));
				$tanggal_transaksi  = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
				$exp             	= explode('-',$tanggal_transaksi);
				$tanggal			= $exp[2]."-".$exp[1]."-".$exp[0];
				
				
				$created_user    	= $_SESSION['id_user'];
				$tipe				  = mysqli_real_escape_string($mysqli, trim($_POST['tipe']));
				$ket				= mysqli_real_escape_string($mysqli, trim($_POST['ket']));
				$input_by           = mysqli_real_escape_string($mysqli, trim($_POST['input_by']));
				try{
					mysqli_autocommit($mysqli, false);
					mysqli_query($mysqli, "INSERT INTO is_invoice(
												tanggal,
												nomor,
												keterangan,
												tipe,
												amount,
												resto,
												createdby, 
												bukti,
												input_by) 
											SELECT 
												tanggal,
												nomor,
												keterangan,
												tipe,
												amount,
												resto,
												createdby,
												'$new_name',
												'$input_by'
											FROM is_temp_inv ") or  throws("Error on \modules\biaya\proses.php, line :58\n".mysqli_error($mysqli)); 
					
					mysqli_query($mysqli, "DELETE FROM is_temp_inv
													WHERE createdby = '$created_user'") or throws("Error on \modules\biaya\proses.php, line :58\n".mysqli_error($mysqli));
					
					mysqli_commit($mysqli);
					echo json_encode(array(
						"result" => array('location'=>"main.php?module=biaya&alert=1")));
				}
				catch(Exception $e) {
					mysqli_rollback($mysqli);
					echo json_encode(array(
						'error' => array(
							'message' => $e->getMessage().mysqli_error($mysqli) )));
				}
				finally{mysqli_autocommit($mysqli,true);}
				 
			}
			else if ($_POST['act']=='del') {
				$created_user   = $_SESSION['id_user'];
				$id 			= $_POST['id'];
				// perintah query untuk menghapus data pada tabel part
				$query = mysqli_query($mysqli, "DELETE FROM is_temp_inv
												WHERE id='$id' ") or die(
												json_encode(array(
														'error' => array(
															'message' => "Error on \modules\part-masuk\proses.php, line : 122\n".mysqli_error($mysqli) ))));

				// cek hasil query
				if ($query) {
					// jika berhasil tampilkan pesan berhasil delete data
					//header("location: ../../main.php?module=form_part_masuk&form=add");
						echo json_encode(array(
							"result" => array('location'=>"main.php?module=form_part_masuk&form=add")));
				}
			}
		} 		
	}       
?>