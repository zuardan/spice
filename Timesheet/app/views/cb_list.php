<div class="head">
	<span>
		</br></br>
		<span>
		
		</span>
		</br></br>
		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
        <span class="">
            <strong style="color:#FFFFFF;margin-left:50px">Employee : </strong>
			<? IF($this->user->type != 1 AND $this->user->type != 2) { ?>	
				<select id ="employee" style="width:auto;height:25px">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
				</select>
			<? } ?>
			</br></br>
            <strong style="color:#FFFFFF;margin-left:50px">Month : </strong>
			<select id="month" style="width:auto;height:25px">
                <?
                for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <option value="<?= $i; ?>"><?= $months[$i]; ?></option>
                <? } ?>
            </select>
            </br></br></br>
			<button id="searchMonth" style="width:100px;height:30px;margin-left:50px">Search</button>
        </span>
	</span>
</div>

<table cellspacing="1" class="">
	<tr>
		<th width="1"><input type="checkbox" class="checkAll"/></th>
		<th>Name</th>
		<th>Date</th>
		<th>Project</th>
		<th>Activity</th>
		<th>Detail</th>
	</tr>
	<? IF($this->sheets){ 
		foreach($this->sheets as $sheet){?>
	<tr>
		<td><input type="checkbox" name="data[<?= $sheet['timesheetID'] ?>]" data-id="data[<?= $sheet['timesheetID'] ?>]" class="data" /></td>
		<!--td><?= $sheet['timesheetID'] ?></td-->
		<td><?= $this->allEmployee[$sheet['employeeID']]['name'] ?></td>
		<td><?= date('D , d M Y', strtotime($sheet['date'])); ?></td>
		<td><?= $this->projectResult[$sheet['project']]['Project'] ?></td>
		<td><?= $sheet['activity'] ?></td>
		<td><?= $sheet['detail'] ?></td>
	</tr>
	<? } ?>
            <tr>
                <td colspan="14">
                    <button id="chargeable" style="width:100px;height:30px">Chargeable</button>
                    <button id="billable" style="width:100px;height:30px">Billable</button>
                    <button id="non_chargeable" style="width:150px;height:30px">Non Chargeable</button>
                </td>
            </tr>
            <tr>
                <td colspan="14">
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
	<? }else { ?>
	<tr>
		<td colspan="6">No Data</td>
	</tr>
	<? } ?>
	
</table>
</br></br></br>
<script type="text/javascript">    	
	$('.checkAll').click(function(){
		var check = $(this).attr('checked');
		if(check == 'checked'){
			$('.data').attr('checked',true);
		}else{
			$('.data').attr('checked',false);
		}
	});
</script>