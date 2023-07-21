<?php
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

		// nama table
		$table = 'is_suplier';
		// Table's primary key
		$primaryKey = 'kode';

		$columns = array(
			array( 
				'db' => 'kode', 
				'dt' => 1 ),
			array(
				'db' => 'nama',
				'dt' => 2,),
			array( 
				'db' => 'alamat', 
				'dt' => 3 ),
			array(
				'db' => 'telepon',
				'dt' => 4 ),
			array(
				'db' => 'pic',
				'dt' => 5 ),
			array(
				'db' => 'top',
				'dt' => 6 )	
				
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