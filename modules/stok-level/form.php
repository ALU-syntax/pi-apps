<?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Stok Level
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=stok_level"> Stok Level </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/part/proses.php?act=insert" method="POST">
            <div class="box-body">
              <?php  
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_part,6) as kode FROM is_part
                                                ORDER BY kode_part DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil kode_part : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                  // mengambil data kode_part
                  $data_id = mysqli_fetch_assoc($query_id);
                  $kode    = $data_id['kode']+1;
              } else {
                  $kode = 1;
              }

              // buat kode_part
              $buat_id   = str_pad($kode, 6, "0", STR_PAD_LEFT);
              $kode_part = "B$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_part" value="<?php echo $kode_part; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_part" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Group</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="group" name="group" autocomplete="off" required>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="kategori" name="kategori" autocomplete="off" required>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
                    <option value="Botol">Botol</option>
                    <option value="Box">Box</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Set">Set</option>
                    <option value="Strip">Strip</option>
                    <option value="Tube">Tube</option>
                    <option value="Unit">Unit</option>
                  </select>
                </div>
              </div>
            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=stok_level" class="btn btn-default btn-reset">Batal</a>
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
      $query = mysqli_query($mysqli, "SELECT 
 										b.kode_part, 
										a.nama_part, 
										b.min_stok,
										b.max_stok,
										a.satuan 
									FROM is_part a INNER JOIN is_part_level b
									ON a.kode_part = b.kode_part 
									WHERE 
										b.kode_part='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data part : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Stok Level
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=stok_level"> Stok Level </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/part/proses.php?act=update" method="POST">
            <div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_part" value="<?php echo $data['kode_part']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_part" autocomplete="off" value="<?php echo $data['nama_part']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Min Stok</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="min_stok" name="min_stok" autocomplete="off" value="<?php echo $data['min_stok']; ?>" required>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Max Stok</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="max_stok" name="max_stok" autocomplete="off" value="<?php echo $data['max_stok']; ?>" required>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="satuan" name="satuan" autocomplete="off" value="<?php echo $data['satuan']; ?>" readonly required>
                  </div>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=stok_level" class="btn btn-default btn-reset">Batal</a>
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