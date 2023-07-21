<?php
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

		// nama table
		$table = 'is_sales';
		// Table's primary key
		$primaryKey = 'no';

		$columns = array(
			array(
				'db' => 'no',
				'dt' => 1,),
			array( 
				'db' => 'resto', 
				'dt' => 2 ),
			array(
				'db' => 'tanggal',
				'dt' => 3 ),
			array(
				'db' => 'qty',
				'dt' => 4 ),
			array(
				'db' => 'value',
				'dt' => 5 ),	
				
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