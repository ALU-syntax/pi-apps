<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Data Stok Level
    <a class="btn btn-primary btn-social pull-right" href="?module=form_stok_level&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data part baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) { ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4><i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data part baru berhasil disimpan.
    </div>
    <?php }
    // jika alert = 2
    // tampilkan pesan Sukses "Data part berhasil diubah"
    elseif ($_GET['alert'] == 2) { ?>
      <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data part berhasil diubah.
            </div>
    <?php }
    // jika alert = 3
    // tampilkan pesan Sukses "Data part berhasil dihapus"
    elseif ($_GET['alert'] == 3){ ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data part berhasil dihapus.
    </div>
    <?php } ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel part -->
          <table id="dataTables2" class="table table-bordered table-striped table-hover table-condensed">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode part</th>
                <th class="center">Nama part</th>
                <th class="center">Min Stok</th>
                <th class="center">Max Stok</th>
                <th class="center">Satuan</th>
                <th></th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel part
            $query = mysqli_query($mysqli, "SELECT 
												a.kode_part, 
												a.nama_part, 
												b.min_stok,
												b.max_stok,
												a.satuan 
											FROM is_part a inner join is_part_level b
											ON a.kode_part = b.kode_part
											ORDER BY a.kode_part asc")
                                            or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
          
            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) { 
              //$harga_beli = format_rupiah($data['harga_beli']);
              //$harga_jual = format_rupiah($data['harga_jual']); ?>
            
            <tr>
                  <td width='30' class='center'><?php echo $no; ?></td>
                  <td width='80' class='center'><?php echo $data['kode_part']; ?></td>
                  <td width='180' class='left'><?php echo $data['nama_part']; ?></td>
                  <td width='80' align='right'><?php echo $data['min_stok']; ?></td>
                  <td width='80' align='right'><?php echo $data['max_stok']; ?></td>
                  <td width='80' class='center'><?php echo $data['satuan']; ?></td>
                  <td class='center' width='80'>
                    <div>
                      <a data-toggle="tooltip" data-placement="top" title="Ubah" style="margin-right:5px" class="btn btn-primary btn-xs" href="?module=form_stok_level&form=edit&id=<?php echo $data['kode_part'];?>" >
                          <i style="color:#fff" class="glyphicon glyphicon-edit" ></i>
                      </a>
                      
                      <a data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-xs" href="modules/stok-level/proses.php?act=delete&id=<?php echo $data['kode_part'];?>" onclick="return confirm('Anda yakin ingin menghapus part <?php echo $data['kode_part'];?> ?');" >
                          <i style="color:#fff" class="glyphicon glyphicon-trash" ></i>
                      </a>
                    </div>
                </td>
            </tr>
              <?php $no++; }?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content

