<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-shopping-cart icon-title"></i> Pembelian
    <a class="btn btn-primary btn-social pull-right" href="?module=form_part_request&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Buat PO Baru
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
              Data Part Masuk berhasil disimpan.
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
                <th class="center">Nama Suplier</th>
                <th class="center">No. PO</th>
                <th class="center">Tipe PO</th>
                <th class="center">Total</th>
                <th class="center">Status Bayar</th>
                <th class="center">Tanggal Jatuh Tempo</th>
                <th class="center">Bukti</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT kode_request, suplier, tipe, SUM(jumlah) AS total, status_bayar, bukti, jatuh_tempo FROM is_part_req
                    GROUP BY kode_request ORDER BY tanggal DESC")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												 // fungsi buatRupiah
				function Rupiah($angka){
				$hasil = "Rp " . number_format($angka,2,',','.');
				return $hasil;
				}

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					/*$tanggal         = $data['tanggal'];
					$exp             = explode('-',$tanggal);
					$tanggal_transaksi   = $exp[2]."-".$exp[1]."-".$exp[0];
					
					$tanggal        = $data['jatuh_tempo'];
					$exp            = explode('-', $tanggal);
					$jatuh_tempo    = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
					$harga          = $data[harga];
                    $total = $data['harga'] * $data['qty'];*/
					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo '<tr>';
					
					echo '<td width="20" class="center">' . $no . '</td>';
					 echo '<td width="200">' . $data["suplier"] . '</td>';
					echo '<td width="120" class="center">' . $data["kode_request"] . '</td>';
					echo '<td width="60" class="center">' . $data["tipe"] . '</td>';
					echo '<td width="100">' . Rupiah($data['total'] ) . '</td>';
					echo '<td width="50" align="right">' . $data['status_bayar'] . '</td>';
					echo '<td width="100" align="right">' . $data['jatuh_tempo'] . '</td>';
					echo '<td width="50" class="center"><a href="images/upload/' . $data['bukti'] . '">' . $data['bukti'] . '</td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_part_request&form=edit&kode=' . $data['kode_request']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo '<a class="btn btn-danger btn-xs hapus" title="Hapus" data-id="' . $data['kode_request'] . '"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;';
					echo '<a class="btn btn-success btn-xs bayar" title="Bayar" data-id="' . $data['kode_request'] . '"><i class="glyphicon glyphicon-usd"></i></a>&nbsp;';
					echo '<a class="btn btn-warning btn-xs" title="Cetak" href="print.php?module=print_part_request&kode=' . $data['kode_request'] . '"><i class="glyphicon glyphicon-print"></i></a>';
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pembayaran</h4>
      </div>
      <div class="modal-body">
        <form id="frmModal" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id">No. Request</label>
            <input type="text" class="form-control" id="id" name="id" placeholder="No. Request" readonly>
          </div>
          <div class="form-group">
            <label for="bukti">Bukti</label>
            <input type="file" class="form-control" id="bukti" name="bukti" placeholder="Bukti" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="save">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
$('.hapus').on('click', function(e){
    e.preventDefault();
    
    var id = $(this).attr('data-id');
	
	$.ajax({
	    url: 'modules/part-request/proses.php',
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

$('.bayar').on('click', function(e){
    e.preventDefault();
    
    var id = $(this).attr('data-id');
    $('#id').val(id);
    $('#bukti').val('');
    
    $('#myModal').modal();
});

$('#save').on('click', function(){
    if($('#bukti').val()==''){
        alert('Harap lengkapi bukti!');
        return;
    }
    
    $('#frmModal').submit();
});

$('#frmModal').on('submit', function(e){
    e.preventDefault();
    
    var formData = new FormData(this);
	formData.append('act', 'pay');
	
	$.ajax({
	    url: 'modules/part-request/proses.php',
		type: "POST",
		cache: false,
		data: formData, 
		contentType: false,
		processData: false,
		success: function(data){
			var data = JSON.parse(data);
			if (data.error) {
				// tampilkan pesan gagal simpan data
				swal("Gagal!", data.error.message, "error");
			} else {
				// tampilkan data transaksi
				location.href = data.result.location;
			}
		}
	});
    
})


</script>