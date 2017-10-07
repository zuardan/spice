<div class="detail">
<table id="a" class="a" cellspacing="1" style="width:100%">
	<tr style="width:100%">
		<th width="75"><a href="javascript:;" data-order="ASC" class="sort">Periode</a></th>
		<th width="1">Start Time</th>
		<th width="1">End Time</th>
		<th width="1">Duration</th>
		<th width="1">Project</th>
		<th width="1">Location</th>
		<th width="1">Shift</th>
		<th width="1">Transport</th>
		<th width="1">Activity</th>
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
	<tr>
		<!--<td><? if ($sheet['status'] == 'Draft') { ?><input type="checkbox" name="data[<?= $this->value['timesheetID'] ?>]" data-id="data[<?= $this->value['timesheetID'] ?>]" class="data" <?= $this->value['status'] != 'Draft' ? "disabled=disabled" : ''; ?>/><? } ?></td>-->
		<td><?= date('D , d M Y', strtotime($this->value['date'])); ?></td>
		<td><?= date('H:i', strtotime($this->value['start_time'])); ?></td>
		<td><?= date('H:i', strtotime($this->value['end_time'])); ?></td>
		<td><?if(strtotime($this->value['end_time'])>strtotime($this->value['start_time'])){
			$time = strtotime($this->value['end_time']) - strtotime($this->value['start_time']);
			echo time_elapsed_A($time);}
			if(strtotime($this->value['end_time'])<strtotime($this->value['start_time'])){
			$time = strtotime($this->value['start_time']) - strtotime($this->value['end_time']);
			$time1=time_elapsed_A($time);
					$time2= 24 - $time1;
					echo $time2;}
		?></td>
		<td><?= $this->projectResult[$this->value['project']]['Project']; ?></td>
		<td><?= $this->locationResult[$this->value['location']]['locationName']; ?></td>
		<td><?= $this->shiftResult[$this->value['shift']]['shift']; ?></td>
		<td><?= $this->transportResult[$this->value['transport']]['transportName']; ?></td>
		<td><?= $this->value['detail'] ?></td>
		<!--<td style="vertical-align: middle;"><a class="iframe"  href="<?= $this->config->baseHref; ?>timesheet/detail/id/<?= $this->value['timesheetID']; ?>/?iframe=true" title="Detail" data-id="<?= $this->value['timesheetID']; ?>"><img src="images/pencil.png"/></a>&nbsp;&nbsp;<a class="iframe"  href="<?= $this->config->baseHref; ?>timesheet/edit/id/<?= $this->value['timesheetID']; ?>/?iframe=true" title="Edit" data-id="<?= $this->value['timesheetID']; ?>"><img src="images/pencil.png"/></a>&nbsp;&nbsp;<a href="javascript:;" title="Remove" data-id="<?= $this->value['timesheetID']; ?>" class="delete"><img src="images/cross.png"/></a></td>-->			
	</tr>			
</table>
</div>