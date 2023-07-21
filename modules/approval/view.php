<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Approval Mutasi Keluar
    <!--<a class="btn btn-primary btn-social pull-right" href="?module=form_approval&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a>-->
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
                <th class="center">Tanggal</th>
                <!--<th class="center">Kode Item</th>
                <th class="center">Nama Item</th>
                <th class="center">Qty</th>--->
                <th class="center">Status</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT kode_request, tanggal, is_approved FROM is_part_consump GROUP BY kode_request ORDER BY kode_request  DESC")
												or die('Ada kesalahan pada query tampil Data Mutasi Keluar: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) {
					$tanggal         = $data['tanggal'];
					$exp             = explode('-',$tanggal);
					$tanggal_transaksi   = $exp[2]."-".$exp[1]."-".$exp[0];

					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>";
					echo "<td width='30' class='center'>$no</td>";
					echo "<td width='100' class='center'>$data[kode_request]</td>";
					echo "<td width='80' class='center'>$tanggal_transaksi</td>";
					
					echo "<td width='100' class='center'>";
					    switch($data['is_approved']){
					        case -1:
					            echo 'pending';
					            break;
					        case 0:
					            echo 'reject';
					            break;
					        case 1:
					            echo 'approve';
					            break;
					    }
					
					echo "</td>";
					
					echo "<td width='60'>";
					if($_SESSION['hak_akses']=='Super Admin') {
					    if($data['is_approved']==-1){
    					    echo '<a class="btn btn-success btn-xs" onclick="approved(\'' . $data['kode_request'] . '\')">';
    					    echo '<i class="glyphicon glyphicon-thumbs-up"></i>';
    					    echo '</a>&nbsp;';
					   
					        echo '<a class="btn btn-danger btn-xs" onclick="reject(\'' . $data['kode_request'] .'\')">';
    					    echo '<i class="glyphicon glyphicon-thumbs-down"></i>';
    					    echo '</a>&nbsp;';
					    }
					}
					
					echo '<a class="btn btn-primary btn-xs" href="?module=form_approval&form=add&kode=' . $data['kode_request'] .'"><i class="glyphicon glyphicon-edit"></a>';
					    
					echo "</td>";
					
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
</section><!-- /.content -->

<script>
    function approved(id){
		
		$.post("modules/approval/proses.php",
			{
				act: "approved",
				id : id,
			},
			function(result,status){  // ketika sukses menyimpan data
				var data = JSON.parse(result);
				if (data.error) {
					// tampilkan pesan gagal simpan data
					swal("Gagal!", data.error.message, "error");
				} else {
					location.reload();
				}
				
			}
		);
	}
	
	function reject(id){
		
		$.post("modules/approval/proses.php",
			{
				act: "reject",
				id : id,
			},
			function(result,status){  // ketika sukses menyimpan data
				var data = JSON.parse(result);
				if (data.error) {
					// tampilkan pesan gagal simpan data
					swal("Gagal!", data.error.message, "error");
				} else {
					location.reload();
				}
				
			}
		);
	}
</script>    
    