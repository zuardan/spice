<? 	
	if (count($this->emp) > 0) {
		foreach ($this->emp as $emp) {
		unset($strings);
?>
	<?php
	header("Content-type: application/x-msdownload");	

	if($this->month['months'] == 1) $bulan = "JAN";
	if($this->month['months'] == 2) $bulan = "FEB";
	if($this->month['months'] == 3) $bulan = "MAR";
	if($this->month['months'] == 4) $bulan = "APR";
	if($this->month['months'] == 5) $bulan = "MAY";
	if($this->month['months'] == 6) $bulan = "JUN";
	if($this->month['months'] == 7) $bulan = "JUL";
	if($this->month['months'] == 8) $bulan = "AUG";
	if($this->month['months'] == 9) $bulan = "SEP";
	if($this->month['months'] == 10) $bulan = "OCT";
	if($this->month['months'] == 11) $bulan = "NOV";
	if($this->month['months'] == 12) $bulan = "DEC";	

	$empl = str_replace(' ','_',$emp['name']);
	header("Content-Disposition:attachment;filename=TIMESHEET_".date("d-m-Y", strtotime($_REQUEST['from'])) ."_" . "to". "_". date("d-m-Y", strtotime($_REQUEST['to'])). "_". $empl.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
?>
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
	 .table1{
        border-bottom:black 1px solid;
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
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
	
	
	.borderall{
        border-right:black 1px solid;
		border-top:black 1px solid;
		border-left:black 1px solid;
		border-bottom:black 1px solid;
		
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
  <col width="90" /> <!-- a -->
  <col width="150" /><!-- b -->
  <col width="75" /><!-- c -->
  <col width="75" /><!-- d -->
  <col width="200" /><!-- e -->
  <col width="75" /><!-- f -->
  <col width="75"/><!-- g -->
  <col width="75" /><!-- h -->
  <col width="275" /><!-- i -->
  <col width="150" /><!-- j -->
  <col width="100" /><!-- k -->
  <col width="150" /><!-- l -->
   <tr>
  	<td colspan="9" align="right">No . F-PC-MBP-16-01032017-00</td>
  </tr>
   <tr align="center">
  		<?php  echo "<td colspan='9' width='664' align='center' style='font-size:18px'><strong>PROJECT TIMESHEET</strong> </td>" ?>
  </tr>
  <tr></tr>
 
	
   <tr>
  		<?php  echo "<td><strong>Name :</strong> </td>" ?>
        <?php  echo "<td>". $emp['name'] ."</td>" ?>
        <td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
        <?php  echo "<td><strong>Position :</strong> </td>" ?>
        <?php  echo "<td>". $this->positionResult[$emp['position_id']]['position'] ."</td>" ?> 
   </tr>
   
   <tr>
   		<?php  echo "<td><strong>Department : </strong> </td>" ?>
        <?php  echo "<td>". $this->departmentResult[$emp['department_id']]['department'] ."</td>" ?>
        <td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>		
   		<?php  echo "<td><strong>Period :</strong> </td>" ?>
        <?php  echo "<td align='left' type='date'>". date("d M Y", strtotime($_REQUEST['from'])) ." " . "s/d". " ". date("d M Y", strtotime($_REQUEST['to']))."</td>" ?> 		
		
   </tr>
	<?
		}
	}
	?>
<tr></tr>
 
	<tr align="center">
    	<?php  echo "<td class='borderall'><strong>Day</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Date</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Start time</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>End Time</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Project</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Location</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Shift</strong> </td>" ?>
        
        <?php  echo "<td class='borderall'><strong>Activity</strong> </td>" ?>
        <?php  echo "<td class='borderall'><strong>Transport</strong> </td>" ?>
    
    </tr>
	<? if ($this->sheets) { ?>
    <? foreach ($this->sheets as $value) { 
	$project = $value['project'];
	unset($strings);
	//print_r($value);
	//print_r($dates[$i]);
	?>
	<?php		
		
			$flag = 1;
			
			if($this->transportResult[$value['transport']]['value'] == '2'){
				$values = 1;
			}
			else{
				$values = 0.5;
			}
			if($this->locationResult[$value['location']]['value']=='0'){
				$values=0;
			}
				$total = $total + $values;
			
			$date = strtotime($this->period[$value['timesheet_id']]['date']);
			$is_saturday = date('l', $date) == 'Saturday';
			$is_sunday = date('l', $date) == 'Sunday';
			IF($is_saturday OR $is_sunday){
				echo"<tr>
				<td class='borderall' bgcolor='#FFCCFF'>". date('l', strtotime($this->period[$value['timesheet_id']]['date'])) ."</td>
				<td class='borderall' bgcolor='#FFCCFF'>". date('j M Y', strtotime($this->period[$value['timesheet_id']]['date'])) ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". date('H:i', strtotime($value['start_time'])) ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". date('H:i', strtotime($value['end_time'])) ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". $this->projectResult[$value['project']]['Project'] ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". $this->locationResult[$value['location']]['locationName'] ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". $this->shiftResult[$value['shift']]['shift'] ." </td>
				
				<td class='borderall' bgcolor='#FFCCFF'>". $value['detail'] ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>". $this->transportResult[$value['transport']]['transportName'] ." </td>		
				<td align='left'>". $values ." </td>							
				</tr>";
			}else{
				echo"<tr>
				<td class='borderall'>". date('l', strtotime($this->period[$value['timesheet_id']]['date'])) ."</td>
				<td class='borderall'>". date('j M Y', strtotime($this->period[$value['timesheet_id']]['date'])) ." </td>
				<td class='borderall'>". date('H:i', strtotime($value['start_time'])) ." </td>
				<td class='borderall'>". date('H:i', strtotime($value['end_time'])) ." </td>
				<td class='borderall'>". $this->projectResult[$value['project']]['Project'] ." </td>
				<td class='borderall'>". $this->locationResult[$value['location']]['locationName'] ." </td>
				<td class='borderall'>". $this->shiftResult[$value['shift']]['shift'] ." </td>
				
				<td class='borderall'>". $value['detail'] ." </td>
				<td class='borderall'>". $this->transportResult[$value['transport']]['transportName'] ." </td>		
				<td align='left'>". $values ." </td>							
				</tr>";
			
		}		
	}
	if($flag == 0){
			/*echo "<tr>";
			echo "<td>" . '0' . "</td>" ;			
			echo "</tr>" ;*/
		$date = strtotime($dates[$i]);
		$is_saturday = date('l', $date) == 'Saturday';
		$is_sunday = date('l', $date) == 'Sunday';
		IF($is_saturday OR $is_sunday){
			echo"<tr>
				<td class='borderall' bgcolor='#FFCCFF'>". date('l', strtotime($dates[$i])) ."</td>
				<td class='borderall' bgcolor='#FFCCFF'>". date('j M Y', strtotime($dates[$i])) ." </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				
				<td class='borderall' bgcolor='#FFCCFF'>  </td>
				<td class='borderall' bgcolor='#FFCCFF'>  </td>			
				<td>  </td>		
			</tr>";	
		}else{
			echo"<tr>
				<td class='borderall'>". date('l', strtotime($dates[$i])) ."</td>
				<td class='borderall'>". date('j M Y', strtotime($dates[$i])) ." </td>
				<td class='borderall'>  </td>
				<td class='borderall'>  </td>
				<td class='borderall'>  </td>
				<td class='borderall'>  </td>
				<td class='borderall'>  </td>
				
				<td class='borderall'>  </td>
				<td class='borderall'>  </td>			
				<td>  </td>		
			</tr>";	
		}	
	}
	$flag = 0;
	?>
	</tr>
	</tr>
    
    <? 	
		}	
	?>
    <?php
		echo"<tr>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			
			<td> </td>
			<td> </td>			
			<td align='left'>".$total."</td>		
		</tr>";	
	?>
    </tr>  
    
    </tr>
      
</table>

</body>
</html>