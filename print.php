<?php
    session_start();

	/* panggil file database.php untuk koneksi ke database */
	require_once "config/database.php";
	/* panggil file fungsi tambahan */
    //require_once "config/fungsi.php";

	// fungsi untuk pengecekan status login user, jika user belum login, alihkan ke halaman login dan tampilkan message = 1
	if (empty($_SESSION['username']) || empty($_SESSION['password'])){
		echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
	}
	// jika user sudah login, maka jalankan perintah untuk pemanggilan file halaman konten
	else{
		switch($_GET['module']){
            case 'print_part_request' : 
                include 'modules/part-request/print.php'; 
                break;
		}
	}
?>