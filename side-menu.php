<?php 
$listMenu = array(
			"beranda" => "",
			"sales" => "",
			"setting" => " class='treeview'",
			"upload_part" => "",
			"upload_vend" => "",
			"upload_sales" => "",
			"master" => " class='treeview' ",
			"part" => "",
			"produk" => "",
      	  	"vend" => "",
			"biaya" => "",
			"hutang" => "",
			"cash" => "",
			"request" => "",
			"mutasi" => "",
			"mutasi_keluar" => "",
			"approval" => "",
			"laporan" => " class='treeview' ",
			"lap_stok" => "",
			"lap_mutasi" => "",
			"lap_rugilaba" => "",
			"password" => "",
			"user" => "" );
		
	switch($_GET["module"]){
		case "beranda":
			$listMenu["beranda"] = ' class="active" '; 
      	  	break;
		case "sales":
		case "form_sales":
			$listMenu["sales"] = ' class="active" '; 
      	  	break;

		case "item":
		case "form_item":
			$listMenu["master"] = '  class="treeview menu-open active"  ';
			$listMenu["part"] = ' class="treeview active" '; 
      	  	break;

		case "produk":
		case "form_produk":
			$listMenu["master"] = '  class="treeview menu-open active"  ';
			$listMenu["produk"] = ' class="treeview active" '; 
      	  	break;
      
    	case "vend":
		case "form_vend":
			$listMenu["master"] = '  class="treeview menu-open active"  ';
			$listMenu["vend"] = ' class="treeview active" ';
      	  	break;

		case "resto":
			$listMenu["master"] = '  class="treeview menu-open active"  ';
			$listMenu["resto"] = ' class="treeview active" ';
      	  	break;
			
		case "biaya":
		case "form_biaya":
			$listMenu["biaya"] = ' class="active" '; 
      	  	break;
			
		case "part_request":
		case "form_part_request":
			$listMenu["request"] = ' class="active" '; 
      	  	break;
			
		case "part_masuk":
		case "form_part_masuk":
			$listMenu["mutasi"] = ' class="active" '; 
			break;
			
		case "part_keluar":
		case "form_part_keluar":
		    $listMenu['mutasi_keluar'] = ' class="active" ';
		    break;
			
		case "approval":
		case "form_approval":
		    $listMenu["approval"] = ' class="active" ';
		    break;
			
		case "lap_stok":
			$listMenu["laporan"] = '  class="treeview menu-open active"  ';
			$listMenu["lap_stok"] = ' class="treeview active" ';
			break;
			
		case "lap_part_masuk":
			$listMenu["laporan"] = '  class="treeview menu-open active"  ';
			$listMenu["lap_mutasi"] = ' class="treeview active" ';
			break;

		case "item_opname":
			$listMenu["laporan"] = '  class="treeview menu-open active"  ';
			$listMenu["item_opname"] = ' class="treeview active" ';
			break;	
			
		case "lap_rugilaba":
			$listMenu["laporan"] = '  class="treeview menu-open active"  ';
			$listMenu["lap_rugilaba"] = ' class="treeview active" ';
			break;	
			
		case "user":
		case "form_user":
			$listMenu["user"] = ' class="treeview active" '; 
			break;
			
		case "password":
			$listMenu["password"] = ' class="treeview active" '; 
			break;
	}
	// fungsi pengecekan level untuk menampilkan menu sesuai dengan hak akses
	switch($_SESSION['hak_akses'])
	{
		case 'Super Admin':
			include_once "side-menu-admin.php"; break;
			
		case 'Manajer':
			include_once "side-menu-manager.php"; break;
			
		case 'Gudang':
			include_once "side-menu-gudang.php"; break;
		
		case 'Finance':
		    include_once "side-menu-finance.php"; break;
		
		case 'Purchasing':
		    include_once "side-menu-purchasing.php"; break;
		    
		
	}
?>