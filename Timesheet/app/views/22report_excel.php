<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIMESHEET</title>

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
	 .table{
        border-bottom:black 1px solid;
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
    }
	
	.borderall{
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
		border-bottom:black 1px solid;
		
	}
	.bordernobottom{
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
		
	}
	
	 .borderbottom{   
        border-bottom:black 1px solid;
	}
	
		.bordernotop{
        border-right:black 1px solid;
		border-left:black 1px solid;
		border-bottom:black 1px solid;
		
	}
</style>


<table cellspacing="0" cellpadding="0" class="borderall">
  <col width="25" /> <!-- a -->
  <col width="150" /><!-- b -->
  <col width="140" /><!-- c -->
  <col width="80" /><!-- d -->
  <col width="40" /><!-- e -->
  <col width="100" /><!-- f -->
  <col width="100"/><!-- g -->
  
   <tr align="center">
  		<?php  echo "<td style='vertical-align:middle' class='bordernobottom' bgcolor='#CCCCCC'><strong>No</strong></td>" ?>
		<?php  echo "<td style='vertical-align:middle' class='bordernobottom' bgcolor='#CCCCCC'><strong>Name</strong></td>" ?>
		<?php  echo "<td style='vertical-align:middle' class='bordernobottom' bgcolor='#CCCCCC'><strong>Project</strong></td>" ?>
		<?php  echo "<td style='vertical-align:middle' class='bordernobottom' bgcolor='#CCCCCC'><strong>Period</strong></td>" ?>
		<?php  echo "<td style='vertical-align:middle' class='bordernobottom' bgcolor='#CCCCCC'><strong>Days</strong></td>" ?>
		<?php  echo "<td class='bordernobottom' colspan='2' align='center' bgcolor='#CCCCCC'><strong>Saldo</strong></td>" ?>				
  </tr>
  
  
  <tr>
		<td class="bordernotop" bgcolor="#CCCCCC"></td>
		<td class="bordernotop" bgcolor="#CCCCCC"></td>
		<td class="bordernotop" bgcolor="#CCCCCC"></td>
		<td class="bordernotop" bgcolor="#CCCCCC"></td>
		<td class="bordernotop" bgcolor="#CCCCCC"></td>
		<?php  echo "<td class='borderall' align='center' bgcolor='#CCCCCC'><strong>IDR</strong></td>" ?>
		<?php  echo "<td class='borderall' align='center' bgcolor='#CCCCCC'><strong>Total</strong></td>" ?>
  </tr>
  <? if (count($this->sheets) > 0) {
    foreach ($this->sheets as $value) {
        $project = $value['project'];
		
        unset($strings); 
		$c = $c+1; ?>
  <tr>
		<td align="center"><?= $c?></td>
	  <td><?= $this->employee[$value['NIK']]['name']?></td>          
	  <td><?= $this->projectResult[$value['projectID']]['Project']?></td>
	  <?
		IF($value['period'] == '1'){ $months = 'Jan';}
		IF($value['period'] == '2'){ $months = 'Feb';}
		IF($value['period'] == '3'){ $months = 'Mar';}
		IF($value['period'] == '4'){ $months = 'Apr';}
		IF($value['period'] == '5'){ $months = 'May';}
		IF($value['period'] == '6'){ $months = 'Jun';}
		IF($value['period'] == '7'){ $months = 'Jul';}
		IF($value['period'] == '8'){ $months = 'Aug';}
		IF($value['period'] == '9'){ $months = 'Sep';}
		IF($value['period'] == '10'){ $months = 'Oct';}
		IF($value['period'] == '11'){ $months = 'Nov';}
		IF($value['period'] == '12'){ $months = 'Dec';}	
	  ?>
	  <td align="center"><?= $months.' '.$value['year']?></td>
	  
	  <td align="center"><?= $value['days'] ?></td>
	  
	  <td>IDR <?= $array[$value['projectID']]['total'] = ($this->projectResult[$value['projectID']]['value'] * $value['days'])?></td>
	  <?
		$count = COUNT($this->subtotal[$value['projectID']]['subtotal']);
	  ?>
	  <td style="vertical-align:middle">IDR <?=  array_sum($this->subtotal[$value['projectID']]['subtotal'])?></td>                  <!-- merge row  kolom total-->
		 <? $total = $total + array_sum($this->subtotal[$value['projectID']]['subtotal'])?> 
  
  </tr>
  <? }
  }?>
  <tr></tr>
  <tr></tr>
  
  


 
	

      
</table>

<table class="">
	<tr></tr>
		   <tr align="center">
			<?php echo "<td colspan='5'><strong>TOTAL</strong></td>" ?>
			<?php echo "<td style='text-decoration:underline'><strong>IDR $total</strong></td>" ?>		
	 </tr>
</table>



</body>
</html>