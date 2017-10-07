<form action="" method="POST" class="form">
   <table width="auto" border="1">
	    <tr>
	      <th scope="row" style="color:#000">Date</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="date" id="date" class="date validate[required]" value="<?= $this->value['date']; ?>"/></td>
        </tr>
	    <tr>
	      <th scope="row" style="color:#000">Start Time<br /></th>
	      <td style="text-align:left"><input type="text" name="start_time" id="start_time" class="validate[required]" value="<?= $this->value['start_time']; ?>"/></td>
	      <th style="color:#000">End Time</th>
	      <td style="text-align:left"><input type="text" name="end_time" id="end_time" class="validate[required]" value="<?= $this->value['end_time']; ?>"/>
	     </td>
        </tr>
	    <tr>
	      <th scope="row" style="color:#000">Project</th>
	      <td style="text-align:left">   <select name="project" id="project">
			<!--<option value="" style="color:#000">The East</option>-->
			<? foreach ($this->projects as $value) { ?>
                <option value="<?= $value['ProjectID']; ?>"><?= $value['Project']; ?></option>
            <? } ?>
        </select></td>
        <th scope="row" style="color:#000">Location</th>
	       <td style="text-align:left"> <select  name="location" id="location">
		  <? foreach ($this->location as $value) { ?>
        <option value="<?= $value['locationID']; ?>"><?= $value['locationName']; ?></option>
            <? } ?>
      </select></td>
        
        </tr>
   
	    <tr>
	     
	     
	    
        </tr>
	    <tr>
	      <th scope="row" style="color:#000">Shift</th>
	      <td style="text-align:left"> <select name="shift" id="shift">
		  <? foreach ($this->shift as $value) { ?>
        <option value="<?= $value['shiftID']; ?>"><?= $value['shift']; ?></option>
            <? } ?>
      </select></td>
      <th scope="row" style="color:#000">Transport</th>
	      <td style="text-align:left"> <select name="transport" id="transport">
			<? foreach ($this->transport as $value) { ?>
                <option value="<?= $value['transportID']; ?>"><?= $value['transportName']; ?></option>
            <? } ?>
        </select></td>
        </tr>
      
	    <tr>
	      
        </tr>
	    <tr>
         <th scope="row" style="color:#000">Activity</th>
	      <td style="text-align:left"><textarea name="detail" id="detail" class="validate[required]"><?= $this->value['detail']; ?></textarea></td>
                             <!--     <th scope="row" style="color:#000">Productivity</th>
                                  <td style="text-align:left"><select  name="activityID" id="activityID">
                                    <option value="">Others</option>
                                    <? /*foreach ($this->activity as $value) { ?>
                                        <option value="<?= $value['activityID']; ?>"><?= $value['activity']; ?></option>
                                    <? } */?>
                                </select></td>-->
       

        </tr>
	    <tr>
	      
        </tr>
	    <tr>
	      <input type="hidden" name="id" value="<?= $_GET['id']; ?>"/>
	      <td colspan="4" style="text-align:center"><button class="buttonEdit" style="width:100px; height:30px">Update</button></td>
        </tr>
      </table>
</form>

<script type="text/javascript">
    //$("#date").monthpicker();
    //$("#date").datepicker();
	$('#project').val('<?= $this->value['project']; ?>');
    $('#shift').val('<?= $this->value['shift']; ?>');
    $('#location').val('<?= $this->value['location']; ?>');
    $('#transport').val('<?= $this->value['transport']; ?>');
    function reset(){
        $('#location').attr('disabled','disabled');
        $('#shift').attr('disabled','disabled');
        $('#transport').attr('disabled','disabled');
    }
	
	
	if($('#project').text().substr(0,2) != 'MS'){
		$('#shift').attr('disabled','disabled');
	}
	/*else if($('#project').val() != ''){
		$('#shift').attr('disabled','disabled');
	}*/
	else{
		reset(); 
	}
	
    $('#project').change(function(){
        var project = $("option:selected", this).text().substr(0,2);
        var projectCode = $(this).val();
        if(project == 'MS'){
            $('#shift').removeAttr('disabled');
            $('#transport').removeAttr('disabled');
        }else if(project == ''){
			$('#shift').attr('disabled','disabled');
			$('#transport').attr('disabled','disabled');
		}
		else{
            $('#shift').attr('disabled','disabled');
        }
        
        if(projectCode == ''){
            reset();
        }else{
            $('#location').removeAttr('disabled');
        }
        
     
    });

</script>