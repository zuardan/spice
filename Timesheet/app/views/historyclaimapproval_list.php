<div class="head">
	<span>
		</br>
		<span>
		
		</span>

		<form action="historyclaimapproval/list" method="POST">
        <table width="200" border="1">
              
                <th scope="row">Employee</th>
                <td style="text-align:left"><select id ="employee" name="employee" style="width:auto;height:25px">
				<option value="all">All Employee</option>
				<? foreach ($this->allEmployee as $val) { ?>
					<option value="<?= $val['employeeID']; ?>"> <?= $val['name']; ?> </option>
				<? } ?>
				</select>
           </td>
			  <tr>
			<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
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
			</td></tr>
            </table>

			<br /></br></br>
        </span>
		</form>
	</span>
</div>
<form action="claimapproval/submit" method="POST" id="approval">
<table cellspacing="1" class="">
	<tr>
		<th>No</th>
		<th>Nama</th>
		<th>Tanggal</th>
		<th><!--a href="javascript:;" data-order1="ASC" class="project"-->Project Code</th>
		<th colspan="3">Keterangan</th>
		<th>Jumlah</th>
		<th>No Giro/Cek</th>
		<th>Description</th>
		<th>Date Approved</td>
		<th>Status</th>
	</tr>
	<? if($this->sheets) { ?>
	<? foreach($this->sheets as $sheet) {
	?>
	<tr>
		<td><?= $c=$c+1; ?></td>
		<td><?= $sheet['name'] ?></td>
		<td><? echo date('j', strtotime($sheet['from_date'])) ." s/d ". date('j M Y', strtotime($sheet['to_date'])) ?></td>
		<td><?= $this->projectResult[$sheet['projectID']]['Project'] ?></td>
		<? $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'); ?>
		<td><?= $sheet['days'] ?></td>
		<td>hari x @ </td>
		<? 
			IF($sheet['shift'] == '0'){
				$subtotal = $sheet['days'] * $this->projectResult[$sheet['projectID']]['value'];
			}else{
				$subtotal = $sheet['days'] * $this->projectResult[$sheet['projectID']]['value'];
			}	
		?>  
		<td>Rp. <?= number_format($this->projectResult[$sheet['projectID']]['value'], 0 , '' , '.' ) . ',-'; ?> </td>
		<td>Rp. <?= number_format($subtotal, 0 , '' , '.' ) . ',-'; ?></td>
		<td>-</td>
		<td><?= $sheet['description'] ?></td>
		<td><?= date('j M Y', strtotime($sheet['approved_date'])); ?></td>
		<td><?if($sheet['status']=='Rejected'){
								echo "<img src='images/x.jpg' width='18' height='18' title='Rejected' />";
							}
							else if($sheet['status']=='Approved'){
								echo "<img src='images/v.jpg' width='18' height='18' title='Approved' />";
							}
							else
								echo "<img src='images/waiting.png' width='18' height='18' title='Waiting Approval' />";
						?></td>
	</tr>
	<input type="hidden" id="order1" name="order1" value="<?= $this->order1 ?>"/>
	<? } ?><tr>
			<td colspan="13" style="font-weight:bold;font-size:14px">
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
		<td colspan="12">No Data</td> 
	<? } ?>
</table>
</form>


<script type="text/javascript">
	$('#month').val('<?= date('n'); ?>');
	$('#year').val('<?= date('Y'); ?>');
	$('#employee').val('');
	
	$('.checkAll').click(function(){
		var check = $(this).attr('checked');
		if(check == 'checked'){
			$('.data').attr('checked',true);
		}else{
			$('.data').attr('checked',false);
		}
	});
	
</script>