<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Mutasi Item Masuk
	
	<div class="btn-group pull-right">
		<a class="btn btn-primary btn-social" href="?module=form_part_masuk&form=add" title="Receipt" data-toggle="tooltip">
			<span class="fa fa-plus"></span> Masuk
		</a>
	<!--	<a class="btn btn-primary btn-social" href="?module=form_part_masuk_issue&form=add" title="Issue" data-toggle="tooltip">
			<span class="fa fa-minus"></span> Keluar
		</a>-->
	</div>	
	<!--
	<div class="form-group  row pull-right">
	<div class="col-sm-6">
	<a class="btn btn-primary btn-social" href="?module=form_part_masuk_issue&form=add" title="Issue" data-toggle="tooltip">
      <i class="fa fa-minus"></i> Issue
    </a>
	</div>
	<div class="col-sm-6">
	 <a class="btn btn-primary btn-social" href="?module=form_part_masuk&form=add" title="Receipt" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Receipt
    </a>
	</div>
	</div> -->
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
              Data Mutasi Item berhasil disimpan.
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
				<th>No.</th>
				<th>Kode Transaksi</th>
				<th>Suplier</th>
				<th>No. PO</th>
				<th>Tgl. Terima</th>
				<th>Total</th>
				<th>Bukti</th>
				
				<th class="center">Action</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
                
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT t.kode_transaksi, s.nama AS suplier,SUM(t.qty * t.harga) AS total, t.kode_request, t.tanggal_transaksi, t.qty, t.bukti FROM is_part_trans t LEFT OUTER JOIN is_suplier s ON t.kode_suplier=s.kode GROUP BY t.kode_transaksi")
												or die('Ada kesalahan pada query tampil Data Part Masuk: '.mysqli_error($mysqli));

				function Rupiah($angka){
				$hasil = "Rp " . number_format($angka,2,',','.');
				return $hasil;
				}
				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					$tanggal         = $data['tanggal_transaksi'];
					$exp             = explode('-',$tanggal);
					$tanggal_transaksi   = $exp[2]."-".$exp[1]."-".$exp[0];

					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo '<tr>';
					echo '<td width="30" class="center">' . $no . '</td>';
					echo '<td width="150" class="center">' . $data["kode_transaksi"] . '</td>';
					echo '<td width="200" class="center">' . $data["suplier"] . '</td>';
					echo '<td width="150" class="center">' . $data["kode_request"] . '</td>';
					echo '<td width="80" class="center">' . $tanggal_transaksi . '</td>';
					echo '<td width="80" class="right">' . Rupiah($data["total"]) . '</td>';
					echo '<td width="60" class="center"><a href="images/upload/' . $data["bukti"] . '">' . $data["bukti"] . '</a></td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_part_masuk&form=edit&kode=' . $data['kode_transaksi']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo '<a class="btn btn-danger btn-xs hapus" title="Hapus" data-id="' . $data['kode_transaksi'] . '"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;';
					
					echo '</td>';
					echo '</tr>';
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
	    url: 'modules/part-masuk/proses.php',
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