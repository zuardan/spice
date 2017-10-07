<form action="" method="POST" class="form">
   <table width="auto" border="1">
	    <tr>
	      <th scope="row" style="color:#000">From Date</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="date" id="date" value="<?= date('Y/m/d', strtotime($this->value['from_date'])); ?>"/></td>
        </tr>

        <tr>
          <th scope="row" style="color:#000">To Date</th>
          <td style="text-align:left" colspan="3"><input type="text" name="date1" id="date1" value="<?= date('Y/m/d', strtotime($this->value['to_date'])); ?>"/></td>
        </tr>

	    <tr>
	      <th scope="row" style="color:#000">Project Code</th>
	      <td style="text-align:left">   <select name="project" id="project">
          <option value=""></option>
			<? foreach ($this->projectResult as $value) { ?>
                <option value="<?= $value['ProjectID']; ?>"><?= $value['Project']; ?></option>
            <? } ?>
        </select></td>
        </tr>

        <tr>
          <th scope="row" style="color:#000">Days</th>
          <td style="text-align:left" colspan="3"><input type="number" name="day" id="day" step="0.5" value="<?= $this->value['days']; ?>"/></td>
        </tr>

        <tr>
          <th scope="row" style="color:#000">Value</th>
          <td style="text-align:left" colspan="3"><input type="text" name="value" id="value" value="<?= $this->value['value'];?>"/></td>
        </tr>

        <tr>
          <th scope="row" style="color:#000">Jumlah</th>
          <td style="text-align:left" colspan="3"><input type="text" name="jumlah" id="jumlah" value="<?= $this->value['days'] * $this->value['value'];?>"/></td>
        </tr>

         <tr>
          <th scope="row" style="color:#000">No Giro/Cek</th>
          <td style="text-align:left" colspan="3"><input type="text" name="nogiro" id="nogiro" value="-"/></td>
        </tr>

         <tr>
          <th scope="row" style="color:#000">Description</th>
          <td style="text-align:left" colspan="3"><input type="text" name="desc" id="desc" value="<?= $this->value['description']; ?>"/></td>
        </tr>

	    <tr>
	      <input type="hidden" name="id" value="<?= $_GET['id']; ?>"/>
	      <td colspan="4" style="text-align:center"><button class="buttonEdit" style="width:100px; height:30px">Update</button></td>
        </tr>
      </table>
</form>

<script type="text/javascript">
    $("#date").datepicker();
    $("#date1").datepicker();
	$("#project").val('<?= $this->value['ProjectID'];?>');
    $('#value').attr('disabled','disabled');
    $('#jumlah').attr('disabled','disabled');
    $('#nogiro').attr('disabled','disabled');
    $('#desc').attr('disabled','disabled');    
</script>