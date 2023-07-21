<?php
session_start();
include '../../config/database.php';
// require_once "../../config/database.php";

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

for ($i = 2; $i <= $objWorksheet->getHighestRow(); $i++) {

    $query_id = mysqli_query($mysqli, "SELECT Cast(RIGHT(no,5) as int) as kode FROM is_sales
                                                ORDER BY no DESC LIMIT 1")
        or die('Ada kesalahan pada query tampil kode_part : ' . mysqli_error($mysqli));

    $count = mysqli_num_rows($query_id);

    if ($count <> 0) {
        // mengambil data kode_part
        $data_no = mysqli_fetch_assoc($query_id);
        $kode = $data_no['kode'] + 1;

    } else {
        $kode = 1;
    }

    // buat kode_part
    $buat_no = str_pad($kode, 5, "0", STR_PAD_LEFT);
    $no = "S$buat_no";

    $tanggal = $objWorksheet->getCell('A' . $i)->getValue();
    $resto = $objWorksheet->getCell('B' . $i)->getValue();
    $bill_total = priceclean($objWorksheet->getCell('C' . $i)->getValue());
    $customer = priceclean($objWorksheet->getCell('D' . $i)->getValue());
    $disc = priceclean($objWorksheet->getCell('E' . $i)->getValue());
    $sub_total = priceclean($objWorksheet->getCell('F' . $i)->getValue());
    $service_charge_total = priceclean($objWorksheet->getCell('G' . $i)->getValue());
    $total_sale = priceclean($objWorksheet->getCell('H' . $i)->getValue());
    $tax_total = priceclean($objWorksheet->getCell('I' . $i)->getValue());
    $vat_total = priceclean($objWorksheet->getCell('J' . $i)->getValue());
    $delivery_cost = priceclean($objWorksheet->getCell('K' . $i)->getValue());
    $rounding = priceclean($objWorksheet->getCell('L' . $i)->getValue());
    $net_sales = priceclean($objWorksheet->getCell('M' . $i)->getValue());
    $grand_total = priceclean($objWorksheet->getCell('N' . $i)->getValue());
    $total_payment = priceclean($objWorksheet->getCell('O' . $i)->getValue());
    $diff_payment = priceclean($objWorksheet->getCell('P' . $i)->getValue());
    $cash = priceclean($objWorksheet->getCell('Q' . $i)->getValue());
    $credit_card = priceclean($objWorksheet->getCell('R' . $i)->getValue());
    $debit_card = priceclean($objWorksheet->getCell('S' . $i)->getValue());
    $member_deposit = priceclean($objWorksheet->getCell('T' . $i)->getValue());
    $product_code = $objWorksheet->getCell('U' . $i)->getValue();
    $qty = $objWorksheet->getCell('V' . $i)->getValue();
    
    //ISSET
    $bill_total = $bill_total ? $bill_total : 0;
    $customer = $customer ? $customer : 0;
    $disc = $disc ? $disc : 0;
    $sub_total = $sub_total ? $sub_total : 0;
    $service_charge_total = $service_charge_total ? $service_charge_total : 0;
    $total_sale = $total_sale ? $total_sale : 0;
    $tax_total = $tax_total ? $tax_total : 0;
    $vat_total = $vat_total ? $vat_total : 0;
    $delivery_cost = $delivery_cost ? $delivery_cost : 0;
    $rounding = $rounding ? $rounding : 0;
    $net_sales = $net_sales ? $net_sales : 0;
    $grand_total = $grand_total ? $grand_total : 0;
    $total_payment = $total_payment ? $total_payment : 0;
    $diff_payment = $diff_payment ? $diff_payment : 0;
    $cash = $cash ? $cash : 0;
    $credit_card = $credit_card ? $credit_card : 0;
    $debit_card = $debit_card ? $debit_card : 0;
    $member_deposit = $member_deposit ? $member_deposit : 0;
    $qty = $qty ? $qty : 0;
    if (isset($tanggal) && isset($resto) && isset($product_code)) {
        $query_produk = mysqli_query(
            $mysqli, "SELECT kode_produk, nama_produk, `group`
            FROM is_produk 
            WHERE kode_produk='" . $product_code . "'"
        );

        $row_produk = mysqli_fetch_assoc($query_produk);
        if ($row_produk) {
            try {
                mysqli_autocommit($mysqli, false);
                mysqli_query(
                    $mysqli,
                    "INSERT INTO is_sales (
                        `no`,
                        resto, 
                        tanggal, 
                        `value`, 
                        bill_total, 
                        customer, 
                        disc, 
                        sub_total, 
                        service_charge_total, 
                        total_sale, 
                        tax_total, 
                        vat_total, 
                        delivery_cost, 
                        rounding, 
                        net_sales, 
                        grand_total, 
                        total_payment, 
                        diff_payment, 
                        cash, 
                        credit_card, 
                        debit_card, 
                        member_deposit,
                        product_code,
                        qty
                    ) VALUES (
                        '$no', 
                        '$resto', 
                        '$tanggal', 
                        '$grand_total', 
                        '$bill_total', 
                        '$customer', 
                        '$disc', 
                        '$sub_total', 
                        '$service_charge_total', 
                        '$total_sale', 
                        '$tax_total', 
                        '$vat_total', 
                        '$delivery_cost', 
                        '$rounding', 
                        '$net_sales', 
                        '$grand_total', 
                        '$total_payment', 
                        '$diff_payment', 
                        '$cash', 
                        '$credit_card', 
                        '$debit_card', 
                        '$member_deposit',
                        '$product_code',
                        '$qty'
                )") or throws("Error on \modules\upload-part\proses.php, line :d\n" . mysqli_error($mysqli));
                $user = $_SESSION['id_user'];
                $query_produk_part = mysqli_query($mysqli, "SELECT a.id,a.kode_produk,a.kode_part,a.qty,c.`group`,b.kode_part,b.harga, b.nama_part,b.satuan
                    FROM is_produk_part as a 
                    LEFT JOIN is_produk as c ON a.kode_produk = c.kode_produk
                    INNER JOIN is_part as b ON a.kode_part=b.kode_part 
                    WHERE a.kode_produk = '$product_code'
                    ORDER BY a.id ASC") or die('Ada kesalahan pada query tampil Data Item Produk: ' . mysqli_error($mysqli));
                while ($data_produk_part = mysqli_fetch_assoc($query_produk_part)) {
                    $qtyTotal = $qty * $data_produk_part["qty"];
                    mysqli_query(
                        $mysqli,
                        "INSERT INTO is_part_trans (
                            tanggal_transaksi,
                            kode_transaksi, 
                            referensi, 
                            kode_part, 
                            satuan, 
                            nama, 
                            qty, 
                            harga, 
                            `group`,
                            kode_suplier,
                            bukti,
                            created_user
                        ) VALUES (  
                            '$tanggal', 
                            '$no',
                            'SALES', 
                            '$data_produk_part[kode_part]', 
                            '$data_produk_part[satuan]', 
                            '$data_produk_part[nama_part]', 
                            '-$qtyTotal', 
                            '$data_produk_part[harga]', 
                            '$data_produk_part[group]', 
                            '',
                            '',
                            '$user'
                    )") or throws("Error on \modules\upload-part\proses.php, line :d\n" . mysqli_error($mysqli));
                }
            }
            catch(Exception $e) 
            {
                mysqli_rollback($mysqli);
            }
            finally{
                mysqli_autocommit($mysqli,true);
            }
        } 
    }
}

echo "<meta http-equiv='refresh' content='0; url=../../main.php?module=upload_sales&alert=1'>";
?>
