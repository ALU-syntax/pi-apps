<?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Restoran
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=resto"> Restoran </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/resto/proses.php" method="POST">
            <input type="hidden"  name="act" value="insert" />
			<div class="box-body">
              <?php  
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT Cast(RIGHT(kode_resto,5) as int) as kode FROM is_resto
                                                ORDER BY kode_resto DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_part : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode_resto
                  $data_id = mysqli_fetch_assoc($query_id);
                  $kode    = $data_id['kode']+1;
              } else {
                  $kode = 1;
              }

              // buat kode_resto
              $buat_id   = str_pad($kode, 5, "0", STR_PAD_LEFT);
              $kode_resto = "R$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Restoran</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_resto" value="<?php echo $kode_resto; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Restoran</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_resto" autocomplete="off" required>
                </div>
              </div>

              <!-- /.box body -->

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
// jika form edit data yang dipilih
// isset : cek data ada / tidak
elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {
      // fungsi query untuk menampilkan data dari tabel part
      // $query = mysqli_query($mysqli, "SELECT kode_part,kode_suplier,nama_part,`group`,kategori,satuan ,stok,stok_level FROM is_part WHERE kode_part='$_GET[id]'") 
      $query = mysqli_query($mysqli, "SELECT kode_resto,nama_resto FROM is_resto WHERE kode_resto='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data part : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Resto
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part"> Part </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/resto/proses.php" method="POST">
            <input type="hidden"  name="act" value="update" />
			<div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Restoran</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_resto" value="<?php echo $data['kode_resto']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Restoran</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_resto" autocomplete="off" value="<?php echo $data['nama_resto']; ?>" required>
                </div>
              </div>

              <!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=resto" class="btn btn-default btn-reset">Batal</a>
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