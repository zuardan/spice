<?php
	header("Content-type: application/x-msdownload");
	//header("Content-Disposition:attachment;filename=laporan.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<?php echo '<?xml version="1.0"?>'; ?>
<?php echo '<?mso-application progid="Excel.Sheet"?>';?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
</head>

<body>

<style>
	 table{
        border:black 1px solid;
    }
	 .borderbaris5{
        border-bottom:black 1px solid;
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
	}
	
	.bordernobottom{
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
		
	}
	
		.bordernotop{
        border-right:black 1px solid;
		border-left:black 1px solid;
		border-bottom:black 1px solid;
		
	}
	
	 .bordernotopnobottom{   
        border-right:black 1px solid;
		border-left:black 1px solid;
	}
	.bordernoright{
		border-bottom:black 1px solid;
   
		border-top:black 1px solid;
		border-left:black 1px solid;	
	}
	.bordernoleft{
		border-bottom:black 1px solid;
        border-right:black 1px solid;
		border-top:black 1px solid;
		
	}
	.bordernorightleft{
		border-bottom:black 1px solid;
		border-top:black 1px solid;
		
	}
	
	.borderright{
		
        border-right:black 1px solid;			
	}	
	
	}
	.table1no{
		border:	
	}


</style>

<table cellspacing="0" cellpadding="0">
  <col width="7" />
  <col width="28" />
  <col width="70" />
  <col width="30" />
  <col width="45" />
  <col width="21" />
  <col width="44" span="2" />
  <col width="79" />
  <col width="7" />
  <col width="119" />
  <col width="1" />
  <col width="103" />
  <tr>
  
  <?php  echo "<td colspan='13' ><strong>Kepada : Bagian Keuangan</strong></td>" ?>
 
   
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" >Mohon dapat    disiapkan dana berupa:</td>
    <td colspan="3" align="center">TRANSFER</td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
 <?php  echo" <td colspan='2' class='borderbaris5'>NO</td> "?>
 <?php  echo" <td colspan='1' class='borderbaris5'>Tgl</td> "?>
    <?php  echo" <td colspan='3' class='borderbaris5'>Project Code</td> "?>
 <?php  echo" <td colspan='3' class='borderbaris5'>Keterangan</td> "?>
 <?php  echo" <td colspan='2' class='borderbaris5'>Jumlah</td> "?>
  <?php  echo" <td colspan='2' class='borderbaris5'>No giro/Cek</td> "?>
  </tr>
  <tr>
  

    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <? 
	$value = count($this->sheets);
	if ($values < 5) {
    foreach ($this->sheets as $value) {
  ?> 
<?php echo"
  <tr>
    <td  class='borderbaris5' colspan='2' align='right'>". $c=$c+1 ."</td> "?>
	<?php echo"    <td class='borderbaris5'>". date('j-M-y', strtotime($value['date'])) ."</td> "?>
	<?php echo"    <td class='borderbaris5' colspan='3'>". $this->projectResult[$value['projectID']]['Project'] ."</td> "?>
	<?php echo"    <td class='bordernorightleft'>". $value['days'] ."</td> "?>
	<?php echo"    <td class='bordernorightleft' width='70'>hari x @</td> "?>
	<? 
		IF($value['shift'] == '0'){
			$subtotal = $value['days'] * $this->projectResult[$value['projectID']]['value'];
		}else{
			$days = $value['days'] - $value['shift'];				
				$h1 = $this->projectsResult[$value['projectID']]['value'];
				$h1 = $h1 + $this->projectsResult2[$this->projectsResult[$value['projectID']]['Project']]['value'];					
				$malam = $malam + $h1;
			$subtotal = ($days * $this->projectResult[$value['projectID']]['value']) + $malam;
		}	
	?>  
	<?php echo"    <td class='bordernorightleft'>IDR  ". $this->projectResult[$value['projectID']]['value'] ."</td> "?>
	<? $total = $total + $subtotal; ?>
	<?php echo"    <td class='borderbaris5' colspan='2'>". $subtotal ."</td> "?>
	<?php echo"    <td class='borderbaris5' colspan='2'>&nbsp;</td> 
  </tr>"?>
<? $values=$values+1;
	} }?>
 

  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
<?php echo" <td class='bordernoright' style='font-weight:bold'>Total : </td> "?>
<?php echo" <td class='bordernoleft' colspan='2' style='font-weight:bold' align='right'>IDR. ".$total."</td>"?>
   <td ></td> 
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Keterangan:</td>
	<?
	IF($this->month == '1'){ $months = 'January';}
	IF($this->month == '2'){ $months = 'February';}
	IF($this->month == '3'){ $months = 'March';}
	IF($this->month == '4'){ $months = 'April';}
	IF($this->month == '5'){ $months = 'May';}
	IF($this->month == '6'){ $months = 'June';}
	IF($this->month == '7'){ $months = 'July';}
	IF($this->month == '8'){ $months = 'August';}
	IF($this->month == '9'){ $months = 'September';}
	IF($this->month == '10'){ $months = 'October';}
	IF($this->month == '11'){ $months = 'November';}
	IF($this->month == '12'){ $months = 'December';}	
	?>
	<? $ts = strtotime($month.' '.$this->year);?>
    <td colspan="7">Project Transport Claim    (1 - <?= date('t', $ts);?> <?= $months;?> <?= $this->year;?> period)</td>
    <td>Atas Nama :</td>
    <td colspan="2"><?= $this->employeeclaim[$value['NIK']]['name'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="9" style='font-size:9px'>*Note: Project Transport    Claim adalah klaim transport selama onsite di project &amp; bukan project    allowance</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="9" style='font-size:9px'>**Note: Perhitungan    Project Overseas Allowance adalah berdasarkan SPD dan bukan hari kerja onsite</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
<?php echo"    <td  class='bordernobottom' colspan='4'>Menyetujui /</td>" ?>
<?php echo"    <td class='bordernobottom' colspan='3'>Mengetahui    /</td> "?>
<?php echo"  <td class='bordernobottom' colspan='3'>Mengetahui    /</td> "?>
<?php echo"    <td class='bordernobottom' colspan='2'>Mengetahui    /</td> " ?>
<?php echo"     <td class='bordernobottom'>Diajukan oleh,</td> "?>
  </tr>
  <tr align="center">
<?php echo"    <td class='bordernotopnobottom' colspan='4'>Pres. Direktur,</td>"?>
<?php echo"    <td class='bordernotopnobottom' colspan='3'>Finance,</td>"?>
<?php echo"    <td class='bordernotopnobottom' colspan='3'>Direktur</td>"?>
<?php echo"    <td class='bordernotopnobottom' colspan='2'>Operations</td>"?>
    <td>&nbsp;</td>
  </tr>
  <tr>
<?php echo"    <td class='' ></td>"?>
<?php echo"    <td class='' ></td>"?>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td></td>
<?php echo"    <td class='borderright'></td> "?>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
<?php echo"    <td class='borderright' colspan='4'>Kelvin Go</td>"?>
<?php echo"    <td class='borderright' colspan='3'>Lingga</td>"?>
<?php echo"    <td class='borderright' colspan='3'>Arifa</td>"?>
<?php echo"    <td class='borderright' colspan='2'>Kalyana</td>"?>
<td><?= $this->employeeclaim[$value['NIK']]['name'] ?></td>

	
  </tr>
</table>
</body>
</html>