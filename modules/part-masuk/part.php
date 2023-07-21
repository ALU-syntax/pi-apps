
<?php
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

		// nama table
		$table = 'is_temp_in';
		// Table's primary key
		$primaryKey = 'id';
		
		$columns = array(
			array(
				'db' => 'id',
				'dt' => 1),
			array( 
				'db' => 'itemId', 
				'dt' => 2 ),
			array(
				'db' => 'name',
				'dt' => 3 ),
			array(
				'db' => 'qty',
				'dt' => 4 ),
			array(
				'db' => 'unitId',
				'dt' => 5 )
		);
		
		// SQL server connection information
		require_once "../../config/database.php";
		// ssp class
		require '../../config/ssp.class.php';
		// require 'config/ssp.class.php';

		$where = "originTable='is_purchLine'";
		echo json_encode(
			SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null, $where )
		);
	} else {
		echo '<script>window.location="index.php"</script>';
	}
?>