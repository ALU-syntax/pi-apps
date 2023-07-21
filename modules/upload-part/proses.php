<?php
session_start();
// include '../../config/database.php
	require_once "../../config/database.php";
    
    include '../../vendor/PhpExcel-1.8/Classes/PHPExcel/IOFactory.php';

	$inputFileType = 'Excel5';
	
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);

	error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
	function priceclean($price)
	{
		$price = str_replace(",", "", $price);
		return $price;
	}

	$objPHPExcel = $objReader->load($_FILES['file']['tmp_name']);
	$objWorksheet = $objPHPExcel->setActiveSheetIndexbyName('Sheet1');

	for($i=2;$i<= $objWorksheet->getHighestRow();$i++){
	    
        $kode_part = $objWorksheet->getCell('A' . $i)->getValue();
        $nama_part = $objWorksheet->getCell('B' . $i)->getValue();
        $group = $objWorksheet->getCell('C' . $i)->getValue();
        $kategori = $objWorksheet->getCell('D' . $i)->getValue();
        $satuan = $objWorksheet->getCell('E' . $i)->getValue();
        $stok = $objWorksheet->getCell('F' . $i)->getValue();
        $stok_level = $objWorksheet->getCell('G' . $i)->getValue();
        $kode_suplier = $objWorksheet->getCell('H' . $i)->getValue();
        $harga = priceclean($objWorksheet->getCell('I' . $i)->getValue());

		$created_user = $_SESSION['id_user'];

	    $query = mysqli_query($mysqli, "SELECT * FROM is_part WHERE kode_part='$kode_part'");
	    
// 		print_r($kode_part);exit;
        if(isset($kode_part)){
    	    if(mysqli_num_rows($query)!=0){
    	        mysqli_query($mysqli, "UPDATE is_part SET stok = '$stok', stok_level = '$stok_level', kode_suplier = '$kode_suplier', harga = '$harga' WHERE kode_part='$kode_part'") or throws("Error on \modules\upload-part\proses.php, line :31\n".mysqli_error($mysqli));; 
    	    }
    	    else{
    	        mysqli_query($mysqli, "INSERT INTO is_part(kode_part, kode_suplier, nama_part, `group`, kategori, satuan, harga, stok, stok_level, created_user, updated_user) 
    		    VALUES('$kode_part','$kode_suplier','$nama_part', '$group','$kategori','$satuan', '$harga','$stok','$stok_level','$created_user','$created_user')") or  throws("Error on \modules\upload-part\proses.php, line :d\n".mysqli_error($mysqli));
    	    }
            
        }
	}
	
	echo "<meta http-equiv='refresh' content='0; url=../../main.php?module=upload_part&alert=1'>";
?>