 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Item
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=sales"> Item </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/sales/proses.php" method="POST">
            <input type="hidden"  name="act" value="insert" />
			<div class="box-body">
              <?php  
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT Cast(RIGHT(no,5) as int) as kode FROM is_sales
                                                ORDER BY no DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_part : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode_part
                  $data_no = mysqli_fetch_assoc($query_id);
                  $kode    = $data_no['kode']+1;
                 
              } else {
                  $kode = 1;
              }

              // buat kode_part
              $buat_no   = str_pad($kode, 5, "0", STR_PAD_LEFT);
              $no = "S$buat_no";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">No</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="no" value="<?php echo $no; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Restoran</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="resto" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
					<option value="Libero">Libero</option>
                  </select>
                </div>
              </div>

               <div class="form-group">
					<label class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-5">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
					</div>
				</div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Total Sales</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="value" name="value" autocomplete="off" required>
                </div>
              </div>
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=sales" class="btn btn-default btn-reset">Batal</a>
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
  if (isset($_GET['no'])) {
      // fungsi query untuk menampilkan data dari tabel sales
      $query = mysqli_query($mysqli, "SELECT resto,tanggal,value FROM is_sales WHERE no='$_GET[no]'") 
                                      or die('Ada kesalahan pada query tampil Data part : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
	  $no    = $_GET['no'];
	  $tgl   = DateTime::createFromFormat('Y-m-d', $data['tanggal'])->format('d-m-Y');
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Sales
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=sales"> Sales </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/sales/proses.php" method="POST">
            <input type="hidden"  name="act" value="update" />
			<div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Sales</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="no" value="<?php echo $no; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Resto</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="resto" autocomplete="off" value="<?php echo $data['resto']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
					<label class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-5">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal" name="tanggal" autocomplete="off" value="<?php echo $tgl; ?>" required>
					</div>
				</div>
			  <div class="form-group">
                <label class="col-sm-2 control-label">Value</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="value" autocomplete="off" value="<?php echo $data['value']; ?>" required>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=sales" class="btn btn-default btn-reset">Batal</a>
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