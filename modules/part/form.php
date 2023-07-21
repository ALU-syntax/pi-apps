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
      <li><a href="?module=part"> Item </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/part/proses.php" method="POST">
            <input type="hidden"  name="act" value="insert" />
			<div class="box-body">
              <?php  
              // fungsi untuk membuat id transaksi
              $query_id = mysqli_query($mysqli, "SELECT Cast(RIGHT(kode_part,5) as int) as kode FROM is_part
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
              $buat_id   = str_pad($kode, 5, "0", STR_PAD_LEFT);
              $kode_part = "I$buat_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Item</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_part" value="<?php echo $kode_part; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Supplier</label>
                <div class="col-sm-5">
                  <select class="chosen-select"  id="kode_suplier" name="kode_suplier" data-placeholder="-- Pilih Suplier --" autocomplete="off" required>
                    <option value=""></option>
                    <?php
                        $query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier ORDER BY kode ASC")
                                        or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
                        while ($data_part = mysqli_fetch_assoc($query_part)) {
                          echo"<option value=\"$data_part[kode]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
                        }
                        
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Item</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_part" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Group</label>
                <div class="col-sm-5">
                  <select class="form-control" name="group" id="group">
										<?php 
										$groups = ['Kitchen', 'Bar', 'Pastry'];
										foreach ($groups as $item) {
											if ($item == $group) {
												echo "<option selected>$item</option>";
											} else {	
												echo "<option>$item</option>";
											}
										}
										?>
									</select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-5">
                 <select class="form-control" name="kategori" id="kategori">
										<?php 
										$groups = ['Bahan Baku', 'Packaging', 'Others'];
										foreach ($groups as $item) {
											if ($item == $group) {
												echo "<option selected>$item</option>";
											} else {	
												echo "<option>$item</option>";
											}
										}
										?>
									</select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value=""></option>
					<option value="Btl">Ekor</option>
                    <option value="Btl">Botol</option>
                    <option value="Box">Box</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Set">Set</option>
                    <option value="Strip">Strip</option>
                    <option value="Tube">Tube</option>
                    <option value="Unit">Unit</option>
					<option value="Sheet">Sheet</option>
					<option value="Meter">Meter</option>
					<option value="Kg">Kg</option>
					<option value="Klg">Klg</option>
					<option value="Tbg">Tbg</option>
					<option value="Roll">Roll</option>
                    <option value="Galon">Galon</option>
					<option value="Liter">Liter</option>
					<option value="Zak">Zak</option>
					<option value="Drum">Drum</option>
					<option value="Pail">Pail</option>
					<option value="Pack">Pack</option>
					<option value="Can">Can</option>
					<option value="Ktn">Karton</option>
					<option value="Blk">Block</option>
					<option value="Bal">Bal</option>
					<option value="Ikt">Ikat</option>
					<option value="Dus">Dus</option>
					<option value="Pch">Pouch</option>
					<option value="Jrg">Jerigen</option>
					<option value="Bks">Bks</option>
					<option value="Tab">Tabung</option>
					<option value="Rim">Rim</option>
					<option value="Grm">Gram</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Harga</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="text" class="form-control" id="harga" name="harga" autocomplete="off" required>
                  </div>
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
// jika form edit data yang dipilih
// isset : cek data ada / tidak
elseif ($_GET['form']=='edit') { 
  if (isset($_GET['id'])) {
      // fungsi query untuk menampilkan data dari tabel part
      // $query = mysqli_query($mysqli, "SELECT kode_part,kode_suplier,nama_part,`group`,kategori,satuan ,stok,stok_level FROM is_part WHERE kode_part='$_GET[id]'") 
      $query = mysqli_query($mysqli, "SELECT kode_part,kode_suplier, suplier.nama as nama_suplier,nama_part,is_part.group,kategori,satuan ,stok,stok_level,harga FROM is_part LEFT JOIN is_suplier as suplier ON suplier.kode = is_part.kode_suplier WHERE kode_part='$_GET[id]'") 
                                      or die('Ada kesalahan pada query tampil Data part : '.mysqli_error($mysqli));
      $data  = mysqli_fetch_assoc($query);
    }
?>
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Ubah Part
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
          <form role="form" class="form-horizontal" action="modules/part/proses.php" method="POST">
            <input type="hidden"  name="act" value="update" />
			<div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Item</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_part" value="<?php echo $data['kode_part']; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Supplier</label>
                <div class="col-sm-5">
                  <select class="chosen-select"  id="kode_suplier" name="kode_suplier" data-placeholder="-- Pilih Suplier --" autocomplete="off" required>
                    
                  <option value="<?php echo $data['kode_suplier']; ?>"><?php echo $data['kode_suplier']." | ". $data['nama_suplier']; ?></option>
                    <?php
                        $query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier ORDER BY kode ASC")
                                        or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
                        while ($data_part = mysqli_fetch_assoc($query_part)) {
                          echo"<option value=\"$data_part[kode]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
                        }
                        
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Item</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_part" autocomplete="off" value="<?php echo $data['nama_part']; ?>" required>
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
                <label class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="kategori" name="kategori" autocomplete="off" value="<?php echo $data['kategori']; ?>" required>
                  </div>
                </div>
              </div>
			  
			        <div class="form-group">
                <label class="col-sm-2 control-label">Stok awal</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="stok" name="stok" autocomplete="off" value="<?php echo $data['stok']; ?>" required>
                  </div>
                </div>
              </div>
			  
			        <div class="form-group">
                <label class="col-sm-2 control-label">Stok Level</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <!--<span class="input-group-addon">Rp.</span>-->
                    <input type="text" class="form-control" id="stok_level" name="stok_level" autocomplete="off" value="<?php echo $data['stok_level']; ?>" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Satuan</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="satuan" data-placeholder="-- Pilih --" autocomplete="off" required>
                    <option value="<?php echo $data['satuan']; ?>"><?php echo $data['satuan']; ?></option>
					<option value="Btl">Ekor</option>
                    <option value="Btl">Btl</option>
                    <option value="Box">Box</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Set">Set</option>
                    <option value="Strip">Strip</option>
                    <option value="Tube">Tube</option>
                    <option value="Unit">Unit</option>
					<option value="Sheet">Sheet</option>
					<option value="Meter">Meter</option>
					<option value="Kg">Kg</option>
					<option value="Klg">Klg</option>
					<option value="Tbg">Tbg</option>
					<option value="Roll">Roll</option>
                    <option value="Galon">Galon</option>
					<option value="Liter">Liter</option>
					<option value="Zak">Zak</option>
					<option value="Drum">Drum</option>
					<option value="Pail">Pail</option>
					<option value="Pack">Pack</option>
					<option value="Can">Can</option>
					<option value="Ktn">Karton</option>
					<option value="Blk">Block</option>
					<option value="Bal">Bal</option>
					<option value="Ikt">Ikat</option>
					<option value="Dus">Dus</option>
					<option value="Pch">Pouch</option>
					<option value="Jrg">Jerigen</option>
					<option value="Bks">Bks</option>
					<option value="Tab">Tabung</option>
					<option value="Rim">Rim</option>
					<option value="Grm">Gram</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Harga</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="text" class="form-control" id="harga" name="harga" autocomplete="off" value='<?php echo $data['harga']; ?>'required>
                  </div>
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