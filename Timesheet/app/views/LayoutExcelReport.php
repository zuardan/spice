<div style=”page-break-after:always”></div>
<div align=”justify” style=”font-size:12″></div>
 
<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/MPDF57/mpdf.php";
 
$mpdf=new mPDF('c','A4-L'); 

//include "RekapReport_excel.php"; 

//$mpdf->SetHTMLHeader('<img src="' . base_url() . 'http://spice.phincon.com/Timesheet/images/Phincon.png"/>');
//$mpdf->Image('http://spice.phincon.com/Timesheet/images/Phincon.png,0,0,210,297','png','',true, false);

//untuk memunculkan photo dan footer projectallowance per page

$html='<table><tr>
    <td colspan="17" align="right">No . F-PC-MBP-17-01032017-00</td>
  </tr>
  <tr>
    <td width="280"><center><center><strong style="font-size:16px">Project Allowance</strong></center></center></td>
    <td width="150"></td>
    <td width="150"></td>
    <td width="150"></td>
    <td width="150"></td>
    <td><div align="right"><img src="C:/xampp-beta/htdocs/Timesheet/images/Phincon.png" height="20" width="90"/></div></td>
  </tr></table>';
$mpdf->WriteHTML($html);
$mpdf->SetHtmlHeader('<table border="0">
  <tr>
    <td width="280"><center><center><strong style="font-size:16px">Project Allowance</strong></center></center></td>
    <td width="150"></td>
    <td width="150"></td>
    <td width="150"></td>
    <td width="150"></td>
    <td><div align="right"><img src="C:/xampp-beta/htdocs/Timesheet/images/Phincon.png" height="20" width="90"/></div></td>
  </tr>
</table>');


 //$mpdf->SetFooter('Project Allowance');

//$mpdf->SetHeader('Project Allowance');

//$mpdf->AddPage();
//sampe sini



 //$mpdf->WriteHTML('Project Allowance');
 
//$mpdf->SetDisplayMode('fullpage');
//$mpdf->setAutoPageBreak(true);
ob_start(); 
include "RekapReport_excel.php"; 

$template = ob_get_contents();
ob_end_clean();

$mpdf->WriteHTML($template);
         
$mpdf->Output();
?>


