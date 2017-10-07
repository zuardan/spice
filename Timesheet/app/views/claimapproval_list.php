<div class="head">
	<span>
		</br>
		<span>
		
		</span>

		<form action="claimapproval/list" method="POST">
        <table width="200" border="1">
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
		</select> 
		
		<!--tambahan-->
			<select id="project" nama="project" style="width:auto;height:25px">
				<option value="">All Project</option>
				<? foreach ($this->projectResult as $value) {?>
					<? if ($value['Project'] != 'P.Others'){?>
					<option value="<?= $value['ProjectID']; ?>"><?= $value['Project']; ?></option>
				<? } ?>
				<? } ?>
			</select>
		<!--end-->
			
		<button id="searchMonth" style="width:100px;height:30px">Search</button>
			</td></tr>
            </table>

			<br /></br></br>
        </span>
		</form>
	</span>
</div>

<!--tambahan-->

<form action="claimapproval/submit" method="POST" id="approval">
<table cellspacing="1" class="">

	<tr>
		<th width="1"><input type="checkbox" class="checkAll"/></th>
		<th>Nama</th>
		<th>Tanggal Pengajuan</th>
		<th>Project Code</th>
		<th colspan="3">Keterangan</th>
		<th>Jumlah</th>
		<th>No Giro/Cek</th>
		<th>Status</th>
	</tr>
	<? if($this->sheets) { ?>
	<? foreach($this->sheets as $sheet) {
	?>
	
	<tr>
		<td><input type="checkbox" name="data[<?= $sheet['claimID'] ?>]" data-id="data[<?= $sheet['claimID'] ?>]" class="data"/></td>
		<td><?= $sheet['name'] ?></td>
		<td><?= date('j M Y', strtotime($sheet['date'])); ?> </td>
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
				$subtotal1 = $subtotal1 + $subtotal;
		?>  
		<td>Rp. <?= number_format( $this->projectResult[$sheet['projectID']]['value'], 0 , '' , '.' ) . ',-'; ?> </td>
		<td>Rp. <?= number_format( $subtotal, 0 , '' , '.' ) . ',-'; ?></td>
		<td>-</td>
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
	
	<? } ?>
	<? } else { ?>
		<td colspan="8">No Data</td> 
	<? } ?>

</table>

<table>
	<th>TOTAL CLAIM = </th>
    <td>Rp. <?= number_format( $subtotal1, 0 , '' , '.' ) . ',-'; ?></td>
</table>

</table>

</table>
<br></br>
	<p><div align="center" class="description" id="description" name="description">
	<h1> <p  style="color:#FFF; margin-left:450px">Description :</p> </div> </h1>
    
    <br />
	  <p> <span>
   <div align="center">   <textarea name="desciption" cols="50" rows="5">-</textarea>
      </span></p></div>
	  </p>
	<br></br>  
	<div align="center"><p><button id="submit" style="width:100px; height:30px">Approve</button>
    <!--button id="delete" style="width:100px; height:30px">Reject</button--></div>
	</br></br></br>
</form>


<script type="text/javascript">
	$('#month').val('<?= date('n'); ?>');
	$('#year').val('<?= date('Y'); ?>');
	$('#employee').val('<?= $this->userdata->employeeID; ?>');
	
	$('.checkAll').click(function(){
		var check = $(this).attr('checked');
		if(check == 'checked'){
			$('.data').attr('checked',true);
		}else{
			$('.data').attr('checked',false);
		}
	});
	
</script>