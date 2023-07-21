
<!-- tampilan form add data -->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<i class="fa fa-edit icon-title"></i> Produk Item
	</h1>
	<ol class="breadcrumb">
<li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
		<li><a href="?module=produk"> Produk </a></li>
		<li class="active"> Ubah </li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row"> 
		<div class="col-md-12">
			<div class="box box-primary">
				<!-- form start -->
				<form role="form" class="form-horizontal" name="formProdukEdit" id="formProdukEdit" action="modules/produk/proses.php" method="POST">  <!--action="modules/produk/proses.php?act=insert" method="POST" --> 
			<input type="hidden"  name="act" value="update" />
					<div class="box-body">
			<?php  
			
					$kode = $_GET['kode'];
				
				$query = mysqli_query($mysqli, "SELECT kode_produk, nama_produk
					FROM is_produk 
					WHERE kode_produk='" . $kode . "'"
				);
				
				$row = mysqli_fetch_assoc($query);
				
			?>
						
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Produk</label>
				<div class="col-sm-5">
					<input type="hidden" name="kode_produk" value="<?php echo $row["kode_produk"]; ?>">
					<input type="text" class="form-control" name="nama_produk" value="<?php echo $row['nama_produk'] ?>" readonly>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Item</label>
				<div class="col-sm-5">
					<select class="chosen-select" id="item" name="item" data-placeholder="-- Pilih Item --" onchange="select_po(this)" autocomplete="off">
					
					<?php
						$query_part = mysqli_query($mysqli, "SELECT * 
							FROM is_part 
							WHERE trans.kode_request IS NULL") or die('Ada kesalah pada query tampil suplier: ' . mysqli_error($mysqli));
						echo "<option value=''></option>";
						while ($data_part = mysqli_fetch_assoc($query_part)) {
							$value = $data_part['kode'];
							$select = '';
							if($value == $kode_suplier) $select = '  selected';
							echo "<option value='$value' ".$select." > $data_part[nama]</option>";
						}
					?>
					</select>
				</div>
			</div>
			

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="simpan" value="Simpan"><!--onClick="saveData()"-->
					<a href="?module=produk" class="btn btn-default btn-reset">Batal</a>
				</div>
			</div>
						<hr>
			

					</div><!-- /.box body -->
			
				</form>
			</div><!-- /.box -->
		</div><!--/.col -->
	</div>   <!-- /.row -->
</section><!-- /.content -->