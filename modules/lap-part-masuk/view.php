<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-file-text-o icon-title"></i> Laporan Data Mutasi Item
  </h1>
  <ol class="breadcrumb">
    <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active">Laporan</li>
    <li class="active">Data Mutasi Part </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

      <!-- Form Laporan -->
      <div class="box box-primary">
        <!-- form start -->
        <form role="form" class="form-horizontal" method="post"> <!--action="modules/lap-part-masuk/cetak.php" target="_blank"--> 
          <div class="box-body">
		  
			 <div class="form-group" >
				  <label class="col-sm-1" style='text-align:left;padding:14px 0px 0px 15px;'>Tanggal</label>
				  <div class="col-sm-2" style='padding:8px;'>
					<input required type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tgl_awal" autocomplete="off"  >
				  </div>
				  <label class="col-sm-1" style='text-align:center;padding:14px'>s.d.</label>
				  <div class="col-sm-2" style='padding:8px;'>
					<input required type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tgl_akhir" autocomplete="off"  >
				  </div>
				  <div class="col-sm-1">
					<button type="submit" class="btn btn-primary btn-social btn-submit">
					  <span class="fa fa-table"></span>Show
					</button>
				  </div>
			 </div>
			  
			  <!-- tampilan tabel part -->
			  <table id="dataTables-group2" class="table table-bordered table-hover table-condensed">
				<!-- tampilan tabel header -->
				<thead>
				  <tr>
					<th class="center">Tanggal</th>
					<th class="center">No Transaksi</th>
					<th class="center">Kode Item</th>
					<th class="center">Nama Item</th>
					<th class="center">Kategori</th>
					<th class="center">Keterangan</th>
					<th class="center">Referensi</th>
					<th class="center">Qty</th>
					<th class="center">Saldo</th>
				  </tr>
				</thead>
				<!-- tampilan tabel body -->
				<tbody>
            
			<?php 
			if(isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir'])) {
				
				$tanggal	= mysqli_real_escape_string($mysqli, trim($_POST['tgl_awal']));
				$exp        = explode('-',$tanggal);
				$tgl_awal	= $exp[2]."-".$exp[1]."-".$exp[0];
				$tanggal    = mysqli_real_escape_string($mysqli, trim($_POST['tgl_akhir']));
				$exp        = explode('-',$tanggal);
				$tgl_akhir	= $exp[2]."-".$exp[1]."-".$exp[0];
				$no = 1;
				// fungsi query untuk menampilkan data dari tabel part
				$query = mysqli_query($mysqli, "with T AS(
													SELECT 
															0 AS id,
															'$tgl_awal' tanggal_transaksi,
															'' kode_transaksi,
															a.kode_part,
															a.nama_part,
															a.kategori,
															'' keterangan,
															'BEGINNING' referensi,
															a.stok + SUM(IF(b.tanggal_transaksi < '$tgl_awal', b.qty,0)) AS 'qty'
													FROM
															is_part a
													LEFT JOIN
															is_part_trans b ON	
															a.kode_part = b.kode_part
													GROUP BY a.kode_part 
													
													UNION all
													
													SELECT
															tx.id AS id,
															tx.tanggal_transaksi,
															tx.kode_transaksi,
															tx.kode_part,
															m.nama_part,
															m.kategori,
															tx.keterangan,
															tx.referensi,
															tx.qty
													FROM
															is_part_trans tx
													JOIN is_part m USING(kode_part) WHERE tx.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir'
													
													UNION all
													
													SELECT 
															~0 id,
															'$tgl_akhir' tanggal_transaksi,
															'' kode_transaksi,
															a.kode_part,
															a.nama_part,
															a.kategori,
															'' keterangan,
															'ENDING' referensi,
															a.stok + SUM(IF(b.tanggal_transaksi <= '$tgl_akhir', b.qty,0)) AS 'qty'
													FROM
															is_part a
													LEFT JOIN
															is_part_trans b ON	
															a.kode_part = b.kode_part
													GROUP BY a.kode_part
												)
											SELECT 
												*, 
												if(referensi = 'ENDING',qty, SUM(qty) over (PARTITION BY kode_part ORDER BY id)  )AS saldo
											FROM T
											ORDER BY 
												kode_part ASC, 
												id ASC ")
											or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
				  //$harga_beli = format_rupiah($data['harga_beli']);
				  //$harga_jual = format_rupiah($data['harga_jual']);
				  // menampilkan isi tabel dari database ke tabel di aplikasi
				  $format = ($data['referensi'] === "BEGINNING" || $data['referensi'] === "ENDING") ? ' class=highlight ' : '';
					
				  echo "<tr$format>
						  <td width='60'>$data[tanggal_transaksi]</td>
						   <td width='60'>$data[kode_transaksi]</td>
						  <td width='60' class='center'>$data[kode_part]</td>
						  <td width='280'>$data[nama_part]</td>
						  <td width='60'>$data[kategori]</td>
						  <td width='60'>$data[keterangan]</td>
						  <td width='60'>$data[referensi]</td>
						  <td width='80' align='right'>$data[qty]</td>
						  <td width='80' align='right'>$data[saldo]</td>
						</tr>";
				  $no++;
				}
			}
            ?>
            </tbody>
          </table>
          </div>
        </form>
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content -->