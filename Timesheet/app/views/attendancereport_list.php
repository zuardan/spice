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
		
		
		<form action="attendancereport/excel" method="POST">
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
			  <th scope="row" style="height:20px">Division</th>
              <td style="text-align:left"><select id="division" name="division" style="width:100px;height:20px"><option value="">All Divisions</option>
              <? foreach ($this->allDivision as $val) { ?>		
					<option value="<?= $val['divisionID']; ?>"> <?= $val['division']; ?></option>
				<? } ?>
				</select></td>
              <th scope="row" style="height:20px">Project</th>
              <td style="text-align:left"><select id="project" name="project" style="width:100px;height:20px"><option value="">All Projects</option>
              <? foreach ($this->allProject as $val) { ?>		
					<option value="<?= $val['ProjectID']; ?>"><?= $val['Project']; ?></option>
				<? } ?>
				</select></td>
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
<table cellspacing="1" class="attendancereport">
	<tr>
		<th rowspan="1">No</th>
		<th rowspan="1">Project</th>
		<th rowspan="1">Sales Force ID</th>
		<th rowspan="1">Name</th>
		<th rowspan="1">Division</th>
		<th rowspan="1">Month</th>
		<th colspan="1">Year</td>
		<th colspan="1">Total Hour</th>
	</tr>	
	
	<? if ($this->sheets) { ?>
		<? foreach ($this->sheets as $sheet) { ?>
		<tr>
			<td><? $c=$c+1; echo $c;?></td>
			<td><?= $sheet['Project']; ?></td>
			<td><?= $sheet['SF_ID'] ?></td>
			<td><?= $sheet['name'] ?></td>
			<td><?= $sheet['division'] ?></td>
			<td><?= date(m, strtotime($sheet['date'])) ?></td>
			<td><?= date(Y, strtotime($sheet['date'])) ?></td>
			<td><?= $sheet['totalhour'] + number_format(($sheet['totalminute']/60), 2) ?> </td>
		</tr>
		<? } ?>
	<? } else { ?>	
	<tr>
		<td colspan="15">no data</td>
	</tr>
	<? } ?>
	
	<tr style="font-weight:bold;font-size:14px">
		<td colspan="15">
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
	$('#project').val('');
	$('#division').val('');
</script>