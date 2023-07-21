<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Data Item
    <a class="btn btn-primary btn-social pull-right" href="?module=form_part&form=add" title="Tambah Data" data-toggle="tooltip">
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
    // jika alert = "" (kosong) tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data part baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) { ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Item baru berhasil disimpan.
    </div>
    <?php }
    // jika alert = 2
    // tampilkan pesan Sukses "Data part berhasil diubah"
    elseif ($_GET['alert'] == 2) { ?>
      <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Item berhasil diubah.
            </div>
    <?php }
    // jika alert = 3
    // tampilkan pesan Sukses "Data part berhasil dihapus"
    elseif ($_GET['alert'] == 3){ ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Item berhasil dihapus.
    </div>
    <?php } ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel part -->
          <table id="dataTables2" class="table table-bordered table-striped table-hover table-condensed" width="100%">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode Item</th>
                <th class="center">Nama Suplier</th>
                <th class="center">Nama Item</th>
                <th class="center">Group</th>
                <th class="center">Kategori</th>
                <th class="center">Stok</th>
				<th class="center">Stok Level</th>
                <th class="center">Satuan</th>
                <th class="center">Harga</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php  
				$no = 1;
				$query = mysqli_query($mysqli, "SELECT kode_part,kode_suplier, ifnull(suplier.nama,'-') as nama_suplier,nama_part,is_part.group,kategori,satuan ,stok,stok_level,ifnull(harga,0) as harga FROM is_part LEFT JOIN is_suplier as suplier ON suplier.kode = is_part.kode_suplier")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												 // fungsi buatRupiah
				function Rupiah($angka){
          $hasil = "Rp " . number_format($angka,2,',','.');
          return $hasil;
				}

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					echo '<tr>';
					
					echo '<td width="20" class="center">' . $no . '</td>';
					echo '<td class="center">' . $data["kode_part"] . '</td>';
					echo '<td>' . $data["nama_suplier"] . '</td>';
					echo '<td>' . $data["nama_part"] . '</td>';
					echo '<td>' . $data['group'] . '</td>';
					echo '<td>' . $data['kategori'] . '</td>';
					echo '<td>' . $data['stok'] . '</td>';
					echo '<td>' . $data['stok_level'] . '</td>';
					echo '<td>' . $data['satuan'] . '</td>';
					echo '<td>' . Rupiah($data['harga']) . '</td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_part&form=edit&id=' . $data['kode_part']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo "<a class='btn btn-danger btn-xs hapus' title='Hapus' data-id='". $data['kode_part'] . "' onclick='deletePart(\"$data[kode_part]\", \"$data[nama_part]\");'><i class='glyphicon glyphicon-trash'></i></a>&nbsp;";
					echo '</a>';
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
</section><!-- /.content

