<div class="head">
    <span>
		</br>
		<span>
		
		</span>
		<form action="history/excel" method="POST">
		
		
        <table border="1">
          <tr><? IF($this->user->types != 1 AND $this->user->types != 2) { ?>
			<? } ?>	

		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
       
			<? IF($this->user->employeeID == '2090818031-DZ' OR ($this->user->types != 1 AND $this->user->types != 2)) { ?>	
            
            <th scope="row">Employee</th>
            <td style="text-align:left; width:auto" width="auto"><select id ="employee" name="employee" style="width:auto;height:25px">
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['id']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
		</select>
			</br></br>
			<? } ?></td>

          </tr>
          <tr>
            <th scope="row">From</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="from" id="from" class="date validate[required]"/></td>
          </tr>	  
		  
		  <tr>
            <th scope="row">To</th>
            <td style="text-align:left" colspan="3"><input type="text" name="to" id="to" class="date validate[required]"/>           	
         
			<button id="searchMonth" style="width:100px;height:30px">Search</button>
            <button id="historyMonth" style="width:100px;height:30px">Print</button>
            </td>
          </tr>
        </table>
	</form>
		
		
    </span>
</div>

<table cellspacing="0" class="history">
    <tr>
        <th>No</th>
        <th>Period</th>
		<th>Status</th>
        <th>Description</th>
        <th>Detail</th>

    </tr>
	<? if ($this->sheets) { ?>
    <? foreach ($this->sheets as $value) { ?>
        <tr>
            <td><? $c=$c+1; echo $c; ?></td>
			<!--<td><?= $value['timesheet_id'] ?></td>-->
            <td><?= date('D, d M Y', strtotime($this->period[$value['timesheet_id']]['date'])); ?></td>
            <td><?= $value['status']; ?></td>
            <td><?= $value['description']; ?></td>
			<td style="vertical-align: middle;">
			<a class="iframe"  href="<?= $this->config->baseHref; ?>history/detail/id/<?= $value['timesheet_id']; ?>/?iframe=true" title="" data-id="<?= $value['timesheet_id']; ?>"><img src="images/detail.png"/></a></td>
        </tr>
    <? } ?>
    <tr>
        <td colspan="14" style="font-weight:bold;font-size:14px">
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
			<td colspan="14">no data</td>
		</tr>
	<? } ?>
</table>
</br></br></br>



<script type="text/javascript">
    
	$('#to').datepicker();
    $('#from').datepicker();
	
    //$('#month').val('<?= date('n'); ?>');
    //$('#year').val('<?= date('Y'); ?>');
	$('#employee').val('<?= $this->userdata->employeeID; ?>');
	
	<?IF($this->user->type == 3) { ?>
    //$('.month').hide(); 
	<? } ?>
    $('#option').change(function(){
        var option = $(this).val();
        
        $('.month').hide();
        $('.between').hide();
        
        $('.'+option).show();
    });
</script>