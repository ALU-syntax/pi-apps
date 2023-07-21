<?php
    include '../../config/database.php';
    
    include '../../vendor/PhpExcel-1.8/Classes/PHPExcel/IOFactory.php';

	$inputFileType = 'Excel5';
	
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);

	
	$objPHPExcel = $objReader->load($_FILES['file']['tmp_name']);
	$objWorksheet = $objPHPExcel->setActiveSheetIndexbyName('Sheet1');

    

	for($i=2;$i<= $objWorksheet->getHighestRow();$i++){
	    
	    $kode =  $objWorksheet->getCell('A' . $i)->getValue();
	    $nama =  $objWorksheet->getCell('B' . $i)->getValue();
	    $alamat = $objWorksheet->getCell('C' . $i)->getValue();
	    $telepon = $objWorksheet->getCell('D' . $i)->getValue();
	    $email = $objWorksheet->getCell('E' . $i)->getValue();
	    $no_rekening = $objWorksheet->getCell('F' . $i)->getValue();
	    $pic = $objWorksheet->getCell('G' . $i)->getValue();
	    $top = $objWorksheet->getCell('H' . $i)->getValue();
	    
	    mysqli_query($mysqli, "INSERT INTO is_suplier(
			kode,
			nama,
			alamat,
			telepon,
			email,
			no_rekening,
			pic, 
			top) 
		VALUES( 
			'" . $kode . "',
			'" . $nama . "', 
			'" . $alamat . "',
			'" . $telepon . "',
			'" . $email . "', 
			'" . $no_rekening . "',
			'" . $pic . "', 
			" . $top . ")") or  throws("Error on \modules\upload-vend\proses.php, line :29\n".mysqli_error($mysqli));
	}
	
	echo "<meta http-equiv='refresh' content='0; url=../../main.php?module=upload_vend&alert=1'>";
?>