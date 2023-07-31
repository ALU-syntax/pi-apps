<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Data Item Opname
    <!-- <a class="btn btn-primary btn-social pull-right" href="?module=form_opname&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a> -->
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong) tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data part baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) { ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Stok Opaname baru berhasil disimpan.
    </div>
    <?php }
    // jika alert = 2
    // tampilkan pesan Sukses "Data part berhasil diubah"
    elseif ($_GET['alert'] == 2) { ?>
      <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Stok Opname berhasil diubah.
            </div>
    <?php }
    // jika alert = 3
    // tampilkan pesan Sukses "Data part berhasil dihapus"
    elseif ($_GET['alert'] == 3){ ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Stok Opname berhasil dihapus.
    </div>
    <?php } ?>
  
      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel part -->
          <table id="dataTables2" class="table table-bordered table-striped table-hover table-condensed" width="100%">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">Kode Item</th>
                <th class="center">Nama Item</th>
                <th class="center">Tanggal Diperbaharui</th>
                <th class="center">Stok Akhir (Gudang)</th>
                <th class="center">Stok Akhir (Kitchen)</th>
                <th class="center">Stok Akhir (Bar)</th>
                <th class="center">Stok Akhir (Pastry)</th>
                <th class="center">Petugas</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php  
				$no = 1;
        $query = mysqli_query($mysqli, "SELECT 
              a.kode_part,
              a.nama_part,
              c.nama nama_suplier,
              a.kategori,
              a.satuan,
              a.stok,
              a.stok + SUM(if( b.tanggal_transaksi < NOW(), b.qty,0)) AS 'opening',
              SUM(if(b.referensi='receipt' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'in',
              SUM(if(b.referensi='issue' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'out',
              a.stok + SUM(if( b.tanggal_transaksi <= NOW(), b.qty,0)) AS 'ending',
              a.stok_level,
              (SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Kitchen' AND tanggal BETWEEN NOW() AND NOW() GROUP BY `group`) AS 'stock_kitchen',
              (SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Bar' AND tanggal BETWEEN NOW() AND NOW() GROUP BY `group`) AS 'stock_bar',
              (SELECT COALESCE(SUM(qty), 0) AS 'qty' FROM is_part_consump WHERE kode_item = a.kode_part AND `group` = 'Pastry' AND tanggal BETWEEN NOW() AND NOW() GROUP BY `group`) AS 'stock_pastry',
              SUM(if(b.referensi='sales' AND b.`group` = 'Kitchen' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'sales_kitchen',
              SUM(if(b.referensi='sales' AND b.`group` = 'Bar' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'sales_bar',
              SUM(if(b.referensi='sales' AND b.`group` = 'Pastry' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'sales_pastry',
              SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty,0)) AS 'sales',
              SUM(if(b.referensi='sales' AND (b.tanggal_transaksi BETWEEN NOW() AND NOW()), b.qty * b.harga,0)) AS 'value',
              a.updated_date as updated_date
            FROM is_part a
            LEFT JOIN is_suplier c ON a.kode_suplier = c.kode
            LEFT JOIN is_part_trans b ON a.kode_part = b.kode_part
            GROUP BY a.kode_part")
												or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
        
				// $query = mysqli_query($mysqli, "SELECT kode_part,kode_suplier, ifnull(suplier.nama,'-') as nama_suplier,nama_part,is_part.group,kategori,satuan ,stok,stok_level,ifnull(harga,0) as harga FROM is_part LEFT JOIN is_suplier as suplier ON suplier.kode = is_part.kode_suplier")
				// 								or die('Ada kesalahan pada query tampil Data Part Request: '.mysqli_error($mysqli));
												 // fungsi buatRupiah
				function Rupiah($angka){
          $hasil = "Rp " . number_format($angka,2,',','.');
          return $hasil;
				}

				// tampilkan data
				while ($data = mysqli_fetch_assoc($query)) { 
					echo '<tr>';
					
					echo '<td class="center">' . $data["kode_part"] . '</td>';
					echo '<td>' . $data["nama_part"] . '</td>';
					echo '<td>' . $data["updated_date"] . '</td>';
					echo '<td>' . $data['ending'] . '</td>';
					echo '<td>' . (($data["stock_kitchen"] ?? 0)) . '</td>';
					echo '<td>' . (($data["stock_bar"] ?? 0)) . '</td>';
					echo '<td>' . (($data["stock_pastry"] ?? 0)) . '</td>';
					echo '<td>' . $_SESSION['nama_user'] . '</td>';
					echo '<td>' . '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_opname&form=edit&id=' . $data['kode_part'] . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;' . '</td>';
					// echo '<td>';
					// echo '<a class="btn btn-primary btn-xs" title="Edit" href="?module=form_part&form=edit&id=' . $data['kode_part']  . '"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
					// echo "<a class='btn btn-danger btn-xs hapus' title='Hapus' data-id='". $data['kode_part'] . "' onclick='deletePart(\"$data[kode_part]\", \"$data[nama_part]\");'><i class='glyphicon glyphicon-trash'></i></a>&nbsp;";
					// echo '</a>';
					// echo '</td>';
						
					echo '</tr>';
					$no++;
				}
			  ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content

