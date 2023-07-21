<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-money icon-title"></i> Data Sales
    <a class="btn btn-primary btn-social pull-right" href="?module=form_sales&form=add" title="Tambah Data" data-toggle="tooltip">
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
    // jika alert = "" (kosong) tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data Sales baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) { ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Sales baru berhasil disimpan.
    </div>
    <?php }
    // jika alert = 2
    // tampilkan pesan Sukses "Data Sales berhasil diubah"
    elseif ($_GET['alert'] == 2) { ?>
      <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Sales berhasil diubah.
            </div>
    <?php }
    // jika alert = 3
    // tampilkan pesan Sukses "Data Sales berhasil dihapus"
    elseif ($_GET['alert'] == 3){ ?>
    <div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
      Data Sales berhasil dihapus.
    </div>
    <?php } ?>

      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel part -->
          <table id="data-sales" class="table table-bordered table-striped table-hover table-condensed" width="100%">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
				<th class="center">Kode Sales</th>
                <th class="center">Resto</th>
                <th class="center">Tanggal</th>
                <th class="center">Qty</th>
                <th class="center">Value</th>
                <th></th>
              </tr>
            </thead>
            
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content

