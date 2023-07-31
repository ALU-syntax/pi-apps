
<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once '../../config/database.php';

if(isset($_POST['item'])) {
	$item = $_POST['item'];

  // fungsi query untuk menampilkan data dari tabel obat
  $query = mysqli_query($mysqli, "SELECT stok FROM is_part WHERE kode_part ='$item'")
                                  or die('Ada kesalahan pada query tampil data unit: '.mysqli_error($mysqli));

  // tampilkan data
  $data = mysqli_fetch_assoc($query);

  $satuan = $data['stok'];

	if($satuan != '') {
		/*echo "<div class='col-sm-2'>
					<input type='hidden' id='unit' name='unit' value = '$satuan'>
					<div class='input-group'>
						<input type='text' class='form-control' id='qty' name='qty' autocomplete='off' onKeyPress='return goodchars(event,'-0123456789',this)' onkeyup='hitung_total_stok(this)&cek_qty(this)'>
						<span class='input-group-addon'>$satuan</span>
					</div>
				</div>";*/
				echo $satuan;
	} 	
}
?> 