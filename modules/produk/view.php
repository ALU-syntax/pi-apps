<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Produk
	
	<div class="btn-group pull-right">
		<a class="btn btn-primary btn-social" href="?module=form_produk&form=add" title="Receipt" data-toggle="tooltip">
			<span class="fa fa-plus"></span> Tambah
		</a>
	</div>	
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
    // tampilkan pesan Sukses "Data part baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) { ?>
	<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
		Data Produk baru berhasil disimpan.
	</div>
	<?php }
	// jika alert = 2
	// tampilkan pesan Sukses "Data part berhasil diubah"
	elseif ($_GET['alert'] == 2) { ?>
		<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
				Data Produk berhasil diubah.
			</div>
	<?php }
	// jika alert = 3
	// tampilkan pesan Sukses "Data part berhasil dihapus"
	elseif ($_GET['alert'] == 3){ ?>
	<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
		Data Produk berhasil dihapus.
	</div>
	<?php }
	elseif ($_GET['alert'] == 4){ ?>
	<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<h4>  <i class='icon fa fa-check-circle'></i> Error!</h4>
		Data Produk gagal disimpan.
	</div>
	<?php } ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel Part -->
          <table id="dataTables2" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
				<th>No.</th>
				<th>Kode Produk</th>
				<th>Nama Produk</th>
				<th class="center">Action</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
                
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT * FROM is_produk")							
					or die('Ada kesalahan pada query tampil Data Produk: '.mysqli_error($mysqli));

				function Rupiah($angka){
					$hasil = "Rp " . number_format($angka,2,',','.');
					return $hasil;
				}
				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					
					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo '<tr>';
					echo '<td width="30" class="center">' . $no . '</td>';
					echo '<td width="150" class="center">' . $data["kode_produk"] . '</td>';
					echo '<td>' . $data["nama_produk"] . '</td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_produk&form=edit&kode=' . $data['kode_produk']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo '<a class="btn btn-danger btn-xs hapus" title="Hapus" data-id="' . $data['kode_produk'] . '" data-name="'.$data['nama_produk'].'"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;';
					
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
	var name = $(this).attr('data-name');
    if( confirm('Anda yakin ingin menghapus produk: \n'+  id + " : "+ name) ){
		$.ajax({
			url: 'modules/produk/proses.php',
			type: "POST",
			cache: false,
			data: {
				id: id,
				act: 'delete'
			}, 
			success: function(result){
				if (result==="sukses") {
					window.location.href  = "?module=produk&alert=3";
				} else {
					alert(result);
				}
			}
		});
	}
});  
</script>