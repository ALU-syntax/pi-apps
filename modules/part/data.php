<?php
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

		// nama table
		$table = 'is_part';
		// Table's primary key
		$primaryKey = 'kode_part';

		$columns = array(
			array( 
				'db' => 'kode_part', 
				'dt' => 1 ),
			array(
				'db' => 'nama_part',
				'dt' => 2,),
			array( 
				'db' => 'group', 
				'dt' => 3 ),
			array(
				'db' => 'kategori',
				'dt' => 4 ),
			array(
				'db' => 'stok',
				'dt' => 5 ,
				'formatter' => function( $d, $row ) {
					return number_format($d);
				}),
			array(
				'db' => 'stok_level',
				'dt' => 6 ,
				'formatter' => function( $d, $row ) {
					return number_format($d);
				}),	
			array(
				'db' => 'satuan',
				'dt' => 7 )

		);

		// SQL server connection information
		require_once "../../config/database.php";
		// ssp class
		require '../../config/ssp.class.php';
		// require 'config/ssp.class.php';

		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
	} else {
		echo '<script>window.location="index.php"</script>';
	}
?>