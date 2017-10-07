 <form class="head" style="">
	</br></br>
	<!--<strong style="color:#FFFFFF"><?= $this->user->name ?> </strong>-->
	

 
      	<a class="iframe" href="timesheet/add/?iframe=true"><button style="width:150px; height:45px; margin-left:60px; float:left; margin-top:70px"><strong>Create</strong></button></a> 
   <table width="auto" border="1" style="width:auto; margin-bottom:20px; margin-right:50px" align="">

      <tr>
      
        <td scope="row"><select id="option" style="width:100px;height:25px">
		<option value="periode">Monthly</option> 
		<option value="date">Date</option>
	</select>
	<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
	<? //$years = array(2012 => '2012', 2013 => '2013'); ?>
	<? //$years = array(1 => '2012', 2 => '2013', 3 => '2014', 4 => '2015', 5 => '2016', 6 => '2017', 7 => '2018', 8 => '2019', 9 => '2020', 10 => '2021', 11 => '2022', 12 => '2023'); ?>
    
    <span class="periode">
		<select id="periode" style="width:100px;height:25px">
			<?
			for ($i = 1; $i <= 12; $i++) {
				?>
				<option value="<?= $i; ?>"><?= $months[$i]; ?></option>
			<? } ?>
		</select>
		<select id="year" style="width:100px;height:25px">
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
		<button id="searchMonth" style="width:100px;height:27px">Search</button>
	</span>
    <span class="date">
		<strong></strong><span class="list">
			<input type="text" name="param" id="param" style="width:80px;height:20px"/> <button id="search" style="width:100px;height:30px">Search</button>
		</span> 
	</span>
    </td>
    
      </tr>
    </table>
</form>

<form action="timesheet/submit" method="post" id="timesheet">
    <table cellspacing="1">
        <tr>
            <th width="1"><input type="checkbox" class="checkAll"/></th>
            <th width="75"><a href="javascript:;" data-order="ASC" class="sort">Date</a></th>
            <th width="1">Start Time</th>
            <th width="1">End Time</th>
            <th width="1">Duration</th>
            <th width="1">Project</th>
            <th width="1">Location</th>
            <th width="1">Shift</th>
            <th width="1">Transport</th>
            <th width="1">Status</th>
            <th width="1">Activity</th>
			<th width="1">Edit</th>
			<th width="1">Copy</th>
        </tr>
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
        ?>
        <? if ($this->sheets) { ?>
            <? foreach ($this->sheets as $sheet) { ?>
                <tr>
                    <td><? if ($sheet['status'] == 'Draft') { ?><input type="checkbox" name="data[<?= $sheet['timesheetID'] ?>]" data-id="data[<?= $sheet['timesheetID'] ?>]" class="data" <?= $sheet['status'] != 'Draft' ? "disabled=disabled" : ''; ?>/><? } ?></td>
                    <td><?= date('D , d M Y', strtotime($sheet['date'])); ?></td>
                    <td><?= date('H:i', strtotime($sheet['start_time'])); ?></td>
                    <td><?= date('H:i', strtotime($sheet['end_time'])); ?></td>
                    <td><?
					if(strtotime($sheet['end_time'])>strtotime($sheet['start_time'])){
					$time = strtotime($sheet['end_time']) - strtotime($sheet['start_time']);
					echo time_elapsed_A($time);}
					
					if(strtotime($sheet['end_time'])<strtotime($sheet['start_time'])){
					$time = (strtotime($sheet['start_time']) - strtotime($sheet['end_time']));
					$time1=time_elapsed_A($time);
					$time2= 24 - $time1;
					echo $time2;}
                ?></td>
                    <td><? if($sheet['project'] == ''){
								echo 'The East';
							}
							else{
								echo $this->projectResult[$sheet['project']]['Project'];
							}?></td>
                    <td><?= $this->locationResult[$sheet['location']]['locationName']; ?></td>
                    <td><?= $this->shiftResult[$sheet['shift']]['shift']; ?></td>
                    <td><?= $this->transportResult[$sheet['transport']]['transportName']; ?></td>
                    <td><?= $sheet['status'] ?></td>
               
					<td><?= $sheet['detail'] ?> </td>
					<td style="vertical-align: middle;"><? if ($sheet['status'] == 'Draft') { ?><a class="iframe"  href="<?= $this->config->baseHref; ?>timesheet/edit/id/<?= $sheet['timesheetID']; ?>/?iframe=true" title="Edit" data-id="<?= $sheet['timesheetID']; ?>"><img src="images/pencil.png"/></a><? } ?></td>
					<td style="vertical-align: middle;"><? if ($sheet['status'] == 'Draft') { ?><a href="javascript:;" title="Copy" data-id="<?= $sheet['timesheetID']; ?>" class="copy"><img src="images/add.png"/></a><? } ?></td>
					
				</tr>
            <? } ?>
            <tr>
                <td colspan="14">
                    <button id="submit" style="width:100px;height:30px">Submit</button>
                    <button id="delete" style="width:100px;height:30px">Delete</button>
                </td>
            </tr>
            <tr>
                <td colspan="14" style="font-weight:bold;font-size:14px">
					<!--Pages <select name="page" id="page">
                        <?
                        for ($i = 1; $i <= $this->pages; $i++) {
                            ?>
                            <option value="<?= $i ?>"><?= $i; ?></option>
                        <? } ?>
                    </select>-->
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
                <td colspan="14"> <center> no data</td>
            </tr>
        <? } ?>
    </table>
	</br></br></br>
</form>
<script type="text/javascript">
    $('#param').datepicker();
	$('#periode').val('<?= date('n'); ?>');
	$('#year').val('<?= date('Y'); ?>');
	
	$('.date').hide();
    $('#option').change(function(){
        var option = $(this).val();
        
        $('.periode').hide();
        $('.date').hide();
        
        $('.'+option).show();
    });
	
	$('.checkAll').click(function(){
		var check = $(this).attr('checked');
		if(check == 'checked'){
			$('.data').attr('checked',true);
		}else{
			$('.data').attr('checked',false);
		}
	});
</script>