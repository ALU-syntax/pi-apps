<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-book icon-title"></i> List Biaya
    <a class="btn btn-primary btn-social pull-right" href="?module=form_biaya&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
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
              Data biaya berhasil disimpan.
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
				<th class="center">Nomor</th> 
                <th class="center">Tanggal</th>
                <th class="center">Suplier</th>
                <th class="center">Tipe Biaya</th>
                <th class="center">Nama Resto</th>
                <th class="center">Total</th>
				<th class="center">Bukti</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
				
				// fungsi query untuk menampilkan data dari tabel part
				if($_SESSION['hak_akses']=='Purchasing')
				    $query = mysqli_query($mysqli, "SELECT * FROM is_invoice  a  WHERE a.input_by='Purchasing' ORDER BY tanggal DESC")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
				else
				    $query = mysqli_query($mysqli, "SELECT * FROM is_invoice  a ORDER BY tanggal DESC")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												
												
                // fungsi buatRupiah
				function Rupiah($angka){
				$hasil = "Rp " . number_format($angka,2,',','.');
				return $hasil;
				}

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					$tanggal         = $data['tanggal'];
					$exp             = explode('-',$tanggal);
					$tanggal_transaksi   = $exp[2]."-".$exp[1]."-".$exp[0];
					$amount =$data[amount];
           		 	
					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>
						<td width='70' class='center'>$data[nomor]</td>
						<td width='70' class='center'>$tanggal</td>
						<td width='70' class='center'>$suplier</td>
						<td width='50' class='center'>$data[tipe]</td>
						<td width='60' class='center'>$data[resto]</td>	
						<td width='100' class='right'>" . Rupiah($amount) . "</td>
						<td width='60' class='center'><a href='images/upload/$data[bukti]'>$data[bukti]</a></td
						</tr>";
				}
			  ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content