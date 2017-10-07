<div class="head">
	<span>
		</br>
		<span>
		
		</span>

		<form action="claim/excel" method="POST">
        <table width="200" border="1">
              
			<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
			<? IF($this->user->types != 1 AND $this->user->types != 2) { ?>
                <th scope="row">Employee</th>
                <td style="text-align:left"><select id ="employee" name="employee" style="width:auto;height:25px">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
				</select>
           </td><? } ?>
			
              <!--<tr> 
				<th scope="row">Project</th>
				<td style="text-align:left"><select id ="project" name="project" style="width:auto;height:25px" >
					<option value="">The East</option>
					<? foreach ($this->projectResult as $val) { ?>
						<option value="<?= $val['ProjectID']; ?>"> <?= $val['Project']; ?> </option>
					<? } ?>
				</select></td>
				</tr>--><tr>
                <th scope="row">Month</th>
                <td style="text-align:left">	<select id="month" name="month" style="width:auto;height:25px">
                <? for ($i = 1; $i <= 12; $i++) { ?>
                    <option value="<?= $i; ?>"><?= $months[$i]; ?></option>
                <? } ?>
            </select>
			<select id="year" name="year" style="width:auto;height:25px">
			<option value="2012">2012</option>
			<option value="2013">2013</option>
			<option value="2014">2014</option>
			<option value="2015">2015</option>
			<option value="2016">2016</option>
			<option value="2017">2017</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
		</select> <button id="searchMonth" style="width:100px;height:30px">Search</button>
			<? IF($this->user->types != 1 AND $this->user->types != 2) { ?>	
			<button id="claimMonth" style="width:100px;height:30px">Print </button>
			<? } ?></td>

              </tr>
            </table>

			<br />
</br></br>
        </span>
		</form>
		<a class="iframe" href="claim/add/?iframe=true"><button style="width:150px;height:45px;margin-left:50px"><strong>Create</strong></button></a>
	</span>
</div>

<table cellspacing="1" class="">
	<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Project Code</th>
		<th colspan="3">Keterangan</th>
		<th>Jumlah</th>
		<th>No Giro/Cek</th>
		<th>Delete</th>
	</tr>
	<? if($this->sheets) { ?>
	<? foreach($this->sheets as $sheet) { ?>
	<tr>
		<td><?= $c=$c+1; ?> </td>
		<td><?= date('j-M-y', strtotime($sheet['date'])); ?> </td>
		<td><?= $this->projectResult[$sheet['projectID']]['Project'] ?></td>
		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
		<td><?= $sheet['days'] ?></td>
		<td>hari x @ </td>
		<? 
			IF($sheet['shift'] == '0'){
				$subtotal = $sheet['days'] * $this->projectResult[$sheet['projectID']]['value'];
			}else{
				$days = $sheet['days'] - $sheet['shift'];				
					$h1 = $this->projectsResult[$sheet['projectID']]['value'];
					$h1 = $h1 + $this->projectsResult2[$this->projectsResult[$sheet['projectID']]['Project']]['value'];					
					$malam = $malam + $h1;
				$subtotal = ($days * $this->projectResult[$sheet['projectID']]['value']) + $malam;
			}	
		?>  
		<td>IDR <?= $this->projectResult[$sheet['projectID']]['value'] ?> </td>
		<td>IDR <?= $subtotal ?></td>
		<td></td>
		<td><a href="javascript:;" title="Remove" data-id="<?= $sheet['claimID']; ?>" class="delete"><img src="images/cross.png"/></a></td>
	</tr>
	<? } ?>
	<? } else { ?>
		<td colspan="8">No Data</td> 
	<? } ?>
</table>
</br></br></br>

<script type="text/javascript">
	$('#month').val('<?= date('n'); ?>');
	$('#year').val('<?= date('Y'); ?>');
	$('#employee').val('<?= $this->userdata->employeeID; ?>');
	
</script>