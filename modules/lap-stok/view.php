

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-file-text-o icon-title"></i> Laporan Stok Item

    <!--<a class="btn btn-primary btn-social pull-right" href="modules/lap-stok/cetak.php" target="_blank">
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
		  
		  <!-- tampilan tabel part -->
          <table id="dataTables-group" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">Kode Item</th>
                <th class="center">Nama Item</th>
                <th class="center">Nama Suplier</th>
                <th class="center">Kategori</th>
				<th class="center">Satuan</th>
				<th class="center">Stok Level</th>
				<th class="center">Stok Awal (Gudang)</th>
				<th class="center">Stok Awal (Kitchen)</th>
				<th class="center">Stok Awal (Bar)</th>
				<th class="center">Stok Awal (Pastry)</th>
				<th class="center">Stok Masuk</th>
				<th class="center">Sales</th>
                <th class="center">Stok Akhir (Gudang)</th>
				<th class="center">Stok Akhir (Kitchen)</th>
				<th class="center">Stok Akhir (Bar)</th>
				<th class="center">Stok Akhir (Pastry)</th>
				<th class="center">Total Stok Akhir</th>
				<th class="center">Status</th>
				<th class="center">Value Stok Akhir</th>
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
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT 
													a.kode_part,
													a.nama_part,
													c.nama nama_suplier,
													a.kategori,
													a.satuan,
													a.stok,
													a.stok + SUM(if( b.tanggal_transaksi < '$tgl_awal', b.qty,0)) AS 'opening',
													SUM(if(b.referensi='receipt' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'in',
													SUM(if(b.referensi='issue' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'out',
													a.stok + SUM(if( b.tanggal_transaksi <= '$tgl_akhir', b.qty,0)) AS 'ending',
													a.stok_level,
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Kitchen' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_kitchen',
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Bar' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_bar',
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Pastry' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_pastry',
													SUM(if(b.referensi='sales' AND b.`group` = 'Kitchen' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_kitchen',
													SUM(if(b.referensi='sales' AND b.`group` = 'Bar' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_bar',
													SUM(if(b.referensi='sales' AND b.`group` = 'Pastry' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_pastry',
													SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales',
													SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty * b.harga,0)) AS 'value'
												FROM is_part a
												LEFT JOIN is_suplier c ON a.kode_suplier = c.kode
												LEFT JOIN is_part_trans b ON a.kode_part = b.kode_part
												GROUP BY a.kode_part ")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
				
				 $ending	 = $data['ending'];
				 $stok_level = $data['stok_level'];
				
				if ( $ending>=$stok_level ) { 
					$warning = "Aman";
				} else { 
					$warning = "Kritis"; 
				}
				  
				  // menampilkan isi tabel dari database ke tabel di aplikasi
				  echo "<tr>
						  <td width='60' class='center'>$data[kode_part]</td>
						  <td width='280'>$data[nama_part]</td>
						  <td width='100'>$data[nama_suplier]</td>
						  <td width='100'>$data[kategori]</td>
						  <td width='80' align='right'>$data[satuan]</td>
						  <td width='80' align='right'>$data[stok_level]</td>
						  <td width='50' class='center'>$data[opening]</td>
						  <td width='80' align='right'>$data[stock_kitchen]</td>
						  <td width='80' align='right'>$data[stock_bar]</td>
						  <td width='80' align='right'>$data[stock_pastry]</td>
						  <td width='80' align='right'>$data[in]</td>
						  <td width='80' align='right'>$data[sales]</td>
					      <td width='80' align='right'>".(($data["opening"] ?? 0) + $data["in"] )."</td>
						  <td width='80' align='right'>".(($data["stock_kitchen"] ?? 0) - $data["sales_kitchen"])."</td>
						  <td width='80' align='right'>".(($data["stock_bar"] ?? 0) - $data["sales_bar"])."</td>
						  <td width='80' align='right'>".(($data["stock_pastry"] ?? 0) - $data["sales_pastry"])."</td>
						  <td width='80' align='right'>$data[ending]</td>
						  <td width='80' align='right'>$warning</td>
						  <td width='80' align='right'>Rp. ".number_format(abs($data["value"]),2,',','.')."</td>
						</tr>";
				  $no++;
				}
			}else{
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_awal']));
				$exp             	= explode('-',$tanggal);
				$tgl_awal			= $exp[2]."-".$exp[1]."-".$exp[0];
				$tanggal         	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_akhir']));
				$exp             	= explode('-',$tanggal);
				$tgl_akhir			= $exp[2]."-".$exp[1]."-".$exp[0];
				
								
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "SELECT 
													a.kode_part,
													a.nama_part,
													c.nama nama_suplier,
													a.kategori,
													a.satuan,
													a.stok,
													a.stok + SUM(if( b.tanggal_transaksi < '$tgl_awal', b.qty,0)) AS 'opening',
													SUM(if(b.referensi='receipt' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'in',
													SUM(if(b.referensi='issue' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'out',
													a.stok + SUM(if( b.tanggal_transaksi <= '$tgl_akhir', b.qty,0)) AS 'ending',
													a.stok_level,
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Kitchen' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_kitchen',
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Bar' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_bar',
													(SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Pastry' AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY `group`) AS 'stock_pastry',
													SUM(if(b.referensi='sales' AND b.`group` = 'Kitchen' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_kitchen',
													SUM(if(b.referensi='sales' AND b.`group` = 'Bar' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_bar',
													SUM(if(b.referensi='sales' AND b.`group` = 'Pastry' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales_pastry',
													SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty,0)) AS 'sales',
													SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'), b.qty * b.harga,0)) AS 'value'
												FROM is_part a
												LEFT JOIN is_suplier c ON a.kode_suplier = c.kode
												LEFT JOIN is_part_trans b ON a.kode_part = b.kode_part
												GROUP BY a.kode_part ")
												or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
				
				 $ending	 = $data['ending'];
				 $stok_level = $data['stok_level'];
				
				if ( $ending>=$stok_level ) { 
					$warning = "Aman";
				} else { 
					$warning = "Kritis"; 
				}
				  
				  // menampilkan isi tabel dari database ke tabel di aplikasi
				  echo "<tr>
						  <td width='60' class='center'>$data[kode_part]</td>
						  <td width='280'>$data[nama_part]</td>
						  <td width='100'>$data[nama_suplier]</td>
						  <td width='100'>$data[kategori]</td>
						  <td width='80' align='right'>$data[satuan]</td>
						  <td width='80' align='right'>$data[stok_level]</td>
						  <td width='50' class='center'>$data[opening]</td>
						  <td width='80' align='right'>$data[stock_kitchen]</td>
						  <td width='80' align='right'>$data[stock_bar]</td>
						  <td width='80' align='right'>$data[stock_pastry]</td>
						  <td width='80' align='right'>$data[in]</td>
						  <td width='80' align='right'>$data[sales]</td>
					      <td width='80' align='right'>".(($data["opening"] ?? 0) + $data["in"])."</td>
						  <td width='80' align='right'>".(($data["stock_kitchen"] ?? 0) - $data["sales_kitchen"])."</td>
						  <td width='80' align='right'>".(($data["stock_bar"] ?? 0) - $data["sales_bar"])."</td>
						  <td width='80' align='right'>".(($data["stock_pastry"] ?? 0) - $data["sales_pastry"])."</td>
						  <td width='80' align='right'>$data[ending]</td>
						  <td width='80' align='right'>$warning</td>
						  <td width='80' align='right'>Rp. ".number_format(abs($data["value"]),2,',','.')."</td>
						</tr>";
				  $no++;
				}
			}
            ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
		</form>
      </div><!-- /.box -->
	  
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content -->

<!-- <td width='80' align='right'>".(($data["stock_kitchen"] ?? 0) + $data["sales_kitchen"])."</td>
						  <td width='80' align='right'>".(($data["stock_bar"] ?? 0) + $data["sales_bar"])."</td>
						  <td width='80' align='right'>".(($data["stock_pastry"] ?? 0) + $data["sales_pastry"])."</td>
						  <td width='80' align='right'>$data[sales]</td>
					      <td width='80' align='right'>$data[ending]</td>
						  <td width='80' align='right'>Rp. ".number_format(abs($data["value"]),2,',','.')."</td> -->