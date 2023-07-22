<?php
	// deklarasi parameter koneksi database
	// $sql_details = array(
	// 	'user' => 'yoom8124_root',
	// 	'pass' => 'YsUMaZ.1O9xx',
	// 	'db'   => 'yoom8124_piapps',
	// 	'host' => '127.0.0.1',
	// 	'port' => 3306
	// );

	$sql_details = array(
		'user' => 'root',
		'pass' => '',
		'db'   => 'yoom8124_piapps',
		'host' => '127.0.0.1',
		'port' => 3306
	);

	function throws($message = null) {
		throw new Exception($message);
	}

	// koneksi database
	$mysqli = mysqli_connect($sql_details['host'], $sql_details['user'], $sql_details['pass'], $sql_details['db'], $sql_details['port']);

	// cek koneksi
	if ($mysqli->connect_error) {
		die('Koneksi Database Gagal : '.$mysqli->connect_error);
	}
?>