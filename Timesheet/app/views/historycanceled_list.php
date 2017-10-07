<!--<div align="center"><br />
<br />
<a href="canceled/all" style="color:#FFF"><button style="width:150px; height:45px"><strong style="font-size:16px">All List</strong></button></a> 
</div>-->

<?

function time_elapsed_A($secs) {
            $bit = array(
                'y' => $secs / 31556926 % 12,
                'w' => $secs / 604800 % 52,
                'd' => $secs / 86400 % 7,
                'h' => $secs / 3600 % 24,
                'm' => $secs / 60 % 60,
                's' => $secs % 60
            );

            foreach ($bit as $k => $v)
                if ($v > 0)
                    $ret[] = $v . $k;

            return join(' ', $ret);
        }	
	
 if($this->user->types != 3){

		?>

		
<form action="historycanceled/list" method="POST">
		
		
        <table border="1">
          <tr>

		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
       
			<? IF($this->user->types != 1 AND $this->user->types != 2) { ?>	
            
            <th scope="row">Employee</th>
            <td style="text-align:left; width:auto" width="auto"><select id ="employee" name="employee" style="width:auto;height:25px">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
		</select>
			</br></br>
			<? } ?></td>
			<?IF($this->user->types==2) { ?>
                <th scope="row">Employee</th>
                <td style="text-align:left"><select id ="employee" name="employee" style="width:auto;height:25px">
				<option value="all">All Employee</option>
				<? foreach ($this->listemp as $val2) { ?>
                <option value="<?= $val2['employeeID']; ?>"> <?= $val2['name']; ?> </option>
            <? } ?>
				</select>
           </td><? } ?>
          </tr>
          <tr>
            <th scope="row">From</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="from" id="from" value="<?php echo isset($_POST['from']) ? $_POST['from'] : '' ?>" class="date validate[required]"/></td>
          </tr>	  
		  
		  <tr>
            <th scope="row">To</th>
            <td style="text-align:left" colspan="3"><input type="text" name="to" id="to" value="<?php echo isset($_POST['to']) ? $_POST['to'] : '' ?>" class="date validate[required]"/>           	
         
			<button id="searchMonth" style="width:100px;height:30px">Search</button>
            <!--button id="historyMonth" style="width:100px;height:30px">Print</button-->
            </td>
          </tr>
        </table>
	</form>		

<br><br>


<table cellspacing="0">
        <tr>
            <!--th width="40px">id</th--> 
			<th width="40px">Name</th> 
            <th width="40px">Periode</th>
            <th width="40px">Start Time</th>
            <th width="40px">End Time</th>
            <th width="40px">Duration</th>
            <th width="40px">Project</th>
            <th width="40px">Location</th>
            <th width="40px">Shift</th>
            <th width="40px">Transport</th>
			<th width="40px">Activity</th>
			<th width="40px">Canceled Date</th>
			<th width="40px">Status</th>
      </tr>
	  <? if($this->history){
			foreach ($this->history as $hist) { ?>
	  <tr>
						<!--td><?= $hist['timesheetID'];?></td-->
						<td><?= $hist['name'];?></td>
						<td><?= date('d-m-Y', strtotime($hist['date'])); ?></td>
						<td><?= $hist['start_time']; ?></td>
						<td><?= $hist['end_time']; ?></td>
						<td><? $time = strtotime($hist['end_time']) - strtotime($hist['start_time']);
						echo time_elapsed_A($time);?></td>
						<td><?= $hist['Project'];?></td>
						<td><?= trim($hist['location']) != '' ? $this->locationResult[trim($hist['location'])]['locationName'] : " - "; ?></td>
						<td><?= trim($hist['shift']) != '' ? $this->shiftResult[trim($hist['shift'])]['shift'] : " - "; ?></td>
						<td><?= trim($hist['transport']) != '' ? $this->transportResult[trim($hist['transport'])]['transportName'] : " - "; ?></td>
						<td><?= $hist['detail'] ? $hist['detail'] : '-' ?></td>
						<td><?= $hist['canceled_date'] ? $hist['canceled_date'] : '-' ?></td>
						<td><?echo "<img src='images/x.jpg' width='18' height='18' title='Canceled' />";?> </td>

						</tr><? } ?>
		 <tr>
                <td colspan="12" style="color:#000; font-weight:bold">
					<? 	$temp = '';
						$temp = $this->from / 10 ?>
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
        <? } else { ?>
            <tr>
                <td colspan="11">no data</td>
            </tr>
        <? } ?>
		
</table>	<?}?>


<? if($this->user->types == 3){

		?>

		
<form action="historycanceled/list" method="POST">
		
		
        <table border="1">
          <tr>

		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
       
			<? IF($this->user->types != 1 AND $this->user->types != 2) { ?>	
            
            <th scope="row">Employee</th>
            <td style="text-align:left; width:auto" width="auto"><select id ="employee" name="employee" style="width:auto;height:25px">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
		</select>
			</br></br>
			<? } ?></td>

          </tr>
          <tr>
            <th scope="row">From</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="from" id="from" value="<?php echo isset($_POST['from']) ? $_POST['from'] : '' ?>" class="date validate[required]"/></td>
          </tr>	  
		  
		  <tr>
            <th scope="row">To</th>
            <td style="text-align:left" colspan="3"><input type="text" name="to" id="to" value="<?php echo isset($_POST['to']) ? $_POST['to'] : '' ?>" class="date validate[required]"/>           	
         
			<button id="searchMonth" style="width:100px;height:30px">Search</button>
            <!--button id="historyMonth" style="width:100px;height:30px">Print</button-->
            </td>
          </tr>
        </table>
	</form>		

<br><br>


<table cellspacing="0">
        <tr>
            <!--th width="40px">id</th--> 
			<th width="40px">Name</th> 
            <th width="40px">Periode</th>
            <th width="40px">Start Time</th>
            <th width="40px">End Time</th>
            <th width="40px">Duration</th>
            <th width="40px">Project</th>
            <th width="40px">Location</th>
            <th width="40px">Shift</th>
            <th width="40px">Transport</th>
			<th width="40px">Activity</th>
			<th width="40px">Canceled Date</th>
			<th width="40px">Canceled By</th>
			<th width="40px">Status</th>
      </tr>
	  <? if($this->history){
			foreach ($this->history as $hist) { ?>
	  <tr>
						<!--td><?= $hist['timesheetID'];?></td-->
						<td><?= $hist['emp_name'];?></td>
						<td><?= date('d-m-Y', strtotime($hist['date'])); ?></td>
						<td><?= $hist['start_time']; ?></td>
						<td><?= $hist['end_time']; ?></td>
						<td><? $time = strtotime($hist['end_time']) - strtotime($hist['start_time']);
						echo time_elapsed_A($time);?></td>
						<td><?= $hist['Project'];?></td>
						<td><?= trim($hist['location']) != '' ? $this->locationResult[trim($hist['location'])]['locationName'] : " - "; ?></td>
						<td><?= trim($hist['shift']) != '' ? $this->shiftResult[trim($hist['shift'])]['shift'] : " - "; ?></td>
						<td><?= trim($hist['transport']) != '' ? $this->transportResult[trim($hist['transport'])]['transportName'] : " - "; ?></td>
						<td><?= $hist['detail'] ? $hist['detail'] : '-' ?></td>
						<td><?= $hist['canceled_date'] ? $hist['canceled_date'] : '-' ?></td>
						<td><?= $hist['approval'] ? $hist['approval'] : '-' ?></td>
						<td><?echo "<img src='images/x.jpg' width='18' height='18' title='Canceled' />";?> </td>

						</tr><? } ?>
		 <tr>
                <td colspan="12" style="color:#000; font-weight:bold">
					<? 	$temp = '';
						$temp = $this->from / 10 ?>
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
        <? } else { ?>
            <tr>
                <td colspan="11">no data</td>
            </tr>
        <? } ?>
		
</table>	<?}?>
<script type="text/javascript">

	
	$('#to').datepicker();
    $('#from').datepicker();
	document.getElementById('employee').value="<?php echo $_POST['employee']; ?>";
	$('#employee').val();
</script>