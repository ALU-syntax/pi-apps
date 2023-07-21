 <script type="text/javascript">
	function saveData() {
		var part = document.formPartMasuk.kode_part.value.split("|"); //$("#kode_part").val();
		
		if ( getCount('#table-temp') <= 0 )
		{
			alert("Silahkan pilih part !!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			document.formPartMasuk.kode_part.focus();
			return;
		}
		else
		{
			$.post("modules/part-masuk/proses.php",
				{
					act: "save",
				},
				function(result,status){  // ketika sukses menyimpan data
					var data = JSON.parse(result);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.href = data.result.location;
						//var table = $('#dataTables3').DataTable(); 
						//table.ajax.reload( null, false );						   
					}
				});
		}
		
	}
 </script>
 
 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
	if ($_GET['form']=='add') { ?> 
	    <!-- tampilan form add data -->
	  	<!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        <i class="fa fa-edit icon-title"></i> Ubah Suplier
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
	        <li><a href="?module=vend"> Suplier </a></li>
	        <li class="active"> Tambah </li>
	      </ol>
	    </section>

	    <!-- Main content -->
	    <section class="content">
	      <div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
	            <!-- form start -->
	            <form role="form" name="frmAddVendor" class="form-horizontal" action="modules/vend/proses.php" method="POST">
	              <input type="hidden"  name="act" value="insert" />
	  				<div class="box-body">
		                <?php  
		                // fungsi untuk membuat id
		                $query_id = mysqli_query($mysqli, "SELECT cast(RIGHT(kode,5) as int) as kode FROM is_suplier
		                                                  ORDER BY kode DESC LIMIT 1")
		                                                  or die('Ada kesalahan pada query tampil kode_suplier : '.mysqli_error($mysqli));

		                $count = mysqli_num_rows($query_id);

		                if ($count <> 0) {
		                    // mengambil data kode_part
		                    $data_id = mysqli_fetch_assoc($query_id);
		                    $kode    = $data_id['kode']+1;
		                } else {
		                    $kode = 1;
		                }

		                // buat kode_part
		                $buat_id   = str_pad($kode, 5, "0", STR_PAD_LEFT);
		                $kode = "S$buat_id";
		                ?>
              
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Kode Suplier</label>
	                  <div class="col-sm-5">
	                    <input type="text" class="form-control" name="kode" value="<?php echo $kode; ?>" readonly >
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Nama Suplier</label>
	                  <div class="col-sm-5">
	                    <input type="text" class="form-control" name="nama_suplier" autocomplete="off"  required>
	                  </div>
	                </div>

	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Group</label>
	                  <div class="col-sm-5">
	                    <div class="input-group">
	                      <input type="text" class="form-control" id="group" name="group" autocomplete="off"  required>
	                    </div>
	                  </div>
	                </div>
              
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Alamat</label>
	                  <div class="col-sm-5">
	                      <textarea row="5" class="form-control" id="alamat" name="alamat" autocomplete="off" ></textarea>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Telepon</label>
	                  <div class="col-sm-5">
	                      <input type="text" class="form-control" id="telepon" name="telepon" autocomplete="off"  required>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">Email</label>
	                  <div class="col-sm-5">
	                      <input type="text" class="form-control" id="email" name="email" autocomplete="off"  required>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">No. Rekening</label>
	                  <div class="col-sm-5">
	                      <input type="text" class="form-control" id="no_rekening" name="no_rekening" autocomplete="off"  required>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">PIC</label>
	                  <div class="col-sm-5">
	                      <input type="text" class="form-control" id="pic" name="pic" autocomplete="off"  required>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-2 control-label">TOP</label>
	                  <div class="col-sm-5">
	                      <select class="form-control" name="top" id="top">
	                          <?php for($i=1;$i<=30;$i++) : ?>
	                            <option value="<?= $i ?>"><?= $i ?></option>     
	                          <?php endfor; ?>
	                      </select>
	                  </div>
	                </div>
	                
	                
				
	              </div><!-- /.box body -->

	              <div class="box-footer">
	                <div class="form-group">
	                  <div class="col-sm-offset-2 col-sm-10">
	                    <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
	                    <a href="?module=vend" class="btn btn-default btn-reset">Batal</a>
	                  </div>
	                </div>
	              </div><!-- /.box footer -->
	            </form>
	          </div><!-- /.box -->
	        </div><!--/.col -->
	      </div>   <!-- /.row -->
	    </section><!-- /.content -->
	
	<?php
	}
	// jika form edit data yang dipilih
	// isset : cek data ada / tidak
	elseif ($_GET['form']=='edit') { 
	  if (isset($_GET['id'])) {
	      // fungsi query untuk menampilkan data dari tabel part
	      $query = mysqli_query($mysqli, "SELECT kode,nama,`group`,alamat, telepon, email, no_rekening, pic, top FROM is_suplier WHERE kode='$_GET[id]'") 
	                                      or die('Ada kesalahan pada query tampil Data part : '.mysqli_error($mysqli));
	      $data  = mysqli_fetch_assoc($query);
	    }
	?>
  
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Suplier
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=vend"> Suplier </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/vend/proses.php" method="POST">
            <input type="hidden"  name="act" value="update" />
			<div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Suplier</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode" value="<?php echo $data['kode']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Suplier</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama" autocomplete="off" value="<?php echo $data['nama']; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Group</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="group" name="group" autocomplete="off" value="<?php echo $data['group']; ?>" required>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Alamat</label>
                <div class="col-sm-5">
                    <textarea row="5" class="form-control" id="alamat" name="alamat" autocomplete="off" ><?php echo $data['alamat']; ?></textarea>
                </div>
              </div>
              
              <div class="form-group">
                  <label class="col-sm-2 control-label">Telepon</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="telepon" name="telepon" autocomplete="off" value="<?= $data['telepon'] ?> " required>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="<?= $data['email'] ?>"  required>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">No. Rekening</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="no_rekening" name="no_rekening" autocomplete="off" value="<?= $data['no_rekening'] ?>"  required>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">PIC</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" id="pic" name="pic" autocomplete="off" value="<?= $data['pic'] ?>" required>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">TOP</label>
                  <div class="col-sm-5">
                      <select class="form-control" name="top" id="top">
                          <?php for($i=1;$i<=30;$i++) : ?>
                            <option value="<?= $i ?>"<?=$data['top']==$i ? ' selected' : '' ?>><?= $i ?></option>     
                          <?php endfor; ?>
                      </select>
                  </div>
                </div>
                
			  

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=part" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>