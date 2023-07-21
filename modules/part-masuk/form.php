<script type="text/javascript">
	/*function saveData() {
		if ( getCount('#table-temp-recs') <= 0 )
		{
			alert("Silahkan pilih MR !!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			return;
		}
		else
		{
			$.post("modules/part-masuk/proses.php",
				{
					act: "save",
					kode_transaksi:formPartMasuk.kode_transaksi.value,
					kode_request:formPartMasuk.kode_request.value,
					no_sj : formPartMasuk.no_sj.value
				},
				function(result,status){  // ketika sukses menyimpan data
				//alert(result);
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
	}*/
	
	$(document).ready(function(){
	    $('#formPartMasuk').on('submit', function(e){
    	    e.preventDefault();
    	    
    	    if ( getCount('#table-temp-recs') <= 0 ){
    			swal("Silahkan pilih MR !!");
    			return;
    		}
    		
    		var formData = new FormData(this);
    		formData.append('act', 'save');
    		
    		$.ajax({
    		    url: 'modules/part-masuk/proses.php',
    			type: "POST",
    			cache: false,
    			data: formData, 
    			contentType: false,
    			processData: false,
    			success: function(data){
    				var data = JSON.parse(data);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.href = data.result.location;
					}
    			}
    		});
    	});    
    	
    	$('#formPartMasukEdit').on('submit', function(e){
    	    e.preventDefault();
    	    
    		var formData = new FormData(this);
    		formData.append('act', 'update_all');
    		
    		$.ajax({
    		    url: 'modules/part-masuk/proses.php',
    			type: "POST",
    			cache: false,
    			data: formData, 
    			contentType: false,
    			processData: false,
    			success: function(data){
    				var data = JSON.parse(data);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.href = data.result.location;
					}
    			}
    		});
    	});    
    	
    	
	});
	
	function updateRow(input, field, id) {
		
		 var old = input.getAttribute('data-old');
		 var val = input.value;
		 var error = false;
		 if(+old < +val)
		 {
			 error = true;
			swal("Gagal!", "Qty tidak boleh lebih besar dari outstanding ", "error");
		 }
		 if(val <= 0)
		 {
			 error = true;
			swal("Gagal!", "Qty tidak boleh kurang dari 0 ", "error");
		 }
		 if(error) 
		 {
			 input.value = +old;
			 return;
		 }
		$.post("modules/part-masuk/proses.php",
			{
				act: "update",
				id : id,
				table : "is_temp_in",
				field : field,
				value : val
			},
			function(result,status){  // ketika sukses menyimpan data
				//alert(result);
				var data = JSON.parse(result);
				if (data.error) {
					// tampilkan pesan gagal simpan data
					swal("Gagal!", data.error.message, "error");
				} else {
					// tampilkan data transaksi
					//location.reload();
					//var table = $('#dataTables3').DataTable(); 
					//table.ajax.reload( null, false );						   
				}
			});	
	}
		
	function addRow() {
		var part = document.formPartMasuk.kode_part.value.split("|"); //$("#kode_part").val();
		if (part[0] === "" || part[1] === "")
		{
			alert("Part tidak boleh kosong. !!!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			document.formPartMasuk.kode_part.focus();
			return;
		}
		var qty = document.formPartMasuk.qty.value; //$("#qty").val();
		if(qty =="" || qty == 0)
		{
			alert("Qty tidak boleh kosong. !!!");//swal("Peringatan!", "Qty tidak boleh kosong.", "warning");//
			document.formPartMasuk.qty.focus();
			return;
		}
		else
		{
			var kode_part = part[0];
			var nama_part = part[1];
			$.post("modules/part-masuk/proses.php",
				{
					act: "add",
					kode_transaksi : document.formPartMasuk.kode_transaksi.value,
					tanggal_transaksi: document.formPartMasuk.tanggal_transaksi.value,
					kode_part: kode_part,
					nama_part: nama_part,
					qty: qty 
				},
				function(result,status){  // ketika sukses menyimpan data
					//alert(result);
					var data = JSON.parse(result);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.reload();
						//var table = $('#dataTables3').DataTable(); 
						//table.ajax.reload( null, false );						   
					}
					
				});
		}
		/* // add datatable manualy and reset/focus field
		var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + part[0] + "</td><td>" + part[1] + "</td><td>" + qty +"</td></tr>"  ;
		$("#dataTables3 tbody").append(markup);
		
		document.formPartMasuk.qty.value = "";
		$('#kode_part').find('option:first-child').prop('selected', true).end().trigger('chosen:updated');
		$("#kode_part").focus();
		*/
	}
	
	function removeRow(id){
		//$("table input[type='checkbox']:checked").parent().parent().remove();
		$.post("modules/part-masuk/proses.php",
				{
					act: "del",
					id : id,
				},
				function(result,status){  // ketika sukses menyimpan data
					//alert(result);
					var data = JSON.parse(result);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.reload();
						//var table = $('#dataTables3').DataTable(); 
						//table.ajax.reload( null, false );						   
					}
					
				});
	}
	
	function removeEditRow(id){
	    $.post("modules/part-masuk/proses.php",
		{
			act: "del_update",
			id : id,
		},
		function(result,status){  // ketika sukses menyimpan data
			//alert(result);
			var data = JSON.parse(result);
			if (data.error) {
				// tampilkan pesan gagal simpan data
				swal("Gagal!", data.error.message, "error");
			} else {
				// tampilkan data transaksi
				location.reload();
				//var table = $('#dataTables3').DataTable(); 
				//table.ajax.reload( null, false );						   
			}
			
		});
	    
	}
	
	function get_po(input){
		var tipe = input.value;
		$.post("modules/part-masuk/PO.php",
				{tipe : tipe},
				function(result,status){  
									if(result)
										$("#kode_request").prop("disabled", false);
									else
										$("#kode_request").prop("disabled", true);
									
									$("#kode_request").html(result).trigger("chosen:updated");
				});	}	
	
	function select_po(input){
	    var kode_suplier = input.value;
	    
	    $.post('modules/part-masuk/proses.php',
	        {
	            act: 'select_po',
	            kode_suplier: kode_suplier
	        },
	        function(result, status){
	            //var data = JSON.parse(result);
	            //$('#kode_request').html(result);
	            
	            $("#kode_request").html(result).trigger("chosen:updated");
	        }
	    
	    )
	}
	
	function select_mr(input){
		var mr = input.value;
		$.post("modules/part-masuk/proses.php",
				{
					act: "select",
					kode_request : mr,
					tanggal_transaksi: formPartMasuk.tanggal_transaksi.value,
					kode_suplier: formPartMasuk.suplier.value
					
				},
				function(result,status){  // ketika sukses menyimpan data
				//alert(result);
					var data = JSON.parse(result);
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						location.reload();
						//var table = $('#dataTables3').DataTable(); 
						//table.ajax.reload( null, false );						   
					}
					
				});	}	

	function tampil_part(input){
		var part = input.value.split("|");
		$("#qty").focus();
		/*
		$.post("modules/part-masuk/part.php", {
		  dataidpart: part,
		}, function(response) {      
		  $('#stok').html(response);
		  alert(response);
		  document.formPartMasuk.qty.focus();
		});*/
	}

	function cek_qty(input) {
		jml = input.value;
		var jumlah = eval(jml);
		if(jumlah == 0){
		  alert('Quantity Tidak Boleh Nol !');
		  input.value = input.value.substring(0,input.value.length-1);
		}
	}

	function hitung_total_stok() {
	   /* bil1 = document.formPartMasuk.stok.value;
		bil2 = document.formPartMasuk.qty.value;

		if (bil2 == "") {
		  var hasil = "";
		}
		else {
		  var hasil = eval(bil1) + eval(bil2);
		}

		document.formPartMasuk.total_stok.value = (hasil); */
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
      <i class="fa fa-edit icon-title"></i> Input Penerimaan Item
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part_masuk"> Mutasi Part </a></li>
      <li class="active"> Penerimaan </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" name="formPartMasuk" id="formPartMasuk">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
				<?php  
					// fungsi untuk membuat kode transaksi
					$query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_transaksi,7) as kode FROM is_part_trans where kode_transaksi like 'TR-%'
												ORDER BY kode_transaksi DESC LIMIT 1")
												or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

					$count = mysqli_num_rows($query_id);

					// fungsi untuk membuat kode transaksi
					$query_mr = mysqli_query($mysqli, "SELECT 
													a.part_req_id, 
													b.kode_request, 
													a.kode_suplier,
													a.tipe
												FROM is_temp_in a 
												INNER JOIN is_part_req b 
												ON a.part_req_id = b.id 
												ORDER BY a.part_req_id DESC LIMIT 1") 
												or die('Ada kesalahan pada query tampil kode_request : '.mysqli_error($mysqli));
					$tipe = '';
					$count_mr = mysqli_num_rows($query_mr);
					if ($count_mr > 0) {
						// mengambil data kode transaksi
						$data_mr = mysqli_fetch_assoc($query_mr);
						$tipe =  $data_mr['tipe'];
						$kode_request = $data_mr['kode_request'];
						$kode_suplier = $data_mr['kode_suplier'];
					}

					if ($count > 0) {
						// mengambil data kode transaksi
						$data_id = mysqli_fetch_assoc($query_id);
						$kode    = $data_id['kode']+1;
					} else {
						$kode = 1;
					}

					// buat kode_transaksi
					$tahun          = date("Y");
					$buat_id        = str_pad($kode, 7, "0", STR_PAD_LEFT);
					$kode_transaksi = "TR-$tahun-$buat_id";
					
				?>

				<div class="form-group">
					<label class="col-sm-2 control-label">Kode Transaksi</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>" readonly required>
					</div>
				</div>
				,<!--
				<div class="form-group">
					<label class="col-sm-2 control-label">Tipe</label>
					<div class="col-sm-4">
					<select class="form-control" name="tipe" id="tipe" data-placeholder="-- Pilih --" autocomplete="off"  >
						<option value="" ></option>
						<option value="CASH" >CASH</option>
						<option value="PO" >PO</option>
					</select>	
				</div>	
				</div>			
				-->
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Suplier</label>
					<div class="col-sm-5">
						<select class="chosen-select" id="suplier" name="suplier" data-placeholder="-- Pilih Suplier --" onchange="select_po(this)" autocomplete="off">
						
						<?php
							//$query_part = mysqli_query($mysqli, "SELECT kode, nama
							//									FROM is_suplier")
							//									or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
							
							$query_part = mysqli_query($mysqli, "SELECT distinct req.kode_suplier AS kode, req.suplier AS nama FROM is_part_req req LEFT OUTER JOIN is_part_trans trans ON req.kode_request=trans.kode_request WHERE trans.kode_request IS NULL") or die('Ada kesalah pada query tampil suplier: ' . mysqli_error($mysqli));
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
					<label class="col-sm-2 control-label">No. PO</label>
					<div class="col-sm-5">
						<select class="chosen-select" id="kode_request" name="kode_request" data-placeholder="-- Pilih PO --" onchange="select_mr(this)" autocomplete="off">
						
						<?php
							$query_part = mysqli_query($mysqli, "SELECT distinct kode_request 
																FROM is_part_req 
																WHERE status = 1
																ORDER BY kode_request ASC")
																or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
							echo "<option value=''  > </option>";
							while ($data_part = mysqli_fetch_assoc($query_part)) {
								$value = $data_part['kode_request'];
								$select = '';
								if($value == $kode_request) $select = '  selected';
								echo "<option value='$value' ".$select." > $data_part[kode_request]</option>";
							}
						?>
						</select>
					</div>
				</div>
              
				<div class="form-group">
					<label class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-5">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_transaksi" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
					</div>
				</div>
				
							
				<div class="form-group">
					<label class="col-sm-2 control-label">Surat Jalan</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" name="no_sj"  >
					</div>
				</div>
				
				<div class="form-group">
				    <label class="col-sm-2 control-label">Bukti</label>
				    <div class="col-sm-5">
				        <input type="file" class="form-control" name="bukti">
				    </div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="btnSimpan" value="Simpan"><!--onClick="saveData()"-->
						<a href="?module=part_masuk" class="btn btn-default btn-reset">Batal</a>
					</div>
				</div>
              <hr>
			  
              <!--<div class="form-group">
                <label class="col-sm-2 control-label">Part</label>
                <div class="col-sm-5">
                  <select class="chosen-select" id="kode_part" name="kode_part" data-placeholder="-- Pilih part --" onchange="tampil_part(this)" autocomplete="off">
                    <option value=""></option>
                    <?php /*
                      $query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part FROM is_part ORDER BY nama_part ASC")
                                                            or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
                      while ($data_part = mysqli_fetch_assoc($query_part)) {
                        echo"<option value=\"$data_part[kode_part]|$data_part[nama_part]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
                      }*/
                    ?>
                  </select>
                </div>
              </div>
              -->
             
			  <!-- <span id='stok'> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stok" readonly required>
                </div>
              </div>
             </span> -->

              <!--<div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="qty" name="qty" autocomplete="off" onKeyPress="return goodchars(event,'-0123456789',this)" onkeyup="hitung_total_stok(this)&cek_qty(this)">
                </div>
              </div>
				-->
              
			  <!--<div class="form-group">
                <label class="col-sm-2 control-label">Total Stok</label>
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="text" class="form-control" id="total_stok" name="total_stok" readonly required> 
				  <input type="button" class="btn btn-primary btn-submit" value="Tambah" id="btnTambah" name="btnTambah" onClick="addRow()">
				  <input type="button" class="btn btn-primary btn-reset" value="Hapus" onClick="removeRow()">
                </div>
              </div> -->

            </div><!-- /.box body -->

            <!-- <div class="box-footer"> -->
			<div class="box-footer">
				<table id="table-temp-recs" class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th class="center">No.</th>
						<th class="center">Item</th>
						<th class="center">Nama Part</th>
						<th class="center">Qty</th>
						<th class="center">Satuan</th>
						<th class="center">Harga</th>
						<th class="center"></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$created_user    	= $_SESSION['id_user'];
				
				$query = mysqli_query($mysqli, "SELECT a.id,a.kode_part,a.qty,a.nama,a.satuan, a.harga, a.tipe
												FROM is_temp_in as a WHERE a.created_user='" . $created_user . "' ORDER BY a.id ASC")
												or die('Ada kesalahan pada query tampil Data Part Masuk: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					// menampilkan isi tabel dari database ke tabel di aplikasi
					$disable = $data['tipe'] == "PO" ? 'readonly': '';
					echo "<tr>
						<td width='10' class='center'>$no</td>
						<td width='50' class='center'>$data[kode_part]</td>
						<td width='200'>$data[nama]</td>
						<td class='center' width='20'>
							<input type='text' data-old='$data[qty]'  class='form-control right' style='width:100%' value='$data[qty]' onKeyPress=\"return goodchars(event,'.0123456789',this)\" onchange=\"updateRow(this, 'qty',$data[id])\">
						</td>
						<td width='20' class='center'>$data[satuan]</td>
						<td class='center' width='20'>
							<input $disable type='text' id='harga_beli' class='form-control right' style='width:100%' value='$data[harga]'  onKeyPress=\"return goodchars(event,'.0123456789',this)\" onchange=\"updateRow(this, 'harga',$data[id])\">
						</td>
						<td class='center' width='20'><div>
							<a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm' onclick= 'removeRow($data[id])' >
							<i style='color:#fff' class='glyphicon glyphicon-trash' ></i>
							</a>
						</div></td>
						</tr>";
					$no++;
				}
				?>
				</tbody>
				</table>
			  <!-- </div> -->            
			</div><!-- /.box footer -->
				
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
else if ($_GET['form']=='edit') { ?> 
  <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Edit Penerimaan Item
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part_masuk"> Mutasi Part </a></li>
      <li class="active"> Penerimaan </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" name="formPartMasukEdit" id="formPartMasukEdit">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
				<?php  
				
				    $kode = $_GET['kode'];
					
					$query = mysqli_query($mysqli, "SELECT kode_transaksi, kode_request, tanggal_transaksi, no_sj FROM is_part_trans WHERE kode_transaksi='" . $kode . "'");
					
					$row = mysqli_fetch_assoc($query);
					
                ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Kode Transaksi</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" name="kode_transaksi" value="<?php echo $row["kode_transaksi"]; ?>" readonly required>
					</div>
				</div>
			
				<!--<div class="form-group">
					<label class="col-sm-2 control-label">Suplier</label>
					<div class="col-sm-5">
					    <input type="text" class="form-control" value="<?php echo $row['suplier']; ?>" readonly required>
					</div>
				</div>-->

				<div class="form-group">
					<label class="col-sm-2 control-label">No. PO</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" value="<?php echo $row['kode_request'] ?>" readonly required>
					</div>
				</div>
              
				<div class="form-group">
					<label class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-5">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_transaksi" autocomplete="off" value="<?php echo date("d-m-Y", strtotime($row['tanggal_transaksi'])); ?>" required>
					</div>
				</div>
				
							
				<div class="form-group">
					<label class="col-sm-2 control-label">Surat Jalan</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" name="no_sj" value="<?php echo $row['no_sj'] ?>">
					</div>
				</div>
				
				<div class="form-group">
				    <label class="col-sm-2 control-label">Bukti</label>
				    <div class="col-sm-5">
				        <input type="file" class="form-control" name="bukti">
				    </div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="btnSimpan" value="Simpan"><!--onClick="saveData()"-->
						<a href="?module=part_masuk" class="btn btn-default btn-reset">Batal</a>
					</div>
				</div>
              <hr>
			  
              <!--<div class="form-group">
                <label class="col-sm-2 control-label">Part</label>
                <div class="col-sm-5">
                  <select class="chosen-select" id="kode_part" name="kode_part" data-placeholder="-- Pilih part --" onchange="tampil_part(this)" autocomplete="off">
                    <option value=""></option>
                    <?php /*
                      $query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part FROM is_part ORDER BY nama_part ASC")
                                                            or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
                      while ($data_part = mysqli_fetch_assoc($query_part)) {
                        echo"<option value=\"$data_part[kode_part]|$data_part[nama_part]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
                      }*/
                    ?>
                  </select>
                </div>
              </div>
              -->
             
			  <!-- <span id='stok'> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stok" readonly required>
                </div>
              </div>
             </span> -->

              <!--<div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="qty" name="qty" autocomplete="off" onKeyPress="return goodchars(event,'-0123456789',this)" onkeyup="hitung_total_stok(this)&cek_qty(this)">
                </div>
              </div>
				-->
              
			  <!--<div class="form-group">
                <label class="col-sm-2 control-label">Total Stok</label>
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="text" class="form-control" id="total_stok" name="total_stok" readonly required> 
				  <input type="button" class="btn btn-primary btn-submit" value="Tambah" id="btnTambah" name="btnTambah" onClick="addRow()">
				  <input type="button" class="btn btn-primary btn-reset" value="Hapus" onClick="removeRow()">
                </div>
              </div> -->

            </div><!-- /.box body -->

            <!-- <div class="box-footer"> -->
			<div class="box-footer">
				<table id="table-temp-recs" class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th class="center">No.</th>
						<th class="center">Item</th>
						<th class="center">Nama Part</th>
						<th class="center">Qty</th>
						<th class="center">Satuan</th>
						<th class="center">Harga</th>
						<th class="center"></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT id, kode_part, nama, qty, satuan, harga FROM is_part_trans WHERE kode_transaksi='" . $kode . "'")
												or die('Ada kesalahan pada query tampil Data Part Masuk: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>
						<td width='10' class='center'>$no</td>
						<td width='50' class='center'>$data[kode_part]</td>
						<td width='200'>$data[nama]</td>
						<td width='20'>$data[qty]</td>
						<td width='20' class='center'>$data[satuan]</td>
						<td class='center' width='20'>$data[harga]</td>
						<td class='center' width='20'></td>
						</tr>";
					$no++;
				}
				?>
				</tbody>
				</table>
			  <!-- </div> -->            
			</div><!-- /.box footer -->
				
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>