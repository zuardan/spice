<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<table border="0">
<tr>
    <td width="280"><strong style="font-size:12px">FORM PERMINTAAN PEMBAYARAN</strong></td>
    <td width="150"></td>
    <td width="120"></td>
    <td width="120"></td>
    <td><div align="right"><img src='C:\xampp-beta\htdocs\Timesheet\images\Phincon.png' height='30' width='100'/></div></td>
  </tr>
</table><br><br>
<table width="430" border="0">
<tr>
    <td>Kepada : <strong>Bagian Keuangan</strong></td>
    <td></td>
  </tr>
</table>
<table width="430" border="0">
<tr>
    <td width="280">Mohon disiapkan dana berupa :</td>
    <td width="150" align="center">TRANSFER</td>
    <td width="120"></td>
    <td width="120"></td>
    <td></td>
  </tr>
</table>
<br>
<style>
		*
		{
			margin:0;
			padding:0;
			font-family:Arial;
			font-size:10px;
			color:#000;
		}
		body
		{
			width:100%;
			font-family:Arial;
			font-size:10px;
			margin:0;
			padding:0;
		}
		
		p
		{
			margin:0;
			padding:0;
		}
		
		#wrapper
		{
			width:180mm;
			margin:0 15mm;
		}
		
		.page
		{
			height:297mm;
			width:210mm;
			page-break-after:always;
		}

		table
		{
			border-left: black thin solid;
			border-top: black thin solid;
			border-right: black thin solid;
			border-bottom: black thin solid;
			border-spacing:0;
			border-collapse: collapse; 
			
		}
		
		table td 
		{
			
			padding: 0.5mm;
		}
		
		
	</style>
    
<table border="1">
  <tr>
    <td width="30" align="center">No</td>
    <td width="100" align="center">Tanggal</td>
    <td width="150" align="center">Project Code</td>
    <td width="150" align="center">Keterangan</td>
    <td width="120" align="center">Jumlah</td>
    <td width="120" align="center">No. Giro / Cek</td>
  </tr>
  <? 
	$value = count($this->sheets);
    foreach ((array)$this->sheets as $value) { 
  ?> 
  <tr>
    <td align="center"><?php $c=$c+1; echo $c;?></td>
    <td align="center"><? echo date('j', strtotime($value['from_date'])) ." s/d ". date('j M Y', strtotime($value['to_date'])) ?></td>
    <td><?= $this->projectResult[$value['projectID']]['Project'] ?></td>
	<? IF($value['shift'] == '0'){
			$subtotal = $value['days'] * $this->projectResult[$value['projectID']]['value'];
		}else{
			/*$days = $value['days'] - $value['shift'];				
				$h1 = $this->projectsResult[$value['projectID']]['value'];
				$h1 = $h1 + $this->projectsResult2[$this->projectsResult[$value['projectID']]['Project']]['value'];					
				$malam = $malam + $h1;
			$subtotal = ($days * $this->projectResult[$value['projectID']]['value']) + $malam;*/
			$subtotal = $value['days'] * $this->projectResult[$value['projectID']]['value'];
		}?>
    <td><?= $value['days'] . " hari x @ Rp. ". 
			number_format( $this->projectResult[$value['projectID']]['value'], 0 , '' , '.' ) . ',-'; ?> </td>
		<? $total = $total + $subtotal; ?>
    <td><?= "Rp. ". number_format( $subtotal, 0 , '' , '.' ) . ',-'; ?></td>
    <td></td>
  </tr><? $values=$values+1;
	} ?>
</table>
<br>
<table border="0">
  <tr>
    <td width="30" align="center"></td>
    <td width="100" align="center"></td>
    <td width="150" align="center"></td>
    <td width="150" align="right"><strong>Total :</strong>&nbsp;</td>
    <td width="120" align="left"><strong>
      <u>
      <?= "Rp. ". number_format( $total, 0 , '' , '.' ) . ',-'; ?>
    </u>    </strong></td>
    <td width="120" align="center"></td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="430" border="0">
<tr>
    <td>Keterangan :</td>
    <td>Transport Project Millage</td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="1">
  <tr>
    <td width="130" align="center">Menyetujui / Pres. Direktur,<br><br><br><br><br><br><br>Kelvin Go</td>
    <td width="150" align="center">Mengetahui / Finance,<br><br><br><br><br><br><br>Maulan</td><?php $random = rand(1,3); ?>
    <td width="150" align="center">Mengetahui / Direktur,<div align="center" class="ttd"><img src='C:\xampp-beta\htdocs\Timesheet\images\ttd_arifa_<?php echo $random; ?>.png' height='70'/></div>Arifa</td>
    <td width="120" align="center">Mengetahui / Project Manager,<br><br><br><br><br><br><br><br></td>
    <td width="120" align="center">Diajukan oleh,<br><br><br><br><br><br><br><?= $this->employeeclaim[$value['NIK']]['name']?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>