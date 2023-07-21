<?php
	/* panggil file database.php untuk koneksi ke database */
	require_once "config/database.php";
	/* panggil file fungsi tambahan */
	require_once "config/fungsi.php";

	// fungsi untuk pengecekan status login user, jika user belum login, alihkan ke halaman login dan tampilkan message = 1
	if (empty($_SESSION['username']) || empty($_SESSION['password'])){
		echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
	}
	// jika user sudah login, maka jalankan perintah untuk pemanggilan file halaman konten
	else{
		switch($_GET['module']){
			// jika halaman konten yang dipilih beranda, panggil file view beranda
			case 'beranda': include "modules/beranda/view.php"; break;
			
			case "upload_vend" : include "modules/upload-vend/view.php"; break;
			
			case "upload_part" : include "modules/upload-part/view.php"; break;
			
			case "upload_sales" : include "modules/upload-sales/view.php"; break;
			
			// jika halaman konten yang dipilih sales, panggil file view sales
			case 'sales': include "modules/sales/view.php"; break;
			
			// jika halaman konten yang dipilih form sales, panggil file form part
			case  'form_sales' : include "modules/sales/form.php"; break;

			// jika halaman konten yang dipilih part, panggil file view part
			case 'part' : include "modules/part/view.php"; break;

			// jika halaman konten yang dipilih form part, panggil file form part
			case  'form_part' : include "modules/part/form.php"; break;

			// jika halaman konten yang dipilih produk, panggil file view produk
			case 'produk' : include "modules/produk/view.php"; break;
			
			// jika halaman konten yang dipilih form produk, panggil file form produk
			case  'form_produk' : include "modules/produk/form.php"; break;

			// jika halaman konten yang dipilih form produk item, panggil file form produk item
			case  'form_produk_item' : include "modules/produk/form_produk_item.php"; break;
      
      // jika halaman konten yang dipilih vend, panggil file view part
			case 'vend' : include "modules/vend/view.php"; break;
				
			// jika halaman konten yang dipilih form vend, panggil file form vend
			case  'form_vend' : include "modules/vend/form.php"; break;
			
      	  	// jika halaman konten yang dipilih biaya, panggil file biaya
			case 'biaya' : include "modules/biaya/view.php"; break;
				
			// jika halaman konten yang dipilih form vend, panggil file form vend
			case  'form_biaya' : include "modules/biaya/form.php"; break;
			
			// jika halaman konten yang dipilih part, panggil file view part
			case 'stok_level' : include "modules/stok-level/view.php"; break;
				
			// jika halaman konten yang dipilih form part, panggil file form part
			case  'form_stok_level' : include "modules/stok-level/form.php"; break;

			case  'part_request' : include "modules/part-request/view.php"; break;
				
			// jika halaman konten yang dipilih form part, panggil file form part
			case  'form_part_request' : include "modules/part-request/form.php"; break;
				
			// jika halaman konten yang dipilih part masuk, panggil file view part masuk
			case  'part_masuk' : include "modules/part-masuk/view.php"; break;
				
			// jika halaman konten yang dipilih form part masuk, panggil file form part masuk
			case  'form_part_masuk' : include "modules/part-masuk/form.php"; break;
			
			// jika halaman konten yang dipilih form part masuk, panggil file form part masuk
			case  'form_part_masuk_issue' : include "modules/part-masuk/form_issue.php"; break;
			
			case 'part_keluar' : include "modules/part-keluar/view.php"; break;
			case 'form_part_keluar': include 'modules/part-keluar/form.php'; break;
			
			case 'approval' : include "modules/approval/view.php"; break;
			case 'form_approval' : include 'modules/approval/form.php'; break;
				
			// jika halaman konten yang dipilih laporan stok, panggil file view laporan stok
			case  'lap_stok' : include "modules/lap-stok/view.php"; break;
				
			// jika halaman konten yang dipilih laporan part masuk, panggil file view laporan part masuk
			case  'lap_part_masuk' : include "modules/lap-part-masuk/view.php"; break;
			
			// jika halaman konten yang dipilih laporan rugi laba, panggil file view laporan lap rugi laba
			case  'lap_rugilaba' : include "modules/lap-rugilaba/view.php"; break;	
			
			// jika halaman konten yang dipilih user, panggil file view user
			case  'user' : include "modules/user/view.php"; break;
				
			// jika halaman konten yang dipilih form user, panggil file form user
			case  'form_user' : include "modules/user/form.php"; break;
				
			// jika halaman konten yang dipilih profil, panggil file view profil
			case  'profil' : include "modules/profil/view.php"; break;
				
			// jika halaman konten yang dipilih form profil, panggil file form profil
			case  'form_profil' : include "modules/profil/form.php"; break;
				
			// jika halaman konten yang dipilih password, panggil file view password
			case  'password' : include "modules/password/view.php"; break;
			
			case  'test' : include "modules/beranda/test.php"; break;
			
			default : include "modules/beranda/view.php"; break;
		}
	}
?>