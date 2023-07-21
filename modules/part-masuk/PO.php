
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

if(isset($_POST['tipe'])) {
	$tipe = $_POST['tipe'];

	$query = mysqli_query($mysqli, "SELECT distinct kode_request 
										FROM is_part_req 
										WHERE status = 1 and tipe = '$tipe'
										ORDER BY kode_request ASC")
										or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
	echo "<option value=''></option>";
	while ($data = mysqli_fetch_assoc($query)) {
		$value = $data['kode_request'];
		echo "<option value='$value' > $data[kode_request]</option>";
	}
}
?> 