<!--p><label>Days of work</label>
    <select name ="loop" id="qty">
        <? for ($i = 1; $i <= 7; $i++) { ?>
            <option value="<?= $i; ?>"><?= $i; ?></option>
        <? } ?>
    </select>
</p-->

<!--form action="" method="POST" class="form">
    <div class="dates">
        <? for ($i = 1; $i <= 7; $i++) { ?> 
            <p class="hideAll"><label>Periode <?= $i ?></label>
                <input type="text" name="date[<?= $i ?>]" id="date[<?= $i ?>]"  class="dates<?= $i; ?> validate[required,custom[date]]"/></p>
        <? } ?>
        <button class="buttonAdd">Create</button>
    </div>
</form-->

<form action="" method="POST" class="form">
	<div>

    <!-- Vertical Scroll Bar -->
    <div style="border:0px solid white;width:100%;height:100%; overflow-y:hidden; overflow-x:scroll;">

	  <table width="auto" border="1">
	    <tr>
	      <th scope="row" style="color:#000">Date</th>
	      <td style="text-align:left" colspan="3"><input type="text" name="date" id="date" class="date validate[required]"/></td>
        </tr>
	    <tr>
	      <th scope="row" style="color:#000">Start Time<br /></th>
	      <td style="text-align:left"><input  type="text" name="start_time" id="start_time" class="validate[required]"/></td>
	      <th style="color:#000">End Time</th>
	      <td style="text-align:left"><input type="text" name="end_time" id="end_time" class="validate[required]"/>
	     </td>
        </tr>
	    <tr>
	      <th scope="row" style="color:#000">Project</th>
	      <td style="text-align:left">   <select name="project" id="project">
			<!--<option value="" style="color:#000">The East</option> -->
			<? foreach ($this->project as $value) { ?>
			<? if ($value['Project'] != 'P.Others'){?>
                <option value="<?= $this->projects[$value['Project']]['ProjectID']; ?>"><?= $value['Project']; ?></option>
				<?}?>
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
	      <td style="text-align:left"><textarea id="detail" name="detail" class="validate[required]"><?= $this->value['detail']; ?></textarea></td>
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
	      
	      <td colspan="4" style="text-align:center"><button class="buttonAdd" style="width:100px; height:30px">OK</button></td>
        </tr>
      </table>	  
	</div>
	<!--<button class="buttonApply" style="width:100px; height:30px">Apply</button>-->
</form>

<script type="text/javascript">
    //$('#start_time').datepicker({ dateFormat: 'yy-mm-dd' });
    //$('#end_time').datepicker({ dateFormat: 'yy-mm-dd' });
    $('.hideAll').hide();
    $('.dates1').parent("p").show();
	$('#project').val('');
    $('#shift').val('');
    $('#location').val('');
    $('#transport').val('');
	
	/*function reset(){
        $('#location').attr('disabled','disabled');
        $('#shift').attr('disabled','disabled');
        $('#transport').attr('disabled','disabled');
    }
	
	
	reset(); 
	$('#project').change(function(){
        var project = $("option:selected", this).text().substr(0,2);
        var projectCode = $(this).val();
		var projects = $("option:selected", this).text().substr(0,1);
        if(project == 'MS'){
            $('#shift').removeAttr('disabled');
            $('#transport').removeAttr('disabled');
        }else if(projects == 'P'){
			$('#shift').removeAttr('disabled');
			$('#shift').val('');
			$('#location').val('');
			$('#transport').removeAttr('disabled');
		}
		else{
            $('#shift').attr('disabled','disabled');
			$('#shift').val('');
			$('#location').val('');
			$('#transport').val('');
        }
        
        if(projectCode == ''){
            reset();
        }else{
            $('#location').removeAttr('disabled');
        }
        
     
    });*/
    $('#qty').change(function(){
        var quantity = $(this).val();
        $('.hideAll').hide();
        for (i = 1; i <= quantity; ++i) {
            $('.dates'+i).parent("p").show();
        }    
    });
	$("#date").datepicker();
   /* $('#project').change(function(){
        if($(this).val() == ''){
            $('#location').aiv('disabled','disabled');
        }
        
        if($(this).val()=='MS'){
        }
        
     
    });*/
</script>

