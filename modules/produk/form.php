<?php
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form'] == 'add') { ?>
	<!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<i class="fa fa-edit icon-title"></i> Input Produk
		</h1>
		<ol class="breadcrumb">
			<li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
			<li><a href="?module=produk"> Produk </a></li>
			<li class="active"> Tambah </li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<!-- form start -->
					<form role="form" class="form-horizontal" action="modules/produk/proses.php" method="POST"
						name="formProduk" id="formProduk">
						<!--action="modules/produk/proses.php?act=insert" method="POST" -->
						<input type="hidden" name="act" value="insert" />
						<div class="box-body">
							<?php
							$query_id = mysqli_query($mysqli, "SELECT Cast(RIGHT(kode_produk,5) as int) as kode 
								FROM is_produk
								ORDER BY kode_produk DESC LIMIT 1")
								or die('Ada kesalahan pada query tampil kode_produk : ' . mysqli_error($mysqli));

							$count = mysqli_num_rows($query_id);

							if ($count <> 0) {
								// mengambil data kode_part
								$data_id = mysqli_fetch_assoc($query_id);
								$kode = $data_id['kode'] + 1;
							} else {
								$kode = 1;
							}

							// buat kode_part
							$buat_id = str_pad($kode, 7, "0", STR_PAD_LEFT);
							$kode_produk = "P-".date('Y')."-$buat_id";
							$nama_produk = "";
							$group = "";


							$user = $_SESSION['id_user'];
							$query_temp = mysqli_query($mysqli, "SELECT  * FROM is_temp_produk where created_user = '$user' order by id desc limit 1;")
								or die('Ada kesalahan pada query tampil kode dari temp produk : ' . mysqli_error($mysqli));

							$count_temp = mysqli_num_rows($query_temp);
							if ($count_temp <> 0) {
								$data_temp = mysqli_fetch_assoc($query_temp);
								$nama_produk = $data_temp['nama_produk'];
								$group = $data_temp['group'];
							}

							?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Kode Produk</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="kode_produk"
										value="<?php echo $kode_produk; ?>" readonly required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama Produk</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="nama_produk" name="nama_produk"
										value="<?php echo $nama_produk; ?>">
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
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" class="btn btn-primary btn-submit" name="btnSimpan" value="Simpan">
									<a href="?module=produk" class="btn btn-default btn-reset">Batal</a>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label class="col-sm-2 control-label">Item</label>
								<div class="col-sm-5">
									<select class="chosen-select" id="kode_part" name="kode_part"
										data-placeholder="-- Pilih item --" autocomplete="off">
										<option value=""></option>
										<?php
										$query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, harga, satuan
								FROM is_part 
								WHERE kode_part NOT IN (SELECT kode_part FROM is_temp_produk WHERE kode_produk = '$kode_produk')
								ORDER BY kode_part ASC")
											or die('Ada kesalahan pada query tampil part: ' . mysqli_error($mysqli));
										while ($data_part = mysqli_fetch_assoc($query_part)) {
											echo "<option value=\"$data_part[kode_part]|$data_part[nama_part]|$data_part[satuan]\" harga-data=\"$data_part[harga]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Quantity</label>
								<div class="col-sm-5">
									<div class="input-group">
										<!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
										<input type="number" class="form-control money" id="qty" name="qty" step="0.01"
											autocomplete="off">
										<span id="unitSpan" class="input-group-addon"></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" class="btn btn-primary btn-submit" name="btnSimpan" value="Tambah">
									<input type="submit" class="btn btn-primary btn-submit" name="btnSimpan" value="Hapus">
								</div>
							</div>
						</div><!-- /.box body -->

						<!-- <div class="box-footer"> -->
						<div class="box-footer">
							<table id="table-temp" class="table table-bordered table-striped table-hover table-condensed">
								<thead>
									<tr>
										<th class="center">No.</th>
										<th class="center">Kode Part</th>
										<th class="center">Nama Part</th>
										<th class="center">Harga</th>
										<th class="center">Qty</th>
										<th class="center">Satuan</th>
										<th class="center">Harga Modal</th>
										<th class="center"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$grand_total = 0;
									// fungsi query untuk menampilkan data dari tabel part
									$query = mysqli_query($mysqli, "SELECT a.id,a.kode_part,a.qty,b.kode_part,b.harga, b.nama_part,b.satuan
															FROM is_temp_produk as a INNER JOIN is_part as b ON a.kode_part=b.kode_part ORDER BY a.id ASC")
										or die('Ada kesalahan pada query tampil Data Item Produk: ' . mysqli_error($mysqli));

									// tampilkan data
									while ($data = mysqli_fetch_assoc($query)) {
										$total_harga = $data['harga'] * $data['qty'];
										$grand_total += $total_harga;
										// menampilkan isi tabel dari database ke tabel di aplikasi
										echo "<tr>
									<td width='20' class='center'>$no</td>
									<td width='20' class='center'>$data[kode_part]</td>
									<td width='150'>$data[nama_part]</td>
									<td width='75' align='right'>Rp. ".number_format($data["harga"],2,',','.')."</td>
									<td width='50' align='right'>$data[qty]</td>
									<td width='50' class='center'>$data[satuan]</td>
									<td width='50' class='center'>Rp. ".number_format($data['harga'] * $data['qty'],2,',','.')."</td>
									<td class='center' width='30'><div>
										<a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm' onclick=\"removeRow('insert', 'Hapus Item', $data[id]);\" >
										<i style='color:#fff' class='glyphicon glyphicon-trash' ></i>
										</a>
									</div></td>
									</tr>";
										$no++;
									}

									?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6" align="right">Total</th>
										<th class="center"><? echo "Rp.".number_format($grand_total,2,',','.') ?></th>
										<th class="center"></th>
									</tr>
								</tfoot>
							</table>
							<!-- </div> -->
						</div><!-- /.box footer -->
					</form>
				</div><!-- /.box -->
			</div><!--/.col -->
		</div> <!-- /.row -->
	</section><!-- /.content -->

	<?php
} else if ($_GET['form'] == 'edit') { ?>
		<!-- tampilan form add data -->
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<i class="fa fa-edit icon-title"></i> Edit Produk
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
						<form role="form" class="form-horizontal" name="formProdukEdit" id="formProdukEdit"
							action="modules/produk/proses.php" method="POST">
							<!--action="modules/produk/proses.php?act=insert" method="POST" -->
							<input type="hidden" name="act" value="update" />
							<div class="box-body">
							<?php

							$kode = $_GET['kode'];

							$query = mysqli_query(
								$mysqli, "SELECT kode_produk, nama_produk, `group`
							FROM is_produk 
							WHERE kode_produk='" . $kode . "'"
							);

							$row = mysqli_fetch_assoc($query);

							?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Kode Produk</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" name="kode_produk"
											value="<?php echo $row["kode_produk"]; ?>" readonly required>
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-2 control-label">Nama Produk</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="nama_produk" name="nama_produk"
											value="<?php echo $row['nama_produk'] ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Group</label>
									<div class="col-sm-5">
										<select class="form-control" name="group" id="group">
											<?php 
											$groups = ['Kitchen', 'Bar', 'Pastry'];
											foreach ($groups as $item) {
												if ($item == $row['group']) {
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
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="Simpan"
											value="Simpan"><!--onClick="saveData()"-->
										<a href="?module=produk" class="btn btn-default btn-reset">Batal</a>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label class="col-sm-2 control-label">Item</label>
									<div class="col-sm-5">
										<select class="chosen-select" id="kode_part" name="kode_part"
											data-placeholder="-- Pilih item --" autocomplete="off">
											<option value=""></option>
											<?php
											$query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, harga, satuan 
											FROM is_part 
											WHERE kode_part NOT IN (SELECT kode_part FROM is_produk_part WHERE kode_produk = '$kode')
											ORDER BY kode_part ASC")
												or die('Ada kesalahan pada query tampil part: ' . mysqli_error($mysqli));
											while ($data_part = mysqli_fetch_assoc($query_part)) {
												echo "<option value=\"$data_part[kode_part]|$data_part[nama_part]|$data_part[satuan]\" harga-data=\"$data_part[harga]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Quantity</label>
									<div class="col-sm-5">
										<div class="input-group">
											<!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
											<input type="number" class="form-control money" id="qty" name="qty" step="0.01"
												autocomplete="off">
											<span id="unitSpan" class="input-group-addon"></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" class="btn btn-primary btn-submit" name="btnSimpan" value="Tambah">
										<input type="submit" class="btn btn-primary btn-submit" name="btnSimpan" value="Hapus">
									</div>
								</div>
							</div><!-- /.box body -->

							<!-- <div class="box-footer"> -->
							<div class="box-footer">
								<table id="table-temp" class="table table-bordered table-striped table-hover table-condensed">
									<thead>
										<tr>
											<th class="center">No.</th>
											<th class="center">Kode Part</th>
											<th class="center">Nama Part</th>
											<th class="center">Harga</th>
											<th class="center">Qty</th>
											<th class="center">Satuan</th>
											<th class="center">Harga Modal</th>
											<th class="center"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$grand_total = 0;
										// fungsi query untuk menampilkan data dari tabel part
										$query = mysqli_query($mysqli, "SELECT a.id,a.kode_part,a.qty,b.kode_part,b.harga, b.nama_part,b.satuan
															FROM is_produk_part as a INNER JOIN is_part as b ON a.kode_part=b.kode_part ORDER BY a.id ASC")
											or die('Ada kesalahan pada query tampil Data Item Produk: ' . mysqli_error($mysqli));

										// tampilkan data
										while ($data = mysqli_fetch_assoc($query)) {
											$total_harga = $data['harga'] * $data['qty'];
											$grand_total += $total_harga;
											// menampilkan isi tabel dari database ke tabel di aplikasi
											echo "<tr>
											<td width='20' class='center'>$no</td>
											<td width='20' class='center'>$data[kode_part]</td>
											<td width='150'>$data[nama_part]</td>
											<td width='75' align='right'>Rp. ".number_format($data["harga"],2,',','.')."</td>
											<td width='50' align='right'>$data[qty]</td>
											<td width='50' class='center'>$data[satuan]</td>
											<td width='50' class='center'>Rp. ".number_format($data['harga'] * $data['qty'],2,',','.')."</td>
											<td class='center' width='30'><div>
												<a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm' onclick=\"removeRow('update', 'Hapus Item', $data[id]);\" >
												<i style='color:#fff' class='glyphicon glyphicon-trash' ></i>
												</a>
											</div></td>
											</tr>";
											$no++;
										}

										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6" align="right">Total</th>
											<th class="center"><? echo "Rp. ".number_format($grand_total,2,',','.') ?></th>
											<th class="center"></th>
										</tr>
									</tfoot>
								</table>
								<!-- </div> -->
							</div><!-- /.box footer -->

						</form>
					</div><!-- /.box -->
				</div><!--/.col -->
			</div> <!-- /.row -->
		</section><!-- /.content -->
		<?php
}
?>
<script>
	function removeRow(act, btnSimpanValue, id) {
		//$("table input[type='checkbox']:checked").parent().parent().remove();
		$.post("modules/produk/proses.php",
			{
				act: act,
				btnSimpan: btnSimpanValue,
				id: id,
			},
			function (result, status) {  // ketika sukses menyimpan data
				//alert(result);
				var data = JSON.parse(result);
				if (data.error) {
					// tampilkan pesan gagal simpan data
					swal("Gagal!", data.error.message, "error");
				} else {
					// tampilkan data
					location.reload();
				}
			});
	}
	$(document).ready(function () {
		$('.btn-submit').on('click', function (e) {
			let action = $(this).val();
			if (action === "Tambah") {
				if ($('#kode_part').val().length <= 0) {
					swal("Silahkan pilih Item Barang !!");
					e.preventDefault();
				} else if ($('#qty').val() === "") {
					swal("Silahkan quantity Item Barang !!");
					e.preventDefault();
				}
				return;
			} else if (action === "Simpan") {
				if ($('#nama_produk').val().trim().length <= 0) {
					swal("Silahkan isi nama produk !!");
					e.preventDefault();
				}
				return;
			}
			return;
		});

		$('#kode_part').on('change', function() {
			$('#unitSpan').html($(this).val().split('|')[2]);
		})
	});
</script>