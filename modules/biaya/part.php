

<?php
session_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";

if(isset($_POST['dataidpart'])) {
	$kode_part = $_POST['dataidpart'];

  // fungsi query untuk menampilkan data dari tabel part
  $query = mysqli_query($mysqli, "SELECT kode_part,nama_part,satuan,stok FROM is_part WHERE kode_part='$kode_part'")
                                  or die('Ada kesalahan pada query tampil data part: '.mysqli_error($mysqli));

  // tampilkan data
  $data = mysqli_fetch_assoc($query);

  $stok   = $data['stok'];
  $satuan = $data['satuan'];

	if($stok != '') {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stok</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stok' value='$stok' readonly>
                    <span class='input-group-addon'>$satuan</span>
                  </div>
                </div>
              </div>";
	} else {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stok</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stok' value='Stok part tidak ditemukan' readonly>
                    <span class='input-group-addon'>Satuan part tidak ditemukan</span>
                  </div>
                </div>
              </div>";
	}		
}
?> 