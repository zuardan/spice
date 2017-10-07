<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rekap Report</title>
</head>
<body>
<!--<table width="430" border="0">
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
</table> -->
<? //set_limit_time(1000);//upload_max_filesize(2M); max_execution_time(60);?>
<style>
  *
  {
   margin:0;
   padding:0;
   font-family:Arial;
   font-size:14px;
   color:#000;
  }
  body
  {
   width:30%;
   font-family:Arial;
   font-size:14px;
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
   width:150mm;
   margin:0 15mm;
  }
  
  .page
  {
   height:270mm;
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

    
<table border="1" class="rekapreport" width="2000px">

<? $count = 0; 
   $flag = 0;
   $pembagi = 44;
  if ($this->sheets) { 
   foreach ($this->sheets as $sheet) { 
    if($count %  $pembagi == 0){
  ?>
  <tr>
  <th rowspan="2" width="30" align="center"  style="font-size:12px" bgcolor='#CCCCCC'>No</th>
  <th rowspan="2" width="180" align="center" style="font-size:12px" bgcolor='#CCCCCC'>Nama</th>
  <th rowspan="2" width="180" align="center" style="font-size:12px" bgcolor='#CCCCCC'>Project</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W1</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W2</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W3</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W4</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W5</th>
  <th colspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>W6</th>
  <th rowspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>Total Saldo</th>
        <th rowspan="2" width="100" align="center" style="font-size:12px" bgcolor='#CCCCCC'>Total Mandays</th>
 </tr> 
 <tr>
  <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
        <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
        <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
        <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
        <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
        <th width="70" align="center">Mandays</th>
        <th width="80" align="center" bgcolor='#CCCCCC'>Saldo</th>
    </tr> <? $flag++; if ($flag == 2){ $count = 0; $pembagi = 144;}}?>

  <tr>
   <td align="center"><? $c=$c+1; echo $c;?></td>
   <td width="150"><?= $this->employee[$sheet['NIK']]['name'] ?></td>
   <td><?= $this->projectResult[$sheet['projectID']]['Project']; ?></td>
   <!--<td>disini untuk edit mandays</td>-->
    
   <?
   $weeks = explode(',', $sheet['weeks']);
   $shift = explode(',', $sheet['shifts']);
   $day_count = explode(',', $sheet['day_count']); //explode untuk pecahin string jadi array
   $mandays = $shifts = array(0, 0, 0, 0, 0);
   for ($i=0; $i < count($weeks); $i++)
   {
    $mandays[$weeks[$i]-1] = $day_count[$i];
    $shifts[$weeks[$i]-1] = $shift[$i];
   }
   ?>
   <?
   $total_day = $total_saldo = 0; $sum_saldo = $sum_day = 0;
   for ($i=0; $i < 6; $i++)
   {
    //$subtotal = 0;
    $total_day += $mandays[$i];
   ?>
    <td align="center"><?if($mandays[$i] == ""){echo "0";} else echo $mandays[$i]; ?></td> <!--mandays untuk mandays-->
    <td>
   <?
    IF($shifts[$i] == '0')
    {
     $subtotal = $mandays[$i] * $this->projectResult[$sheet['projectID']]['value'];
     $total_saldo += $subtotal;
    }
    else
    {
     $subtotal = $mandays[$i] * $this->projectResult[$sheet['projectID']]['value'];
     $total_saldo += $subtotal;
    }//$sum_day += $total_day;$sum_saldo += $total_saldo;
    echo "Rp. ". number_format($subtotal, 0 , '' , '.' ) . ',-'; ?>
    </td>
   <?
   $count++;}
   ?>

   <!--td><?= $this->projectResult[$sheet['project']]['value']?></td>
   <td><?= $this->valueLocation[$sheet['location']]['value']?></td>
   <td><?= $this->valueTransport[$sheet['transport']]['value']?></td-->
   <!--<td>disini untuk edit total saldo</td>-->

   
   <td align="center">Rp. <?= number_format( $total_saldo, 0 , '' , '.' ) . ',-'; ?></td>
   <?
    $x += $total_saldo;
   ?>
   <!--<td>disini untuk edit total mandays</td>-->
   <td width = "70" align="center"><?= $total_day ?></td>
   <?
    $y += $total_day;
   ?>
  </tr>
  <? } ?>
 <? } else { ?> 
 <tr>
  <td colspan="15">no data</td>
 </tr>
 <? } ?>
 <tr>
 <th colspan="15" bgcolor='#CCCCCC'> TOTAL  </th>
 <?
  $sum_saldo = $x;
  $sum_day = $y;
  ?>
  <td align="center">Rp. <?= number_format( $sum_saldo, 0 , '' , '.' ) . ',-'; ?></td>
  <td align="center"> <? echo $sum_day ?> </td>
 </tr>
</table>
<br>

<p>&nbsp;</p>
<table width="430" border="0">
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0">
  <tr>
    <th width="130" align="center">Dibuat oleh / Officer,<br><br><br><br><br><br><br><br>Ruth Hasanah Sinaga</th>
    <th width="150" align="center">Mengetahui / Direktur,<br><br><br><br><br><br><br><br>Arifa</th>
    <th width="120" align="center">Menyetujui / Pres. Direktur,<br><br><br><br><br><br><br>Kelvin Go</th>
 
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>