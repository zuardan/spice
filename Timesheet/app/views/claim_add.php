<form action="" method="POST" class="form">
	<!--<strong>Date</strong>
	<input type="text" id="date" style="margin-left:1.5cm;" id="date" name="date"/>
	</br></br>-->
	
	<strong>Project</strong>
	<select style="margin-left:1.1cm;" id="projectID" name="projectID">
		<? foreach($this->project as $project) { ?>
			<option value="<?= $this->projects[$project['Project']]['ProjectID'] ?>"><?= $project['Project']?> </option>
		<? } ?>
	</select>
	</br></br>
	
	<? //$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
	<!--strong>Period</strong>
	<select id="month" style="margin-left:1.2cm;" id="period" name="period">
		<? for ($i = 1; $i <= 12; $i++) {
			?>
			<option value="<?= $i; ?>"><?= $months[$i]; ?></option>
		<? } ?>
	</select>	
	<select id="year" name="year">
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
	</br></br-->
	
	<strong>From</strong>
	<input type="text" style="margin-left:1.4cm;" name="from_date" id="from_date" class="date validate[required]"/>
	<br><br>
	<strong>To</strong>
	<input type="text" style="margin-left:1.8cm;" name="to_date" id="to_date" class="date validate[required]"/>	
	</br></br></br>
	<!--
	<strong>Keterangan</strong>
	<input type="text" value="<? ?> hari x @ IDR <? ?>" readonly="readonly" style="margin-left:0.5cm;"/>
	</br></br>
	
	<strong>Jumlah</strong>
	<input type="text" style="margin-left:1.1cm;" readonly="readonly" id="jumlah" />
	</br></br></br-->
	
	<button class="AddClaim" style="margin-left:2cm; width:100px; height:30px">Add </button>
</form>

<script type="text/javascript">
	$('#to_date').datepicker();
    $('#from_date').datepicker();
	//$('#periode').val('<?= date('n'); ?>');
	//$('#year').val('<?= date('Y'); ?>');
</script>