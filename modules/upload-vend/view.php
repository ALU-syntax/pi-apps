<!-- tampilan form add data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Upload Data Suplier
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=upload_vend"> Upload Data Suplier </a></li>
      <li class="active"> Upload </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row"> 
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" method="post" action="modules/upload-vend/proses.php" enctype="multipart/form-data">  <!--action="modules/part-masuk/proses.php?act=insert" method="POST" --> 
            <div class="box-body">
              

              <div class="form-group">
                <label class="col-sm-2 control-label">File xls</label>
                <div class="col-sm-5">
                  <input type="file" class="form-control" name="file" required>
                </div>
              </div>

			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-primary btn-submit" value="Upload">
					<a href="?module=upload_vend" class="btn btn-default btn-reset">Batal</a>
                </div>
			  </div>
              
			</div><!-- /.box footer -->
				
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->