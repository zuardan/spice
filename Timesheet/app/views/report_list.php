<div class="head"> 
	<span>
	<br />

		<span>
		
		</span>

		
		<!--form action="report/excel" method="POST">
			<strong> Period : </strong> 
			<span class="month">     
				<select id="month">
					<?
					for ($i = 1; $i <= 12; $i++) {
						?>
						<option value="<?= $i; ?>"><?= $months[$i]; ?></option>
					<? } ?>
				</select>
				<button id="searchMonth">search</button>
				</br></br></br>
				<button id="reportMonth">Print Report</button>
			</span-->
		
		
		<form action="report/excel" method="POST">
		<!--form action="http://localhost/PHPExcel/Tests/TransportClaim.php" method="POST"-->
		<!--select id="option">
            <? IF($this->user->type != 1 AND $this->user->type != 2) { ?>
			<!--option value="between">Date</option--><? } ?>	
			<!--option value="month">Month</option>
        </select-->
		
		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
        
            <!--strong>Employee : </strong>
			<? IF($this->user->type != 1 AND $this->user->type != 2) { ?>	
				<select id ="employee">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
				</select>
			<? } ?>
			</br></br-->
            <table border="1" class="report">
              <tr>
                <th scope="row">Month</th>
                <td style="text-align:left"><select id="month" name="month" style="width:auto;height:25px">
                <?
                for ($i = 1; $i <= 12; $i++) { 
                    ?>
                    <option value="<?= $i; ?>"><?= $months[$i]; ?></option>
                <? } ?>
            </select>
			<select id="year" name="year" style="width:100px;height:25px">
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
				<option value="2016">2016</option>
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
				<option value="2020">2020</option>
				
			</select>
            <button id="searchMonth" style="width:100px;height:30px;">Search</button>
		
			<button id="reportMonth" style="width:100px;height:30px">Download</button>
            </td>
              </tr>
              <tr>
              </tr>
            </table>

            
		</form>
	
	
</div>
<table cellspacing="1" class="report">
	<tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Nama</th>
		<th rowspan="2">Project</th>
		<th colspan="2">W1</td>
		<th colspan="2">W2</th>
		<th colspan="2">W3</th>
		<th colspan="2">W4</th>
		<th colspan="2">W5</th>
		<th colspan="2">W6</th>
		<th rowspan="2">Total Saldo</th>
        <th rowspan="2">Total Mandays</th>
	</tr>	
	<tr>
		<th>Mandays</th>
        <th>Saldo</th>
        <th>Mandays</th>
        <th>Saldo</th>
        <th>Mandays</th>
        <th>Saldo</th>
        <th>Mandays</th>
        <th>Saldo</th>
        <th>Mandays</th>
        <th>Saldo</th>
		<th>Mandays</th>
        <th>Saldo</th>
    </tr>
	
	<? if ($this->sheets) { ?>
		<? foreach ($this->sheets as $sheet) { ?>
		<tr>
			<td><? $c=$c+1; echo $c;?></td>
			<td><?= $this->employee[$sheet['NIK']]['name'] ?></td>
			<td><?= $this->projectResult[$sheet['projectID']]['Project']; ?></td>
			<!--<td>disini untuk edit mandays</td>-->
			
			<?
			IF($sheet['period'] == '1'){ $months = 'Jan';}
			IF($sheet['period'] == '2'){ $months = 'Feb';}
			IF($sheet['period'] == '3'){ $months = 'Mar';}
			IF($sheet['period'] == '4'){ $months = 'Apr';}
			IF($sheet['period'] == '5'){ $months = 'May';}
			IF($sheet['period'] == '6'){ $months = 'Jun';}
			IF($sheet['period'] == '7'){ $months = 'Jul';}
			IF($sheet['period'] == '8'){ $months = 'Aug';}
			IF($sheet['period'] == '9'){ $months = 'Sep';}
			IF($sheet['period'] == '10'){ $months = 'Oct';}
			IF($sheet['period'] == '11'){ $months = 'Nov';}
			IF($sheet['period'] == '12'){ $months = 'Dec';}		

					

			$NIK = explode(',', $sheet['NIKS']);
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
				<td><? if($mandays[$i] == ""){echo "0";}  else {echo $mandays[$i]; }?></td> <!--mandays untuk mandays-->
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
					$total_saldo += $subtotal;;
				}//$sum_day += $total_day;$sum_saldo += $total_saldo;
				echo "Rp. ". number_format($subtotal, 0 , '' , '.' ) . ',-'; ?>
				</td>
			<?
			}
			?>

			<!--td><?= $this->projectResult[$sheet['project']]['value']?></td>
			<td><?= $this->valueLocation[$sheet['location']]['value']?></td>
			<td><?= $this->valueTransport[$sheet['transport']]['value']?></td-->
			<!--<td>disini untuk edit total saldo</td>-->

			
			<td>Rp. <?= number_format( $total_saldo, 0 , '' , '.' ) . ',-'; ?></td>
			<?
				$x += $total_saldo;
			?>
			<!--<td>disini untuk edit total mandays</td>-->
			<td><?= $total_day ?></td>
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
	<th colspan="15"> Subtotal Payment  </th>
	<?
		$sum_saldo = $x;
		$sum_day = $y;
		?>
		<td>Rp. <?= number_format( $sum_saldo, 0 , '' , '.' ) . ',-'; ?></td>
		<td> <? echo $sum_day ?> </td>
	</tr>
	<tr style="font-weight:bold;font-size:14px">
		<td colspan="17">
			<? 	$temp = '';
				$temp = $this->from / 400 ?>
			<a href="javascript:;" data-page='1' class="page">First</a>
			<? IF($temp+1 != 1) { ?><a href="javascript:;" data-page=<?= $temp ?> class="page">Prev</a><? } ?>
			<? for ($i = 1; $i <= $this->pages; $i++) { ?>
				<a href="javascript:;" data-page=<?= $i; ?> class="page" <? IF($temp+1 == $i) { ?>style="color:#000000" <? }?>><?= $i; ?>
			<? } ?>
			<? IF($temp+1 != $this->pages && $this->pages != 1) { ?><a href="javascript:;" data-page=<?= $temp + 2 ?> class="page">Next</a><? } ?>
			<a href="javascript:;" data-page=<?= $this->pages ?> class="page">Last</a>
			</br>
			
			Page <?= $temp + 1 ?> of <?= $this->pages ?>
		</td>
	</tr>
</table>
</br></br></br>

<script type="text/javascript">
	$('#month').val('<?= date('n'); ?>');
	$('#year').val('<?= date('Y'); ?>');
</script>