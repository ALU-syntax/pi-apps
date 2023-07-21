<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Mutasi Item Keluar
    <a class="btn btn-primary btn-social pull-right" href="?module=form_part_keluar&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-minus"></i> Keluar
    </a>
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data Part Masuk berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Part Keluar berhasil disimpan.
            </div>";
    }
    ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel Part -->
          <table id="dataTables2" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode Transaksi</th>
                <th class="center">Group</th>
                <th class="center">Tanggal</th>
                <th class="center">Qty</th>
                <th class="center">Bukti</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				//$query = mysqli_query($mysqli, "SELECT d.kode_request, d.tanggal, p.kode_part, p.nama_part, d.qty, p.satuan FROM `is_part_consump` d LEFT OUTER JOIN is_part p ON d.kode_item=p.kode_part  WHERE d.is_approved='1'") or die('Ada kesalahan pada query tampil Data Part Keluar: 54' . mysqli_error($mysqli));
				
				$query = mysqli_query($mysqli, "SELECT t.kode_request, t.`group`, t.tanggal, SUM(t.qty) AS qty, s.bukti 
          FROM is_part_consump t 
          LEFT OUTER JOIN (SELECT * FROM is_part_trans GROUP BY kode_transaksi) s ON t.kode_request = s.kode_transaksi 
          GROUP BY t.kode_request") or die('Ada kesalahan pada query tampil Data Part Keluar: 58' . mysqli_error($mysqli));
				
				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					$tanggal         = $data['tanggal'];
					$exp             = explode('-',$tanggal);
					$tanggal_transaksi   = $exp[2]."-".$exp[1]."-".$exp[0];

					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>";
					echo '<td width="30" class="center">' . $no . '</td>';
					echo '<td width="200" class="center">' . $data["kode_request"] . '</td>';
					echo '<td width="150" class="center">' . $data["group"] . '</td>';
					echo '<td width="100" class="center">' . $tanggal_transaksi. '</td>';
					echo '<td width="50" class="center">' . number_format($data["qty"]) . '</td>';
					echo '<td width="60" class="center"><a href="images/upload/' . $data["bukti"] . '">' . $data["bukti"] . '</a></td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_part_keluar&form=edit&kode=' . $data['kode_request']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo '<a class="btn btn-danger btn-xs hapus" title="Hapus" data-id="' . $data['kode_request'] . '"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;';
					
					echo '</td>';
					
				
					
					echo "</tr>";
					$no++;
				}
			  ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section>

<script>
$('.hapus').on('click', function(e){
    e.preventDefault();
    
    var id = $(this).attr('data-id');
	
	$.ajax({
	    url: 'modules/part-keluar/proses.php',
		type: "POST",
		cache: false,
		data: {
		    id: id,
		    act: 'del_all'
		}, 
		success: function(data){
			var data = JSON.parse(data);
			if (data.error) {
				// tampilkan pesan gagal simpan data
				swal("Gagal!", data.error.message, "error");
			} else {
				// tampilkan data transaksi
				//location.href = data.result.location;
				location.reload();
			}
		}
	});
});  
</script>

 
    