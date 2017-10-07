<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/MPDF57/mpdf.php";
 
$mpdf=new mPDF('c','A4'); 
 
$mpdf->SetDisplayMode('fullpage');
 
ob_start();
include "claim_excel.php"; 

$template = ob_get_contents();
ob_end_clean();

$mpdf->WriteHTML($template);
         
$mpdf->Output();
?>


