<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Data Restoran
    <a class="btn btn-primary btn-social pull-right" href="?module=form_resto&form=add" title="Tambah Data" data-toggle="tooltip">
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
      Data Restoran baru berhasil disimpan.
    </div>
    <?php }
    // jika alert = 2
    // tampilkan pesan Sukses "Data part berhasil diubah"
    elseif ($_GET['alert'] == 2) { ?>
      <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Restoran berhasil diubah.
            </div>
    <?php }
    // jika alert = 3
    // tampilkan pesan Sukses "Data part berhasil dihapus"
    elseif ($_GET['alert'] == 3){ ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Restoran berhasil dihapus.
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
                <th class="center">Kode Restoran</th>
                <th class="center">Nama Restoran</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php  
				$no = 1;
				$query = mysqli_query($mysqli, "SELECT * FROM is_resto")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												 // fungsi buatRupiah
				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					echo '<tr>';
					
					echo '<td width="20" class="center">' . $no . '</td>';
					echo '<td class="center">' . $data["kode_resto"] . '</td>';
					echo '<td>' . $data["nama_resto"] . '</td>';
					echo '<td>';
					echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_resto&form=edit&id=' . $data['kode_resto']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					echo "<a class='btn btn-danger btn-xs hapus' title='Hapus' data-id='". $data['kode_resto'] . "' onclick='deleteResto(\"$data[kode_resto]\", \"$data[nama_resto]\");'><i class='glyphicon glyphicon-trash'></i></a>&nbsp;";
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

