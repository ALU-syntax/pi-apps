<script type="text/javascript">

	function saveData() {
		if ( getCount('#table-temp') <= 0 )
		{
			swal("Silahkan pilih Item Barang !!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
			//document.frmPartReq.kode_part.focus();
			return;
		}
		else
		{
		    
		    $('#frmPartReq').trigger('submit');
		    return false;
		    
		    //frmPartReq.submit();
		    
		    
			/*$.post("modules/part-request/proses.php",
				{
					act: "save",
					kode_request : frmPartReq.no_po.value,
					tipe : frmPartReq.tipe.value,
					tanggal: frmPartReq.tanggal.value,
					jatuh_tempo : frmPartReq.jatuh_tempo.value,
          		  	ket:frmPartReq.descr.value
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
			});*/
		}
		
	}
	
	$(document).ready(function(){
	    $('#frmPartReq').on('submit', function(e){
    	    e.preventDefault();
    	    
    	    if ( getCount('#table-temp') <= 0 ){
    			swal("Silahkan pilih Item Barang !!");
    			return;
    		}
    		
    		var formData = new FormData(this);
    		formData.append('act', 'save');
    		
    		$.ajax({
    		    url: 'modules/part-request/proses.php',
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
    	
    	$('#frmPartReqEdit').on('submit', function(e){
    	    e.preventDefault();
    	    
    		var formData = new FormData(this);
    		formData.append('act', 'update');
    		
    		$.ajax({
    		    url: 'modules/part-request/proses.php',
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
    	
    	Date.prototype.addDays = function (num) {
            var value = this.valueOf();
            value += 86400000 * num;
            return new Date(value);
        }

    	$('#btnTambah').on('click', function(){//function addRow() {
    		var part = frmPartReqDetail.kode_part.value.split("|"); //$("#kode_part").val();
        	var suplier = frmPartReq.kode_suplier.value.split("|"); //$("#kode_part").val();
        	var satuan = frmPartReqDetail.unit.value;
        	var price = frmPartReqDetail.price.value;
    		if (frmPartReq.tipe.value == "" )
    		{
    			swal("Tipe PO tidak boleh kosong. !!!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
    			frmPartReq.tipe.focus();
    			return;
    		}
    		if (frmPartReq.no_po.value == "" )
    		{
    			swal("Nomor MR tidak boleh kosong. !!!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
    			frmPartReq.no_po.focus();
    			return;
    		}
    
    		if (part[0] === "" || part[1] === "")
    		{
    			swal("Part tidak boleh kosong. !!!");//swal("Peringatan!", "Part tidak boleh kosong.", "warning");//
    			frmPartReqDetail.kode_part.focus();
    			return;
    		}
    		var qty = frmPartReqDetail.qty.value; //$("#qty").val();
    		if(qty =="" || qty == 0)
    		{
    			swal("Qty tidak boleh kosong. !!!");//swal("Peringatan!", "Qty tidak boleh kosong.", "warning");//
    			frmPartReqDetail.qty.focus();
    			return;
    		}
    		else
    		{
    		    
    		    //alert(frmPartReq.status_bayar.value);
    		    //return;
    		    var diskon = $('#diskon').val() == '' ? 0 : $('#diskon').val();
    		    var pajak = $('#chk_pajak').is(':checked') ? 0.11 : 0;
    		    var jumlah = $('#jumlah').val();
    		    
    		    
    			$.post("modules/part-request/proses.php",{
    				act: "add",
    				kode_request : frmPartReq.no_po.value,
              	  	tipe : frmPartReq.tipe.value,
              	  	//status_bayar: frmPartReq.status_bayar.value,
    				ket : frmPartReq.descr.value,
    				tanggal: frmPartReq.tanggal.value,
    				jatuh_tempo: frmPartReq.jatuh_tempo.value,
              	  	kode_suplier: suplier[0],
              	  	nama_suplier: suplier[1],
    				kode_part: part[0],
              	  	nama_part: part[1],
              	  	harga: price,
              	  	satuan: satuan,
    				qty: qty,
    				diskon: diskon,
    				pajak: pajak,
    				jumlah: jumlah
    				},
    				function(result,status){  // ketika sukses menyimpan data
    					console.log(result);
    					var data = JSON.parse(result);
    					console.log(data);
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
    	});
		/* // add datatable manualy and reset/focus field
		var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + part[0] + "</td><td>" + part[1] + "</td><td>" + qty +"</td></tr>"  ;
		$("#dataTables3 tbody").append(markup);
		
		document.formPartMasuk.qty.value = "";
		$('#kode_part').find('option:first-child').prop('selected', true).end().trigger('chosen:updated');
		$("#kode_part").focus();
		*/
		
		$('#kode_suplier, #tanggal, #tipe').on('change', function(){
    	    var tipe = $('#tipe').val();
    	    
    	    if(tipe=='Tempo'){
    	        //set tgl jatuh tempo ditambah top suplier
    	        
    	        //alert($('#kode_suplier option:selected').attr('top-data'));
    	        
    	        var tanggal = new Date($('#tanggal').data('datepicker').getFormattedDate('yyyy-mm-dd'));
    	        var hari = $('#kode_suplier option:selected').attr('top-data');
    	        var jatuh_tempo = tanggal.addDays(hari);
    	    
    	        $("#jatuh_tempo").datepicker("update", jatuh_tempo);
    	    }
    	    else{
    	        //set tgl jatuh tempo menjadi tgl 
    	        var tanggal = new Date($('#tanggal').data('datepicker').getFormattedDate('yyyy-mm-dd'));
    	    
    	        $("#jatuh_tempo").datepicker("update", tanggal);
    	    }
    	    
    	});
    	
    	$('#chk_diskon').on('change', function(){
        	if($(this).is(':checked'))
        		$('#diskon').removeAttr('readonly');
        	else{
        		$('#diskon').val(0);
        		$('#diskon').attr('readonly', 'readonly');
        	}
        	
        	hitung_total();
        });
        
        $('#qty, #price, #diskon, #chk_pajak').on('change', function(){
            //alert('hello world');
        	hitung_total();	
        });
        
        hitung_total();
    	
	});
	function hitung_total(){
        	var qty = $('#qty').val()=='' ? 0 : $('#qty').val();
        	var price = $('#price').val()=='' ? 0 :  $('#price').val();
        	var diskon = $('#diskon').val()=='' ? 0 : $('#diskon').val();
        	var pajak = $('#chk_pajak').is(':checked') ? 0.11 : 0;
        
        	$('#jumlah').val((qty * price - diskon) * (1+pajak));
        }	
        
	
        
		
	
	
	function removeRow(id){
		//$("table input[type='checkbox']:checked").parent().parent().remove();
		$.post("modules/part-request/proses.php",
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
	
	function tampil_part(input) {
		
		if(input.value == "STOK") {
			frmPartReq.no_po.disabled = "true" ;
			frmPartReq.no_po.value = "STOK";
		}
		else if(input.value == "CASH") {
			frmPartReq.no_po.disabled = "true" ;
			frmPartReq.no_po.value = "CASH";
		}
		else {
			$('#no_po').prop("disabled", false);
			frmPartReq.no_po.value = "";
		}
		
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
    jml = frmPartReqDetail.qty.value;
    var jumlah = eval(jml);
    if(jumlah == XX){
      alert('Quantity Harus Angka !');
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

function getItemInfo(input) {
		var part = input.value.split("|"); //$("#kode_part").val();
		
			
		$.post("modules/part-request/invent.php", {
			  item: part[0]
			}, function(response) {  
			  $('#unitSpan').html(response)
				frmPartReqDetail.unit.value = response;
			  document.getElementById('qty').focus();
		});
	
		// set value harga
		var harga = $('#kode_part option:selected').attr('harga-data');
		harga = parseInt(harga);
		console.log(harga)
		$("[name=price]").val(harga);
		hitung_total();
		/*
		$.post("modules/part-masuk/part.php", {
		dataidpart: part,
		}, function(response) {      
		$('#stok').html(response);
		alert(response);
		document.formPartMasuk.qty.focus();
		});*/
	}
	function set_suplier(){
		str = $("[name=kode_suplier]").val()
		kode_suplier = str.split("|")
		let urlCurrent = window.location.href.split('?')[0];
		url = urlCurrent + "?module=form_part_request&form=add&kode_suplier="+kode_suplier[0];
		location.href = url;
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
      <i class="fa fa-edit icon-title"></i> Input Item Request 
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part_request"> Item Request </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" name="frmPartReq" id="frmPartReq">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
              <?php  
				  // fungsi untuk membuat kode transaksi
          			$user = $_SESSION['id_user'];
				  $query_id = mysqli_query($mysqli, "SELECT  kode_request,tanggal, jatuh_tempo, tipe, status_bayar, kode_suplier, keterangan FROM is_temp_req where created_user = '$user' order by id desc limit 1;")
													or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

				  $count = mysqli_num_rows($query_id);

				  if ($count > 0) {
					  // mengambil data kode transaksi
					  $data_id = mysqli_fetch_assoc($query_id);
					  $kode_request    	= $data_id['kode_request'];
					  $tgl				= DateTime::createFromFormat('Y-m-d', $data_id['tanggal'])->format('d-m-Y');
					  $jatuh_tempo      = DateTime::createFromFormat('Y-m-d', $data_id['jatuh_tempo'])->format('d-m-Y');
            		  $vend       		= $data_id['kode_suplier'];
					  $tipe				= $data_id['tipe'];
            		  $descr      		= $data_id['keterangan'];
            		  $status_bayar     = $data_id['status_bayar'];
				  }
				  else {
            
            		  $query_id = mysqli_query($mysqli, "SELECT  count(kode_request) as id FROM is_part_req WHERE  date(created_date) = date(NOW());")
														or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

					  $count = mysqli_fetch_assoc($query_id);
            
            		  $query_idTmp = mysqli_query($mysqli, "SELECT  count(kode_request ) as id FROM is_temp_req
                                                    WHERE  created_date = NOW() and created_user != '$user'; ")
					  														or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

					  $countTmp = mysqli_fetch_assoc($query_idTmp);
            
            if (($count['id'] + $countTmp['id'] )> 0) {
						  // mengambil data po
						  $data_id 			  = mysqli_fetch_assoc($query_id);
						  $data_idTmp 		= mysqli_fetch_assoc($query_idTmp);
						  $runNum			    = str_pad($count['id'] + $countTmp['id'] + 1 , 3 ,0,STR_PAD_LEFT);
						  $kode_request		= 'PO-'.date('Ymd').$runNum;
						 
					  }
					  else {
						  $kode_request			= 'PO-'.date('Ymd').'001';
					  }
            
					  $descr      = '';
					  $tgl				= date('d-m-Y');
					  $jatuh_tempo = date('d-m-Y');
					  $tipe				= '';
					$vend       = '';
				  }

        ?>
			
       <div class="form-group row" style="padding: 15px 15px 0px 15px"><!-- /row -->
				<div class="col-md-4">
					<div class="form-group">
            <label for="kode_vendor">Kode Suplier</label>
						<select class="chosen-select"  id="kode_suplier" name="kode_suplier" data-placeholder="-- Pilih Suplier --" onchange="set_suplier()" autocomplete="off">
						<?php
						if(isset($_GET['kode_suplier'])){
							$suplier_get = $_GET['kode_suplier'];
							$query_sup = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier where kode = '$suplier_get'")
							or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
							$data_sup = mysqli_fetch_row($query_sup);
						}
						?>
						<option value="<?php echo isset($_GET['kode_suplier']) ? $data_sup[0]."|".$data_sup[1]  : ''; ?>" top-data="<?php echo isset($_GET['kode_suplier']) ? $data_sup[2]  : ''; ?>"><?php echo isset($_GET['kode_suplier']) ? $data_sup[0]." | ".$data_sup[1]  : ''; ?></option>
						<?php
							if($vend == '')
							{
								$vend = isset($_GET['kode_suplier']) ? trim($_GET['kode_suplier']," ")  : $vend;

									$query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier ORDER BY kode ASC")
									or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
								while ($data_part = mysqli_fetch_assoc($query_part)) {
									echo"<option value=\"$data_part[kode]|$data_part[nama]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
								}
							}
							else
							{
								$vend = isset($_GET['kode_suplier']) ? trim($_GET['kode_suplier']," ")  : $vend;
								$query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier where kode = '$vend'")
																or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
								while ($data_part = mysqli_fetch_assoc($query_part)) {
									echo"<option selected value=\"$data_part[kode]|$data_part[nama]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
								}
							}
								
						?>
						</select>		
					</div>
				</div> 
        
        
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
							<label>Tanggal</label>
							<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal" name="tanggal" autocomplete="off" value="<?php echo $tgl; ?>" >
							</div>
					</div>
				</div>
        
        <div class="col-md-2">
					<div class="form-group">					
						<label for="kode_request">Nomor PO</label>
						<input type="text" class="form-control" readonly name="no_po" id="no_po" value=<?php echo '"'.$kode_request.'"'; //if($tipe!="PO") echo ' disabled' ?> >
					</div>
				</div><!-- /col -->
        
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
						<label>Tipe</label>
						<select class="form-control" name="tipe" id="tipe" data-placeholder="-- Pilih --" autocomplete="off" <!--onchange="tampil_part(this)"--> >
							<option value="" <?php if($tipe=="") echo "selected"?> ></option>
							<option value="CASH" <?php if($tipe=="CASH") echo "selected"?> >CASH</option>
							<option value="Tempo" <?php if($tipe=="Tempo") echo "selected"?> >Tempo</option>
						</select>		
					</div>			
				</div>
				
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
							<label>Jatuh Tempo</label>
							<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="jatuh_tempo" name="jatuh_tempo" autocomplete="off" value="<?php echo $jatuh_tempo; ?>">
							</div>
					</div>
				</div>
				
				<!--<div class="col-md-2"> 
					<div class="form-group">
						<label>Status Pembayaran</label>
						<select class="form-control" name="status_bayar" id="status_bayar" data-placeholder="-- Pilih --" autocomplete="off"--> <!--onchange="tampil_part(this)"--><!-- >
							<option value="" <?php if($status_bayar=="") echo "selected"?> ></option>
							<option value="Paid" <?php if($status_bayar=="Paid") echo "selected"?> >Paid</option>
							<option value="Unpaid" <?php if($status_bayar=="Unpaid") echo "selected"?> >Unpaid</option>
						</select>		
					</div>			
				</div>-->
        
                <!--<div class="col-md-4"> 
					<div class="form-group">
							<label>Bukti</label>
							<input type="file" class="form-control" name="bukti" >
					</div>
				</div>-->
        
                <div class="col-md-8">
					<div class="form-group">
						<label for="description">Keterangan</label>
						<input type="text" class="form-control" name="descr" id="descr" value="<?php echo $descr; ?>" >
					</div>
				</div><!-- /col -->
			
			</div><!-- /row -->
			
			<div class="form-group" align="right">
				<div class="col-md-12" align="right">
					<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="btnSimpan" value="Simpan"> <!-- onClick="saveData()"-->
					<a href="?module=part_request" class="btn btn-default btn-reset">Batal</a>
				</div>
			</div>
			</form>
			
			</div>
			<div class="box-body">
			<hr>
			<form role="form" class="form-horizontal" name="frmPartReqDetail" id="frmPartReqDetail"> 
			<div class="form-group">
                <label class="col-sm-2 control-label">Item</label>
                <div class="col-sm-5">
					<select class="chosen-select"  id="kode_part" name="kode_part" data-placeholder="-- Pilih item --" onChange='getItemInfo(this)' autocomplete="off">
					<option value=""></option>
                    <?php
						$suplier = isset($_GET['kode_suplier']) ? $_GET['kode_suplier'] :'';
						if($vend != ""){
							$query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, harga FROM is_part where kode_suplier = '$vend' ORDER BY kode_part ASC")
									or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
						} else {
							if($suplier != ''){
								$query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, harga FROM is_part where kode_suplier = '$suplier' ORDER BY kode_part ASC")
									or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
							} else {
								$query_part = mysqli_query($mysqli, "SELECT kode_part, nama_part, harga FROM is_part ORDER BY kode_part ASC")
								or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
							}
						}
						while ($data_part = mysqli_fetch_assoc($query_part)) {
                        echo"<option value=\"$data_part[kode_part]|$data_part[nama_part]\" harga-data=\"$data_part[harga]\"> $data_part[kode_part] | $data_part[nama_part] </option>";
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
                <div class="col-sm-2">
                  <input type='hidden' id='unit' name='unit'>
                  <div class='input-group'>
                      <!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
                    <input type="number" class="form-control money" id="qty" name="qty" step="0.01" autocomplete="off" onkeyup="hitung_total_stok(this)&cek_qty(this)">
                    <span id="unitSpan" class='input-group-addon'></span>
                  </div>
                </div>
				
                <label class="col-sm-1 control-label">Price</label>
                <div class="col-sm-2">
                    <!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
                  <input type="number" class="form-control money" id="price" name="price" step="0.01" autocomplete="off" onkeyup="hitung_total_stok(this)&cek_qty(this)">
                </div>
              </div>
              
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-2">
                    <input type="checkbox" class="form-check-input" id="chk_diskon">
                    <label class="form-check-label" for="chk_diskon"> Diskon</label>
                  </div>
                  <div class="col-sm-2">
                    <input type="checkbox" class="form-check-input" id="chk_pajak">
                    <label class="form-check-label" for="chk_pajak"> Pajak</label>
                  </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label">Diskon</label>
                <div class="col-sm-2">
                  <div class='input-group'>
                      <!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
                    <input type="number" class="form-control money" id="diskon" name="diskon" step="0.01" autocomplete="off" readonly>
                  </div>
                </div>
				
                <label class="col-sm-1 control-label">Jumlah</label>
                <div class="col-sm-2">
                    <!--onKeyPress="return goodchars(event,'-0123456789',this)"-->
                  <input type="number" class="form-control money" id="jumlah" name="jumlah" step="0.01" autocomplete="off" readonly>
                </div>
              </div>

              <div class="form-group">
                <!-- <label class="col-sm-2 control-label">Total Stok</label> -->
                <div class="col-sm-offset-2 col-sm-10">
                  <!-- <input type="text" class="form-control" id="total_stok" name="total_stok" readonly required> -->
				  <input type="button" class="btn btn-primary btn-submit" value="Tambah" id="btnTambah" name="btnTambah" >
				  <input type="button" class="btn btn-primary btn-submit" value="Hapus" onClick="removeRow()">
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
						<th class="center">Diskon</th>
						<th class="center">PPN</th>
						<th class="center">Jumlah</th>
						<th class="center"></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT a.id,a.kode_part,a.qty,b.kode_part,a.harga, a.diskon, a.pajak, a.jumlah, b.nama_part,b.satuan
												FROM is_temp_req as a INNER JOIN is_part as b ON a.kode_part=b.kode_part ORDER BY a.id ASC")
												or die('Ada kesalahan pada query tampil Data Part Masuk: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 

					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>
						<td width='20' class='center'>$no</td>
						<td width='20' class='center'>$data[kode_part]</td>
						<td width='150'>$data[nama_part]</td>
						<td width='75' align='right'>$data[harga]</td>
						<td width='50' align='right'>$data[qty]</td>
						<td width='50' class='center'>$data[satuan]</td>
						<td width='50' align='right'>$data[diskon]</td>
						<td width='50' align='right'>$data[pajak]</td>
						<td width='50' align='right'>$data[jumlah]</td>
						<td class='center' width='30'><div>
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
else if($_GET['form']=='edit'){
?>
      <!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Edit Item Request 
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=part_request"> Item Request </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" name="frmPartReqEdit" id="frmPartReqEdit">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
              <?php  
				  // fungsi untuk membuat kode transaksi
          			$user = $_SESSION['id_user'];
          			$kode_request = $_GET['kode'];
				  $query_id = mysqli_query($mysqli, "SELECT  kode_request,tanggal, jatuh_tempo, tipe, status_bayar, kode_suplier, keterangan FROM is_part_req where kode_request = '$kode_request' ")
													or die('Ada kesalahan pada query tampil kode_transaksi : '.mysqli_error($mysqli));

				  $count = mysqli_num_rows($query_id);

				  if ($count > 0) {
					  // mengambil data kode transaksi
					  $data_id = mysqli_fetch_assoc($query_id);
					  
					  $kode_request    	= $data_id['kode_request'];
					  $tgl				= DateTime::createFromFormat('Y-m-d', $data_id['tanggal'])->format('d-m-Y');
					  $jatuh_tempo      = DateTime::createFromFormat('Y-m-d', $data_id['jatuh_tempo'])->format('d-m-Y');
            		  $vend       		= $data_id['kode_suplier'];
					  $tipe				= $data_id['tipe'];
					  $status_bayar     = $data_id['status_bayar'];
            		  $descr      		= $data_id['keterangan'];
				  }
				  
            
            		  

        ?>
			
       <div class="form-group row" style="padding: 15px 15px 0px 15px"><!-- /row -->
				<div class="col-md-4">
					<div class="form-group">
            <label for="kode_vendor">Kode Suplier</label>
						<select class="chosen-select"  id="kode_suplier" name="kode_suplier" data-placeholder="-- Pilih Suplier --" autocomplete="off">
						<option value=""></option>
						<?php
							if($vend == '')
							{
								$query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier ORDER BY kode ASC")
																or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
								while ($data_part = mysqli_fetch_assoc($query_part)) {
									echo"<option value=\"$data_part[kode]|$data_part[nama]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
								}
							}
							else
							{
								$query_part = mysqli_query($mysqli, "SELECT kode, nama, top FROM is_suplier where kode = '$vend'")
																or die('Ada kesalahan pada query tampil part: '.mysqli_error($mysqli));
								while ($data_part = mysqli_fetch_assoc($query_part)) {
									echo"<option selected value=\"$data_part[kode]|$data_part[nama]\" top-data=\"$data_part[top]\"> $data_part[kode]   |   $data_part[nama] </option>";
								}
							}
								
						?>
						</select>		
					</div>
				</div> 
        
        
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
							<label>Tanggal</label>
							<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal" name="tanggal" autocomplete="off" value="<?php echo $tgl; ?>" >
							</div>
					</div>
				</div>
        
        <div class="col-md-2">
					<div class="form-group">					
						<label for="kode_request">Nomor PO</label>
						<input type="text" class="form-control" readonly name="no_po" id="no_po" value=<?php echo '"'.$kode_request.'"'; //if($tipe!="PO") echo ' disabled' ?> >
					</div>
				</div><!-- /col -->
        
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
						<label>Tipe</label>
						<select class="form-control" name="tipe" id="tipe" data-placeholder="-- Pilih --" autocomplete="off" <!--onchange="tampil_part(this)"--> >
							<option value="" <?php if($tipe=="") echo "selected"?> ></option>
							<option value="CASH" <?php if($tipe=="CASH") echo "selected"?> >CASH</option>
							<option value="Tempo" <?php if($tipe=="Tempo") echo "selected"?> >Tempo</option>
						</select>		
					</div>			
				</div>
				
				<div class="col-md-2"> <!-- col -->
					<div class="form-group">
							<label>Jatuh Tempo</label>
							<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="jatuh_tempo" name="jatuh_tempo" autocomplete="off" value="<?php echo $jatuh_tempo; ?>" >
							</div>
					</div>
				</div>
        
                <!--<div class="col-md-2"> --><!-- col -->
					<!--<div class="form-group">
						<label>Status Pembayaran</label>
						<select class="form-control" name="status_bayar" id="status_bayar" data-placeholder="-- Pilih --" autocomplete="off" <!--onchange="tampil_part(this)"--> 
							<!--<option value="" <?php if($status_bayar=="") echo "selected"?> ></option>
							<option value="Paid" <?php if($status_bayar=="Paid") echo "selected"?> >Paid</option>
							<option value="Unpaid" <?php if($status_bayar=="Unpaid") echo "selected"?> >Unpaid</option>
						</select>		
					</div>			
				</div>-->
        
                <div class="col-md-8">
					<div class="form-group">
						<label for="description">Keterangan</label>
						<input type="text" class="form-control" name="descr" id="descr" value="<?php echo $descr; ?>" >
					</div>
				</div><!-- /col -->
			
			</div><!-- /row -->
			
			<div class="form-group" align="right">
				<div class="col-md-12" align="right">
					<input type="submit" class="btn btn-primary btn-submit" id="btnSimpan" name="btnSimpan" value="Simpan"> <!-- onClick="saveData()"-->
					<a href="?module=part_request" class="btn btn-default btn-reset">Batal</a>
				</div>
			</div>
			</form>
			
			</div>
			<div class="box-body">
			<hr>
			<form role="form" class="form-horizontal" name="frmPartReqDetail" id="frmPartReqDetail"> 

            <!-- <div class="box-footer"> -->
			<div class="box-footer">
				<table id="table-temp" class="table table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th class="center">No</th>
						<th class="center">Kode Part</th>
						<th class="center">Nama Part</th>
						<th class="center">Harga</th>
						<th class="center">Qty</th>
						<th class="center">Satuan</th>
						<th class="center">Diskon</th>
						<th class="center">PPN</th>
						<th class="center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				function Rupiah($angka){
				$hasil = "Rp " . number_format($angka,2,',','.');
				return $hasil;
				}
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT a.id,a.kode_part,a.qty,b.kode_part,b.nama_part,b.satuan, a.harga, a.diskon, a.pajak, a.jumlah
												FROM is_part_req as a INNER JOIN is_part as b ON a.kode_part=b.kode_part WHERE kode_request='$kode_request' ORDER BY a.id ASC")
												or die('Ada kesalahan pada query tampil Data Part Masuk: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 

					// menampilkan isi tabel dari database ke tabel di aplikasi
					echo "<tr>
						<td width='20' class='center'>$no</td>
						<td width='80' class='center'>$data[kode_part]</td>
						<td width='200'>$data[nama_part]</td>
						<td width='50' align='right'>".Rupiah($data['harga'])."</td>
						<td width='50' align='right'>$data[qty]</td>
						<td width='50' class='center'>$data[satuan]</td>
						<td width='50' align='right'>".Rupiah($data[diskon])."</td>
						<td width='50' align='right'>".Rupiah($data[pajak])."</td>
						<td width='50' align='right'>".Rupiah($data['jumlah'])."</td>
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