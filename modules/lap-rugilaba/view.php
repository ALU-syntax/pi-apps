

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-file-text-o icon-title"></i> Laporan Rugi Laba

   <!--  <a class="btn btn-primary btn-social pull-right" href="modules/lap-stok/cetak.php" target="_blank">
     <i class="fa fa-print"></i> Cetak
    </a>-->
  </h1>

</section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
	  <form role="form" class="form-horizontal" method="post">
        <div class="box-body">
		
		 <div class="form-group" >
			  <label class="col-sm-1" style='text-align:left;padding:14px 0px 0px 15px;'>Tanggal</label>
              <div class="col-sm-2" style='padding:8px;'>
                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tgl_awal" autocomplete="off" required>
              </div>
              <label class="col-sm-1" style='text-align:center;padding:14px'>s.d.</label>
              <div class="col-sm-2" style='padding:8px;'>
                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tgl_akhir" autocomplete="off" required>
              </div>
			  <div class="col-sm-1">
                <button type="submit" class="btn btn-primary btn-social btn-submit">
					  <span class="fa fa-table"></span>Show
                </button>
              </div>
		 </div>
		  
		  <!-- tampilan Pendapatan -->
		  <h4>Pendapatan</h4>
          <table id="#" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <td width="50%">Akun</th>
                <td width="25%">Total</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
			// fungsi buatRupiah
				function Rupiah($angka){
				$hasil = "Rp " . number_format($angka,2,',','.');
				return $hasil;
				}

			
			if(isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']))
			{
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_awal']));
				$exp             	= explode('-',$tanggal);
				$tgl_awal			= $exp[2]."-".$exp[1]."-".$exp[0];
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_akhir']));
				$exp             	= explode('-',$tanggal);
				$tgl_akhir			= $exp[2]."-".$exp[1]."-".$exp[0];
				
								
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT SUM(value) AS totalsales FROM is_sales WHERE tanggal between '$tgl_awal' and '$tgl_akhir'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
				  $totalsales =$data['totalsales'];
				  echo "<tr>
						  <td width='50%'>Sales</td>
						  <td width='25%'>" . Rupiah($totalsales) . "</td> 
						</tr>";
				  $no++;
				}
			}
			
            ?>
            </tbody>
          </table>
		  
		  <!-- tampilan Pembelian -->
		  <h4>Pembelian</h4>
          <table id="#" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <td width="50%">Akun</th>
                <td width="25%">Total</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
			if(isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']))
			{
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_awal']));
				$exp             	= explode('-',$tanggal);
				$tgl_awal			= $exp[2]."-".$exp[1]."-".$exp[0];
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_akhir']));
				$exp             	= explode('-',$tanggal);
				$tgl_akhir			= $exp[2]."-".$exp[1]."-".$exp[0];
				
								
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel pembelian
				$query = mysqli_query($mysqli, "SELECT qty,harga,SUM(qty*harga) AS totalcash FROM is_part_req WHERE tanggal between '$tgl_awal' and '$tgl_akhir' and tipe = 'CASH'")
				
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
												
				$query2 = mysqli_query($mysqli, "SELECT qty,harga,SUM(qty*harga) AS totalpo FROM is_part_req WHERE tanggal between '$tgl_awal' and '$tgl_akhir' and tipe = 'Tempo'")
				
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
								
				$querypaid = mysqli_query($mysqli, "SELECT SUM(jumlah) AS total FROM is_part_req WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND status_bayar = 'Paid'")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												
				$queryunpaid = mysqli_query($mysqli, "SELECT SUM(jumlah) AS total FROM is_part_req WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND status_bayar = 'Unpaid'")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) 
				{ 
				 
				    $totalcash = $data['totalcash'];
				    echo "<tr>
						  <td width='50%'>Cash</td>
						  <td width='25%'>" . Rupiah($totalcash) . "</td> 
						</tr>
						 ";
				    $no++;
				}
				while ($data = mysqli_fetch_assoc($query2)) 
				{ 
				    //$totalpem += $data['totalpo'];
				    $totalpo = $data['totalpo'];
				     echo "<tr>
						  <td width='50%'>Tempo</td>
						  <td width='25%'>" . Rupiah($totalpo) . "</td> 
						</tr>
						";
						
				    $no++;
				}

				while ($data = mysqli_fetch_assoc($querypaid)) 
				{ 
				    $total = $data['total'];
				    echo "<tr>
						  <td width='50%'>Paid</td>
						  <td width='25%'>" . Rupiah($total) . "</td> 
						</tr>
						";
				}
				while ($data = mysqli_fetch_assoc($queryunpaid)) 
				{ 
				    $total = $data['total'];
				    echo "<tr>
						  <td width='50%'>Unpaid</td>
						  <td width='25%'>" . Rupiah($total) . "</td> 
						</tr>
						";
				}
						
				 $totalpem=$totalpo+$totalcash;
				 echo "<tr>
						  <td width='50%' bold>Total Pembelian</td>
						  <td width='25%'>" . Rupiah($totalpem) . "</td>
						</tr>
						";
				 
			}
			
            ?>
            </tbody>
          </table>
		  <h4>Biaya Operasional</h4>
          <table id="#" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <td width="50%">Akun</th>
                <td width="25%">Total</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
			if(isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']))
			{
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_awal']));
				$exp             	= explode('-',$tanggal);
				$tgl_awal			= $exp[2]."-".$exp[1]."-".$exp[0];
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_akhir']));
				$exp             	= explode('-',$tanggal);
				$tgl_akhir			= $exp[2]."-".$exp[1]."-".$exp[0];
				
								
				
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				// 'Energi','Gaji','Other','Transport','Promo','Consump','Sewa'
				$querytipeenergi = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Energi'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				$querydetailenergi = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Energi' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));

				$querytipegaji = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Gaji'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));	
				$querydetailgaji = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Gaji' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
												
				$querytipeother = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Other'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				$querydetailother = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Other' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));									
												
			
				$querytipetransport = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Transport'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));	
				$querydetailtransport = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Transport' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));							

											
				$querytipepromo = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Promo'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				$querydetailpromo = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Promo' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));	
												
				$querytipeconsump = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Consump'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				$querydetailconsump = mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Consump' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));								
												

				$querytipesewa = mysqli_query($mysqli, "SELECT SUM(amount) AS totalbiaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Sewa'")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
				$querydetailsewa= mysqli_query($mysqli, "SELECT nomor, IFNULL(SUM(amount),0) AS biaya FROM is_invoice WHERE tanggal between '$tgl_awal' and '$tgl_akhir' AND tipe ='Sewa' GROUP BY nomor")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));							
				
												
				// 'Energi','Gaji','Other','Transport','Promo','Consump','Sewa'
				#ENERGI
				$TABLE_ENERGI = '';
				while ($data = mysqli_fetch_assoc($querytipeenergi)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordionenergi' class='clickable'>
						 <td width='50%'>Total Biaya Energi</td>
						 <td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
			   	}
				while ($data = mysqli_fetch_assoc($querydetailenergi)) { 
					$biaya = $data['biaya'];
					$TABLE_ENERGI .= "
					<tr class='collapse accordionenergi'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_ENERGI;

				#GAJI
				$TABLE_GAJI = '';
				while ($data = mysqli_fetch_assoc($querytipegaji)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr  data-toggle='collapse' data-target='.accordiongaji' class='clickable'>
						<td width='50%'>Total Biaya Gaji</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailgaji)) { 
					$biaya = $data['biaya'];
					$TABLE_GAJI .= "
					<tr class='collapse accordiongaji'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_GAJI;

				#OTHER
				$TABLE_OTHER = '';
				while ($data = mysqli_fetch_assoc($querytipeother)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordionother' class='clickable'>
						<td width='50%'>Total Biaya Lainnya</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailother)) { 
					$biaya = $data['biaya'];
					$TABLE_OTHER .= "
					<tr class='collapse accordionother'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_OTHER;

				#TRANSPORT
				$TABLE_TRANSPORT = '';
				while ($data = mysqli_fetch_assoc($querytipetransport)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordiontransport' class='clickable'>
						<td width='50%'>Total Biaya Transport</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailtransport)) { 
					$biaya = $data['biaya'];
					$TABLE_TRANSPORT .= "
					<tr class='collapse accordiontransport'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_TRANSPORT;

				#PROMO
				$TABLE_PROMO = '';
				while ($data = mysqli_fetch_assoc($querytipepromo)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordionpromo' class='clickable'>
						<td width='50%'>Total Biaya Promo</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailpromo)) { 
					$biaya = $data['biaya'];
					$TABLE_PROMO .= "
					<tr class='collapse accordionpromo'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_PROMO;

				#CONSUMP
				$TABLE_CONSUMP = '';
				while ($data = mysqli_fetch_assoc($querytipeconsump)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordionconsump' class='clickable'>
						<td width='50%'>Total Biaya Consump</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailconsump)) { 
					$biaya = $data['biaya'];
					$TABLE_CONSUMP .= "
					<tr class='collapse accordionconsump'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_CONSUMP;

				#SEWA
				$TABLE_SEWA = '';
				while ($data = mysqli_fetch_assoc($querytipesewa)) { 
					$totalbiaya = $data['totalbiaya'];
					echo "<tr data-toggle='collapse' data-target='.accordionsewa' class='clickable'>
						<td width='50%'>Total Biaya Sewa</td>
						<td width='25%'>" . Rupiah($totalbiaya) . "</td> 
					</tr>";
					$no++;
				}
				while ($data = mysqli_fetch_assoc($querydetailsewa)) { 
					$biaya = $data['biaya'];
					$TABLE_SEWA .= "
					<tr class='collapse accordionsewa'>
						<td width='50%' style='padding-left:20px;'>> " . $data['nomor'] . "</td>
						<td width='25%'>" . Rupiah($biaya) . "</td> 
					</tr>";
				}
				echo $TABLE_SEWA;

				#total
				while ($data = mysqli_fetch_assoc($query)) { 
				 	$totalbiaya = $data['totalbiaya'];
				  	echo "<tr>
						  <td width='50%'>Total Biaya Operasional</td>
						  <td width='25%'>" . Rupiah($totalbiaya) . "</td> 
						</tr>";
				  	$no++;
				}
			}
			
            ?>
            </tbody>
          </table>
		  
		  <!-- tampilan Biaya Operasinal -->
		  
		  
		  <!-- tampilan Rugi Laba -->
		  <h4>Rugi Laba</h4>
          <table id="#" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <td width="50%">Akun</th>
                <td width="25%">Total</th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
			
			$totalsales = isset($totalsales) ? $totalsales : 0;
			$totalpem = isset($totalpem) ? $totalpem : 0;
			$totalbiaya = isset($totalbiaya) ? $totalbiaya : 0;
		    $rugilaba = $totalsales-$totalpem-$totalbiaya;
			echo "<tr>
				   <td width='50%'>Rugi Laba</td>
				   <td width='25%'>" . Rupiah($rugilaba) . "</td> 
				  </tr>";	
            ?>
            </tbody>
          </table>
		
        </div><!-- /.box-body -->
		</form>
      </div><!-- /.box -->
	  
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content