<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>.:: P&I Apps ::.</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Aplikasi Spare Resto">
    <meta name="author" content="Bachtiar Yanuari" />
    
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png" />

    <!-- Bootstrap 3.3.7 -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />   
	
    <!-- FontAwesome 4.3.0 -->
    <link href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />  
	
    <!-- Sweetalert CSS -->
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" >
    
    <!-- DATA TABLES -->
    <!--<link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />-->
    <link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/colReorder.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />
	
    <!-- Datepicker -->
    <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css" />
	
    <!-- Chosen Select -->
    <link href="assets/plugins/chosen/css/chosen.min.css" rel="stylesheet" type="text/css" />
	
    <!-- Theme style -->
    <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />  
    <link href="assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link href="assets/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
		
    <!-- Custom CSS  -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" /> 
    
    
    <!-- jQuery 3.3.1  -->
    <script src="assets/plugins/jQuery/jquery-3.3.1.min.js"></script> 
    
    <!-- Fungsi untuk membatasi karakter yang diinputkan -->
    <script language="javascript">
      function getkey(e){
        if (window.event)
          return window.event.keyCode;
        else if (e)
          return e.which;
        else
          return null;
      }

      function goodchars(e, goods, field){
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;
       
        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();
       
        // check goodkeys
        if (goods.indexOf(keychar) != -1)
            return true;
        // control keys
        if ( key==null || key==0 || key==8 || key==9 || key==27 )
          return true;
          
        if (key == 13) {
          var i;
          for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i])
              break;
          i = (i + 1) % field.form.elements.length;
          field.form.elements[i].focus();
          return false;
        };
        // else return false
        return false;
      }
    </script>

  </head>
  <body class="hold-transition skin-blue sidebar_collapsed">
    <div class="wrapper">
		
		<!-- Main Header -->
		<header class="main-header">
        
		<!-- Logo -->
        <a href="?module=beranda" class="logo">
         
          <span class="logo-lg"> 
			  <img style="margin-top:-15px;margin-right:5px" src="assets/img/logo-blue.png">
			  <b>P&I Apps</b>
		  </span>
        </a>
		
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle"  data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- panggil file "top-menu.php" untuk menampilkan menu -->
              <?php include "top-menu.php" ?>
            </ul>
          </div>
        </nav>
      </header>
		
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
			    <!-- sidebar menu start -->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN MENU</li>
					<?php 
						// fungsi pengecekan level untuk menampilkan menu sesuai dengan hak akses
						// panggil file "menu-[akses].php" untuk menampilkan menu
						switch($_SESSION['hak_akses'])
						{
							case 'Super Admin':
								include "side-menu-admin.php"; break;
								
							case 'Manajer':
								include "side-menu-manager.php"; break;
								
							case 'Gudang':
								include "side-menu-gudang.php"; break;
								
							case 'Finance':
							    include "side-menu-finance.php"; break;
							
							case 'Purchasing':
							    include "side-menu-purchasing.php"; break;
						}				
					?>
				</ul>
				<!--sidebar menu end-->
			</section>
		</aside> <!-- /.sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" id="content_area">
        <!-- panggil file "content-menu.php" untuk menampilkan content -->
        <?php include "content.php" ?>
		
        <!-- Modal Logout -->
        <div class="modal fade" id="logout">
          <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-sign-out"> Logout</i></h4>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin logout? </p>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" href="logout.php">Ya, Logout</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      </div><!-- /.content-wrapper -->

      <!--<footer class="main-footer">
        <strong>Copyright &copy; 2018</strong>
      </footer>
      -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 
    <script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>-->
	
    <!-- Bootstrap 3.3.7 JS -->
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script> 
	
    <!-- AdminLTE App -->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
	
    <!-- datepicker
		<script src="assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script> -->
	 
    <!-- chosen select -->
    <script src="assets/plugins/chosen/js/chosen.jquery.min.js"></script>
	
    <!-- SweetAlert Plugin JS -->
    <script type="text/javascript" src="assets/plugins/sweetalert/sweetalert.min.js"></script>
	
    <!-- DATA TABES SCRIPT -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/dataTables.colReorder.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/dataTables.rowGroup.min.js" type="text/javascript"></script>
    
    <!-- DATA TABES BUTTON SCRIPT -->
    <script src="assets/plugins/datatables/button/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/button/buttons.colVis.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/button/buttons.flash.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jsZip/jszip.min.js" type="text/javascript"></script>
    <script src="assets/plugins/pdfmake/pdfmake.min.js" type="text/javascript"></script>
    <script src="assets/plugins/pdfmake/vfs_fonts.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/button/buttons.html5.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/button/buttons.print.min.js" type="text/javascript"></script>

    <!-- Datepicker -->
    <script src="assets/plugins/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
	
    <!-- Slimscroll -->
    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	
    <!-- FastClick -->
    <script src="assets/plugins/fastclick/fastclick.min.js"></script>
	
    <!-- maskMoney -->
    <script src="assets/js/jquery.maskMoney.min.js"></script>
	
    <!-- page script -->
    <script type="text/javascript">
    
        
    
		function deleteSales(val, name){
			// tampilkan notifikasi saat akan menghapus data
			if( confirm('Anda yakin ingin menghapus Sales : \n'+  val + " : "+ name) ){
				var no = val;
				$.ajax({
					type : "POST",
					url  : "modules/sales/proses.php",
					data : { no : no , act : "delete" },
					success: function(result){    
						if (result==="sukses") {
							window.location.href  = "?module=sales&alert=3";
						} 
						else
						{
							alert(result);
						}
					}
				});
			}
		}
		
		function deleteVend(val, name){
			// tampilkan notifikasi saat akan menghapus data
			if( confirm('Anda yakin ingin menghapus Vendor : \n'+  val + " : "+ name) ){
				var no = val;
				$.ajax({
					type : "POST",
					url  : "modules/vend/proses.php",
					data : { no : no , act : "delete" },
					success: function(result){    
						if (result==="sukses") {
							window.location.href  = "?module=vend&alert=3";
						} 
						else
						{
							//location.reload();
						}
					}
				});
			}
		}
		
		function getCount(no){
			var table = $(no).dataTable();
			return table.api()
				.column( 0 )
				.data()
				.length;
		}
		function deletePart(val, name){
			// tampilkan notifikasi saat akan menghapus data
			if( confirm('Anda yakin ingin menghapus part : \n'+  val + " : "+ name) ){
				var id = val;
				$.ajax({
					type : "POST",
					url  : "modules/part/proses.php",
					data : { id : id , act : "delete" },
					success: function(result){    
						if (result==="sukses") {
							window.location.href  = "?module=part&alert=3";
						} 
						else
						{
							alert(result);
						}
					}
				});
			}
		}
	
		function getCount(id){
			var table = $(id).dataTable();
			return table.api()
				.column( 0 )
				.data()
				.length;
		}
	 
		$(function () {
			divW = $("#content_area").width();
			setInterval(function(){
				var w = $("#content_area").width();
				if (w != divW) {
					$(".table").dataTable().api().columns.adjust();
					divW = w;
				}       
			},200);
		
        // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
		  multidate: false,
        });

        // chosen select
        $('.chosen-select').chosen({allow_single_deselect:true}); 
        //resize the chosen on window resize
        
        // mask money
        $('#harga_beli').maskMoney({thousands:'.', decimal:',', precision:0});
        //  $('#value').maskMoney({thousands:'.', decimal:',', precision:0});
       
        //  $('#stok_level').maskMoney({thousands:'.', decimal:',', precision:0});
         var stok = $('#stok').val() == '' ? 0 : $('#stok').val();
   
       
        $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
          $('.chosen-select').each(function() {
             var $this = $(this);
             $this.next().css({'width': $this.parent().width()});
          })
        }).trigger('resize.chosen');
		
        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
          if(event_name != 'sidebar_collapsed') return;
          $('.chosen-select').each(function() {
             var $this = $(this);
             $this.next().css({'width': $this.parent().width()});
          })
        });
    
        $('#chosen-multiple-style .btn').on('click', function(e){
          var target = $(this).find('input[type=radio]');
          var which = parseInt(target.val());
          if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
          else $('#form-field-select-4').removeClass('tag-input-style');
        });
		
		// dataTables plugin
		$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings){
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};
		
    // DataTables
		var tableSales = $("#data-sales").DataTable({
			dom: 'lBfrtip',
			colReorder: true,
			scrollY: '55vh',
			scrollCollapse: true,
			pagingType: "full_numbers",
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
			processing: true,
			serverSide: true,
			responsive: true,
			deferRender: true,
			ajax: 'modules/sales/data.php',  
			paging : true,	
			lengthMenu : [[100, 500, 1000, -1], [100, 500, 1000, "All"]],			
			columnDefs: [ 
				{ "targets": 0, "data": null,  "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
				{ "targets": 1, "width": '8px', "className": 'center' },
				{ "targets": 2, "width": '50px' },
				{ "targets": 3, "width": '70px' },
				{ "targets": 4, "width": '70px' },
				{ "targets": 5, "width": '70px', "data": null, "render": function(data, type, row){
				        return 'Rp. ' + data[5].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				    } 
				},
				{ "targets": 6, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center',
				  "render": function(data, type, row) {
					  return "<a style='margin-right:5px' title='Ubah' class='btn btn-primary btn-xs getUbah' href='javascript:void(0);' ><i style='color:#fff' class='glyphicon glyphicon-edit'></i></a><a title='Hapus' class='btn btn-danger btn-xs getDel' onClick=\"deleteSales(\'"+data[1]+"\' , \'"+ data[2]+ "\');\" href='javascript:void(0);'><i style='color:#fff' class='glyphicon glyphicon-trash'></i></a>";
				  } 
				}  
			],
			order: [[ 1, "asc" ]],           
			iDisplayLength: 100,  // tampilkan 10 data
			/*rowCallback: function (row, data, displayNum, iDisplayIndex, dataIndex) {
				var info   = this.fnPagingInfo();
				var index  = info.iPage * info.iLength + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(iDisplayIndex);
			},*/
			createdRow: function( row, data, dataIndex ) {
				var info   = this.fnPagingInfo();
				var index  =  (info.iPage * info.iLength ) +  (dataIndex + 1);
				$('td:eq(0)', row).html(index);
			}
		});	
		var tablePart = $("#data-part").DataTable({
			dom: 'lBfrtip',
			colReorder: true,
			scrollY: '55vh',
			scrollCollapse: true,
			pagingType: "full_numbers",
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
			processing: true,
			serverSide: true,
			responsive: true,
			deferRender: true,
			ajax: 'modules/part/data.php',  
			paging : true,	
			lengthMenu : [[100, 500, 1000, -1], [100, 500, 1000, "All"]],			
			columnDefs: [ 
				{ "targets": 0, "data": null,  "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
				{ "targets": 1, "width": '50px', "className": 'center' },
				{ "targets": 2, "width": '280px' },
				{ "targets": 3, "width": '70px' },
				{ "targets": 4, "width": '70px' },
				{ "targets": 5, "width": '70px', "data": null, "render": function(data, type, row){
				        return data[5].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				    } 
				},
				{ "targets": 6, "width": '30px', "className": 'right' },
				{ "targets": 7, "width": '30px' },
				{ "targets": 8, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center',
				  "render": function(data, type, row) {
					  return "<a style='margin-right:5px' title='Ubah' class='btn btn-primary btn-xs getUbah' href='javascript:void(0);' ><i style='color:#fff' class='glyphicon glyphicon-edit'></i></a><a title='Hapus' class='btn btn-danger btn-xs getDel' onClick=\"deletePart(\'"+data[1]+"\' , \'"+ data[2]+ "\');\" href='javascript:void(0);'><i style='color:#fff' class='glyphicon glyphicon-trash'></i></a>";
				  } 
				} 
			],
			order: [[ 1, "asc" ]],           
			iDisplayLength: 100,  // tampilkan 10 data
			/*rowCallback: function (row, data, displayNum, iDisplayIndex, dataIndex) {
				var info   = this.fnPagingInfo();
				var index  = info.iPage * info.iLength + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(iDisplayIndex);
			},*/
			createdRow: function( row, data, dataIndex ) {
				var info   = this.fnPagingInfo();
				var index  =  (info.iPage * info.iLength ) +  (dataIndex + 1);
				$('td:eq(0)', row).html(index);
			}
		});
    
    var tableVend = $("#data-vend").DataTable({
			dom: 'lBfrtip',
			colReorder: true,
			scrollY: '55vh',
			scrollCollapse: true,
			pagingType: "full_numbers",
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
			processing: true,
			serverSide: true,
			responsive: true,
			deferRender: true,
			ajax: 'modules/vend/data.php',  
			paging : true,	
			lengthMenu : [[100, 500, 1000, -1], [100, 500, 1000, "All"]],			
			columnDefs: [ 
				{ "targets": 0, "data": null,  "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
				{ "targets": 1, "width": '50px', "className": 'center' },
                { "targets": 2, "width": '90px' },
				{ "targets": 3, "width": '200px' },
				{ "targets": 4, "width": '70px' },
				{ "targets": 5, "width": '70px' },
				{ "targets": 6, "width": '70px' },
				{ "targets": 7, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center',
				  "render": function(data, type, row) {
					  return "<a style='margin-right:5px' title='Ubah' class='btn btn-primary btn-xs getUbah' href='javascript:void(0);' ><i style='color:#fff' class='glyphicon glyphicon-edit'></i></a><a title='Hapus' class='btn btn-danger btn-xs getDel' onClick=\"deleteVend(\'"+data[1]+"\' , \'"+ data[2]+ "\');\" href='javascript:void(0);'><i style='color:#fff' class='glyphicon glyphicon-trash'></i></a>";
				  } 
				} 
			],
			order: [[ 1, "asc" ]],           
			iDisplayLength: 100,  // tampilkan 10 data
			/*rowCallback: function (row, data, displayNum, iDisplayIndex, dataIndex) {
				var info   = this.fnPagingInfo();
				var index  = info.iPage * info.iLength + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(iDisplayIndex);
			},*/
			createdRow: function( row, data, dataIndex ) {
				var info   = this.fnPagingInfo();
				var index  =  (info.iPage * info.iLength ) +  (dataIndex + 1);
				$('td:eq(0)', row).html(index);
			}
		});
				
    $('#dataTables2').dataTable({
			dom: 'lBfrtip',
			"paging": true,
			"pagingType": "full_numbers",
			"lengthChange": true,
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			scrollY: '55vh',
			scrollCollapse: true,
			colReorder: true,
			responsive: true,
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
    });
		
		$('#dataTables-group').dataTable({
			dom: 'lBfrtip',
			"paging": true,
			"pagingType": "full_numbers",
			"lengthChange": true,
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			scrollY: '48vh',
			scrollCollapse: true,
			colReorder: true,
			responsive: true,
			lengthMenu : [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
			orderFixed: [[3, 'asc']],
			rowGroup: {
				dataSrc: 3
			}
    });
		
		$('#dataTables-group2').dataTable({
			dom: 'lBfrtip',
			"paging": true,
			"pagingType": "full_numbers",
			"lengthChange": true,
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			scrollY: '48vh',
			scrollCollapse: true,
			colReorder: true,
			responsive: true,
			lengthMenu : [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
			buttons: [  'colvis','copyHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
			orderFixed: [[2, 'asc']],
			rowGroup: {
				dataSrc: 3
			}
    });
		
		$('#table-temp').dataTable({
			"paging": false,
			"lengthChange": false,
			"bFilter": false,
			"bSort": false,
			"bInfo": false,
			responsive: true
    });
		$('#data-sales tbody').on( 'click', '.getUbah', function (){
			var data = tableSales.row( $(this).parents('tr') ).data();
			var no = data[ 1 ];
			window.location.href  = "?module=form_sales&form=edit&no="+no;
		});
		
		$('#data-part tbody').on( 'click', '.getUbah', function (){
			var data = tablePart.row( $(this).parents('tr') ).data();
			var id = data[ 1 ];
			window.location.href  = "?module=form_part&form=edit&id="+id;
		});
		
		$('#data-vend tbody').on( 'click', '.getUbah', function (){
			var data = tableVend.row( $(this).parents('tr') ).data();
			var id = data[ 1 ];
			window.location.href  = "?module=form_vend&form=edit&id="+id;
		});
		
		var tmpRecLine = $("#table-rec-temp").DataTable({
			"paging": false,
			"lengthChange": false,
			"bFilter": false,
			"bSort": false,
			"bInfo": false,
			processing: true,
			serverSide: true,
			responsive: true,
			ajax: 'modules/Penerimaan-Barang/part.php',  
			columnDefs: [ 
				{ "targets": 0, "data": null,  "orderable": false, "searchable": false, "width": '10%', "className": 'center' },
				{ "targets": 1, "data": 2, "width": '10%', "className": 'center' },
				{ "targets": 2, "data": 3, "width": '40%' },
				{ "targets": 3, "width": '10%' ,
					"render" : function(data,type,row){
						return "<input type='text' class='form-control right updateRow money' style='width:100%' value= "+"\'"+row[4]+"\' onKeyPress=\"return goodchars(event,'.0123456789',this)\" data-field='qty' data-id= "+row[1]+">";
					}
				},
				{ "targets": 4,"data": 5, "width": '10%', "className": 'center' },
				{ "targets": 5, "data": null, "orderable": false, "searchable": false, "width": '10%', "className": 'center',
				  "render": function(data, type, row) {
					  return "<a data-toggle='tooltip' data-placement='top' title='Hapus' class='btn btn-danger btn-sm removeRow' data-id= "+row[1]+">"+
							"<i style='color:#fff' class='glyphicon glyphicon-trash' ></i></a>" ;
				  } 
				} 
			],
			order: [[ 1, "asc" ]], 
			/*rowCallback: function (row, data, displayNum, iDisplayIndex, dataIndex) {
				var info   = this.fnPagingInfo();
				var index  = info.iPage * info.iLength + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(iDisplayIndex);
			},*/
			createdRow: function( row, data, dataIndex ) {
				var info   = this.fnPagingInfo();
				var index  =  (info.iPage * info.iLength ) +  (dataIndex + 1);
				$('td:eq(0)', row).html(index);
			}
		});
		
		$('#table-rec-temp tbody').on('change','input.updateRow', function ( ) {
			var id= (this).getAttribute("data-id");
			var field= (this).getAttribute("data-field");
			$.post("modules/Penerimaan-Barang/proses.php",{
					act: "update",
					id : id,
					table : "is_temp_in",
					field : field,
					value : this.value
				},
				function(result,status){  // ketika sukses menyimpan data
					//alert(result);
					var data = JSON.parse(result);
					if (data.error){
						// tampilkan pesan gagal simpan data
						swal("Gagal!", data.error.message, "error");
					} 
				}
			);	
		});
		
		$('#table-rec-temp tbody').on('click','.removeRow', function ( ) {
			var id= (this).getAttribute("data-id");
			$.post("modules/Penerimaan-Barang/proses.php",{
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
						//location.reload();
						//var table = $('#dataTables3').DataTable(); 
						tmpRecLine.ajax.reload( null, false );						   
					}
				}
			);
		});
		
		/*
		$('#data-part tbody').on( 'click', '.getDel', function (){
			var data = tablePart.row( $(this).parents('tr') ).data();
			// tampilkan notifikasi saat akan menghapus data
			if( confirm('Anda yakin ingin menghapus part : '+  data[ 1 ] ) )
			{
				var id = data[ 1 ];
				$.ajax({
					type : "POST",
					url  : "modules/part/proses.php",
					data : { id : id , act : "delete" },
					success: function(result){    
						if (result==="sukses") {
							window.location.href  = "?module=part&alert=3";
							
						} 
						else
						{
							alert(result);
						}
					}
				});
			}
		});*/
	});	  
    </script>
  </body>
</html>