<?php
session_start();
ob_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";
// panggil fungsi untuk format tanggal & format rupiah
include "../../config/fungsi.php";

$hari_ini = date("d-m-Y");

$no = 1;
// fungsi query untuk menampilkan data dari tabel part
$query = mysqli_query($mysqli, "SELECT kode_part,nama_part,satuan,stok FROM is_part ORDER BY nama_part ASC")
                                or die('Ada kesalahan pada query tampil Data Part: '.mysqli_error($mysqli));
$count  = mysqli_num_rows($query);
?>
<html xmlns="http://www.w3.org/1999/xhtml"> <!-- Bagian halaman HTML yang akan konvert -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>LAPORAN STOK PARTa</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/laporan.css" />
    </head>
    <body>
        <div id="title">
            LAPORAN STOK PARTs 
        </div>
        
        <hr><br>

        <div id="isi">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align='center'>
                <thead style="background:#e8ecee">
                    <tr class="tr-title">
                        <th height='25' align="center" valign="middle">NO.</th>
                        <th height='25' align="center" valign="middle">KODE</th>
                        <th height='25' align="center" valign="middle">NAMA PART</th>
                        <th height='25' align="center" valign="middle">STOK</th>
                        <th height='25' align="center" valign="middle">SATUAN</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        // tampilkan data
        while ($data = mysqli_fetch_assoc($query)) {
            //$harga_beli = format_rupiah($data['harga_beli']);
            //$harga_jual = format_rupiah($data['harga_jual']);
            // menampilkan isi tabel dari database ke tabel di aplikasi
            echo "  <tr>
                        <td width='40'  align='center' valign='middle'>$no</td>
                        <td width='60'  align='center' valign='middle'>$data[kode_part]</td>
                        <td style='padding-left:5px;' width='300'  valign='middle'>$data[nama_part]</td>
                        <td style='padding-right:10px;' width='50'  align='right' valign='middle'>$data[stok]</td>
                        <td width='50'  align='left' valign='middle'>$data[satuan]</td>
                    </tr>";
            $no++;
        }
        ?>  
                </tbody>
            </table>

            <div id="footer-tanggal">
                Bogor, <?php echo tgl_eng_to_ind("$hari_ini"); ?>
            </div>
            <div id="footer-jabatan">
                Manajer
            </div>
            
            <div id="footer-nama">
                Aprianto.
            </div>
        </div>
    </body>
</html><!-- Akhir halaman HTML yang akan di konvert -->
<?php
$filename="LAPORAN STOK PART.pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya
//==========================================================================================================
$content = ob_get_clean();
//$content = '<page style="font-family: freeserif">'.($content).'</page>';
// panggil library html2pdf
require_once('../../assets/plugins/html2pdf/html2pdf.class.php');
require_once '../..//vendor/autoload.php';
/*
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
*/
try
{	
/*
	ini_set("pcre.backtrack_limit", "2000000000");
	$mpdf = new \Mpdf\Mpdf([
		'margin_left' => 20,
		'margin_right' => 15,
		'margin_top' => 48,
		'margin_bottom' => 25,
		'margin_header' => 10,
		'margin_footer' => 10
	]);

	
	$mpdf->SetProtection(array('print'));
	$mpdf->SetTitle("Acme Trading Co. - Invoice");
	$mpdf->SetAuthor("Acme Trading Co.");
	$mpdf->SetWatermarkText("Paid");
	$mpdf->showWatermarkText = true;
	$mpdf->watermark_font = 'DejaVuSansCondensed';
	$mpdf->watermarkTextAlpha = 0.1;
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->WriteHTML($content);
	$mpdf->Output();
	*/
    $html2pdf = new HTML2PDF('P','A4','en', true, 'ISO-8859-15',array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->Output($filename);
	
}
catch(HTML2PDF_exception $e) { echo $e; }

?>