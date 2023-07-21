<?php 
    require 'vendor/fpdf/fpdf.php';
    
    $pdf = new FPDF();
	$pdf->AddPage();
	$pdf->Image('vendor/fpdf/logo.jpg',160,10,30);
	$pdf->SetFont('Arial','B',12);
    $pdf->Cell(100, 5, 'CV LIBERO BOGA MAKMUR', 0, 1, 'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100, 5, 'Jl. DR. Susilo Raya No. C4 Grogol', 0, 1, 'L');
    $pdf->Cell(100, 5, 'Jakarta Barat 1450', 0, 1, 'L');
    $pdf->Cell(100, 5, 'Phone 021', 0, 1, 'L');

    $kode = $_GET['kode'];
    $query = mysqli_query($mysqli, "SELECT * FROM is_part_req WHERE kode_request='" . $kode . "'");
    
    $data = mysqli_fetch_assoc($query);
    $tanggal = $data['tanggal'];
    $jatuh_tempo = $data['jatuh_tempo'];
    $suplier = $data['suplier'];
    
    $pdf->Cell(40, 5, '', 0, 1, 'L');
    $pdf->Cell(40, 5, 'ORDER TO :', 0, 1, 'L');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40, 5,$suplier, 0, 1, 'L');
    
    $pdf->Cell(100, 5, '', 0, 0, 'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(100, 5, 'PURCHASE ORDER', 0, 1, 'L');
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100, 5, '', 0, 0, 'C');
    $pdf->Cell(30, 5, 'Date', 0, 0, 'L');
    $pdf->Cell(70, 5, date('d-m-Y', strtotime($tanggal)), 0, 1, 'L');
    
    $pdf->Cell(100, 5, '', 0, 0, 'C');
    $pdf->Cell(30, 5, 'Outlet', 0, 0, 'L');
    $pdf->Cell(70, 5, '', 0, 1, 'L');
    
    $pdf->Cell(100, 5, '', 0, 0, 'C');
    $pdf->Cell(30, 5, 'PO NO.', 0, 0, 'L');
    $pdf->Cell(70, 5, $kode, 0, 1, 'L');
    
    $pdf->Cell(8, 7, 'No', 1, 0, 'C'); 
	$pdf->Cell(50, 7, 'Description', 1, 0, 'C');
	$pdf->Cell(15, 7, 'Qty', 1, 0, 'C'); 
	$pdf->Cell(15, 7, 'Uom', 1, 0, 'C'); 
	$pdf->Cell(25, 7, 'Unit Price', 1, 0, 'C'); 
	$pdf->Cell(15, 7, 'Discount', 1, 0, 'C'); 
	$pdf->Cell(10, 7, 'Tax', 1, 0, 'C'); 
	$pdf->Cell(20, 7, 'Total', 1, 0, 'C'); 
	$pdf->Cell(30, 7, 'Remark', 1, 0, 'C'); 
	
	$pdf->Ln();

    $no = 1;
    $subtotal = 0;
    
    $query = mysqli_query($mysqli, "SELECT * FROM is_part_req WHERE kode_request='" . $kode . "'");
    while($data = mysqli_fetch_assoc($query)){
        $pdf->Cell(8, 7,  $no++, 1, 0, 'C'); 
	    $pdf->Cell(50, 7, $data['nama_item'], 1, 0, 'C');
	    $pdf->Cell(15, 7, number_format($data['qty'], 2), 1, 0, 'R'); 
	    $pdf->Cell(15, 7, $data['satuan'], 1, 0, 'C'); 
	    $pdf->Cell(25, 7, number_format($data['harga']), 1, 0, 'R');
	    $pdf->Cell(15, 7, number_format($data['diskon']), 1, 0, 'R'); 
	    $pdf->Cell(10, 7, number_format($data['pajak'], 2), 1, 0, 'R'); 
	    $pdf->Cell(20, 7, number_format($data['jumlah']), 1, 0, 'R'); 
	    $pdf->Cell(30, 7, '', 1, 0, 'C'); 
	
	    $pdf->Ln();
	    
	    $subtotal =  $subtotal + $data['qty'] * $data['harga'];
    }

    $pdf->Cell(138, 7, 'Subtotal', 0, 0, 'R'); 
    $pdf->Cell(20, 7, number_format($subtotal), 1, 0, 'R'); 
    $pdf->Cell(30, 7, '', 1, 1, 'C'); 
    
    $pdf->Cell(8, 7,  '', 0, 0, 'C'); 
    $pdf->Cell(70, 7, 'Note & Instruction', 1, 0, 'L');
    $pdf->Cell(35, 7, 'Tax', 0, 0, 'R'); 
    $pdf->Cell(35, 7, '0', 1, 0, 'R'); 
    $pdf->Cell(40, 7, '', 1, 1, 'C'); 
    
    $pdf->Cell(8, 7,  '', 0, 0, 'C'); 
    $pdf->Cell(40, 7, 'Delivery Date', 1, 0, 'L');
    $pdf->Cell(30, 7, '', 1, 0, 'L');
    $pdf->Cell(35, 7, 'Grandtotal', 0, 0, 'R'); 
    $pdf->Cell(35, 7, number_format($subtotal), 1, 0, 'R'); 
    $pdf->Cell(40, 7, '', 1, 1, 'C'); 
    
    $pdf->Cell(8, 7,  '', 0, 0, 'C'); 
    $pdf->Cell(40, 7, 'Term of Payment', 1, 0, 'L');
    $pdf->Cell(30, 7, date('d-m-Y', strtotime($jatuh_tempo)), 1, 1, 'L');
    
    $pdf->Ln();
    
    $pdf->Cell(45, 7, 'Request By,', 0, 0, 'C');
    $pdf->Cell(45, 7, 'Verified By,', 0, 0, 'C');
    $pdf->Cell(45, 7, 'Acknowledge By,', 0, 0, 'C'); 
    $pdf->Cell(45, 7, 'Appproved By,', 0, 1, 'C'); 
    
    $pdf->Ln();
    $pdf->Ln();
    
    $pdf->Cell(45, 7, 'Purchasing', 0, 0, 'C');
    $pdf->Cell(45, 7, 'Acc. Manager', 0, 0, 'C');
    $pdf->Cell(45, 7, 'Op. Manager', 0, 0, 'C'); 
    $pdf->Cell(45, 7, 'Head Chef', 0, 1, 'C'); 
    

    $pdf->Output();


?>