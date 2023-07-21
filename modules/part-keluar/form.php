    <?php 
    
    
    if(!isset($_GET['kode'])){
        $query_id = mysqli_query($mysqli, "SELECT RIGHT(kode_request,7) as kode FROM is_part_consump
                                        ORDER BY kode_request DESC LIMIT 1")
                                        or die('Ada kesalahan pada query tampil kode_request : '.mysqli_error($mysqli));

      $count = mysqli_num_rows($query_id);

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
      $kode_transaksi = "RQ-$tahun-$buat_id";
  }
  else{
      $kode_transaksi = $_GET['kode'];
  }
  ?>

<script type="text/javascript">

	function saveData(kode_request) {
		var part = document.formPartKeluar.kode_part.value.split("|"); //$("#kode_part").val();
		
		if ( getCount('#table-temp1') <= 0 )
		{
			alert("Silahkan pilih part !!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			document.formPartKeluar.kode_part.focus();
			return;
		}
		else
		{
// 			$.post("modules/part-keluar/proses.php",
// 				{
// 					act: "save",
// 					id: kode_request,
// 				},
// 				function(result,status){  // ketika sukses menyimpan data
// 					var data = JSON.parse(result);
// 					if (data.error) {
// 						// tampilkan pesan gagal simpan data
// 						swal("Gagal!", data.error.message, "error");
// 					} else {
// 						// tampilkan data transaksi
// 						location.href = data.result.location;
// 						//var table = $('#dataTables3').DataTable(); 
// 						//table.ajax.reload( null, false );						   
// 					}
// 				});
            var formData = new FormData(document.querySelector('#formPartKeluar'));
// 			formData.append('file', $('#bukti')[0].files[0] );
    		formData.append('act', 'save');
    		formData.append('id', kode_request);
    		
    		$.ajax({
    		    url: 'modules/part-keluar/proses.php',
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
    // 	});    
		}
		
	}

	function addRow() {
		var part = document.formPartKeluar.kode_part.value.split("|"); //$("#kode_part").val();
		if (part[0] === "" || part[1] === "")
		{
			alert("Part tidak boleh kosong. !!!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			document.formPartKeluar.kode_part.focus();
			return;
		}
		var qty = document.formPartKeluar.qty.value; //$("#qty").val();
		if(qty =="" || qty == 0)
		{
			alert("Qty tidak boleh kosong. !!!");//swal("Peringatan!", "Qty tidak boleh kosong.", "warning");//
			document.formPartKeluar.qty.focus();
			return;
		}
		else
		{
			var kode_part = part[0];
			var nama_part = part[1];
			var satuan = part[2];
			$.post("modules/part-keluar/proses.php",
				{
					act: "add",
					kode_request : document.formPartKeluar.kode_request.value,
					tanggal: document.formPartKeluar.tanggal_transaksi.value,
					kode_part : kode_part,
					nama_part: nama_part,
					satuan: satuan,
					group: document.formPartKeluar.group.value,
					qty: qty 
				},
				function(result,status){  // ketika sukses menyimpan data
					var data = JSON.parse(result);
					console.log(data)
					if (data.error) {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} else {
						// tampilkan data transaksi
						//location.reload();
						//var table = $('#dataTables3').DataTable(); 
						//table.ajax.reload( null, false );		
						if(data.is_stok == 1){
							swal("Gagal!", "Qty melebihi stok yang tersedia", "error");
						} else {
							window.location.href = '?module=form_part_keluar&form=add&kode=<?= $kode_transaksi ?>'; 
						}
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
		$.post("modules/part-keluar/proses.php",
		{
			act: "del",
			id : id,
		},
		function(result,status){  // ketika sukses menyimpan data
			var data = JSON.parse(result);
			if (data.error) {
				// tampilkan pesan gagal simpan data
				swal("Gagal!", data.error.message, "error");
			} else {
				// tampilkan data transaksi
				//location.reload();
				//var table = $('#dataTables3').DataTable(); 
				//table.ajax.reload( null, false );						
				
				window.location.href = '?module=form_part_keluar&form=add&kode=<?= $kode_transaksi ?>'; 
			}
			
		});
	}
	
	function updateRow(id, qty){
		//$("table input[type='checkbox']:checked").parent().parent().remove();
		$.post("modules/part-keluar/proses.php",
		{
			act: "update",
			id : id,
			qty: qty
		},
		function(result,status){  // ketika sukses menyimpan data
			var data = JSON.parse(result);
			if (data.error) {
				// tampilkan pesan gagal simpan data
				swal("Gagal!", data.error.message, "error");
			} else {
				// tampilkan data transaksi
				//location.reload();
				//var table = $('#dataTables3').DataTable(); 
				//table.ajax.reload( null, false );						
				
				window.location.href = '?module=form_part_keluar&form=add&kode=<?= $kode_transaksi ?>'; 
			}
			
		});
	}
	
	/*function select_mr(input){
		var mr = input.value;
		$.post("modules/part-masuk/proses.php",
				{
					act: "mr",
					kode_request : mr,
					tanggal_transaksi: formPartKeluar.tanggal_transaksi.value,
				},
				function(result,status){  // ketika sukses menyimpan data
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
	}*/	


	
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
    jml = document.formPartKeluar.qty.value;
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


  <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Input Data Mutasi Keluar
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part_keluar"> Mutasi Keluar </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" name="formPartKeluar" id="formPartKeluar">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
              

              <div class="form-group">
                <label class="col-sm-2 control-label">Kode Request</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="kode_request" value="<?php echo $kode_transaksi; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_transaksi" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Group</label>
                <div class="col-sm-5">
                    <select class="form-control" name="group" id="group">
                        <option>Kitchen</option>
                        <option>Bar</option>
                        <option>Pastry</option>
                    </select>
                </div>
              </div>

			  <!--<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="button" class="btn btn-primary btn-submit" id="btnSimpan" name="btnSimpan" value="Simpan" onClick="saveData()">
					<a href="?module=part_masuk" class="btn btn-default btn-reset">Batal</a>
                </div>
			  </div>-->
              <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label">Part</label>
                <div class="col-sm-5">
                  <select class="chosen-select" id="kode_part" name="kode_part" data-placeholder="-- Pilih part --" onchange="tampil_part(this)" autocomplete="off">
                    <option value=""></option>
                    <?php
                      $query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, satuan FROM is_part ORDER BY nama_part ASC")
                                                            or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
                      while ($data_part = mysqli_fetch_assoc($query_part)) {
                        echo"<option value=\"$data_part[kode_part]|$data_part[nama_part]|$data_part[satuan]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
              <!-- <span id='stok'> 
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Part</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stok" readonly required>
                </div>
              </div>
             </span> -->

              <div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="qty" name="qty" autocomplete="off" onKeyPress="return goodchars(event,'-0123456789',this)" onkeyup="hitung_total_stok(this)&cek_qty(this)">
                </div>
              </div>

				<div class="form-group">
				    <label class="col-sm-2 control-label">Bukti</label>
				    <div class="col-sm-5">
				        <input type="file" class="form-control" name="bukti">
				    </div>
				</div>
			  <?php 
				// fungsi query untuk menampilkan data dari tabel part
				$query_approved = mysqli_query($mysqli, "SELECT count(a.is_approved) as approved FROM is_part_consump a WHERE a.kode_request='$kode_transaksi' AND a.is_approved ='1'")
												or die('Ada kesalahan: '.mysqli_error($mysqli));
				$count_approved = mysqli_fetch_row($query_approved);
				if($count_approved[0] > 0){
				echo "<p style='color:red;'>Data sudah di lakukan proses simpan.</p>";
				}else{
			  ?>
              <div class="form-group">
                <!-- <label class="col-sm-2 control-label">Total Stok</label> -->
                <div class="col-sm-offset-2 col-sm-10">
                  <!-- <input type="text" class="form-control" id="total_stok" name="total_stok" readonly required> -->

				  <input type="button" class="btn btn-primary btn-submit" value="Tambah" id="btnTambah" name="btnTambah" onClick="addRow()"><!-- -->
				  <!--<input type="button" class="btn btn-primary btn-reset" value="Hapus" onClick="removeRow()">-->
				  <input type="button" class="btn btn-primary btn-submit" value="Simpan" id="btnSimpan" name="btnSimpan" onclick='saveData("<?= $kode_transaksi ?>")'>
                </div>
              </div>
			<?php } ?>
			
            </div><!-- /.box body -->

            <!-- <div class="box-footer"> -->
			<div class="box-footer">
				<table id="table-temp1" class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th class="center">No.</th>
						<th class="center">Kode Part</th>
						<th class="center">Nama Part</th>
						<th class="center">Qty</th>
						<th class="center">Satuan</th>
						<th class="center">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT a.id, a.kode_item, b.nama_part AS nama_item, a.qty, b.satuan, a.is_approved
												FROM is_part_consump a LEFT OUTER JOIN is_part b ON a.kode_item=b.kode_part WHERE a.kode_request='$kode_transaksi' ORDER BY a.id ASC")
												or die('Ada kesalahan pada query tampil Data Part Keluar: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					if($data['is_approved'] == 1){
						$btnDelete = "";
						$readonly = "readonly";
					} else {
						$btnDelete = "<a class='btn btn-danger btn-xs' onclick='removeRow($data[id])'><i class='glyphicon glyphicon-trash'></i></a>"; 
						$readonly = "";
					}
					
					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>
						<td width='20' class='center'>$no</td>
						<td width='80' class='center'>$data[kode_item]</td>
						<td width='200'>$data[nama_item]</td>
						<td width='50' align='right'><input type='number' value='$data[qty]' class='form-control' onchange=\"updateRow($data[id], this.value)\" $readonly></td>
						<td width='50' class='center'>$data[satuan]</td>
						<td class='center' width='30'>
						$btnDelete
						</td>
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
