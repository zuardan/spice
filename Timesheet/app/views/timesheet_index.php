
<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('timesheet/list');
    
    $('.createNew a').click(function(){
        
    });
    

    $('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 800,
            'height' : 430
        });
        return false;
    });
    
    $('#submit').live('click',function(){
	  var answer = confirm('Want to Submit?');
	  if(answer) {
        //$(this).submit();
		$.post('timesheet/submit', $('#timesheet').serializeArray(), function(data) {
           //alert(data);
            if(data == 'ok'){
                $('.list').load('timesheet/list');
            }
			else{
				alert("Data Already Exist");           
			}
        });
		}else{
			return false;
		}
    });
	
    $('.sort').live('click',function(){
        var order = $(this).data('order');
        var param = $('#param').val();
		var month = $('#periode').val();
		var year = $('#year').val();
        $('.list').load('timesheet/list',{order:order , param:param, month:month, year:year},function(){
            if(order == 'DESC'){
                $('.sort').data('order','ASC');
            }else{
                $('.sort').data('order','DESC');
            }
            $('#param').val(param);
			$('#periode').val(month);
            $('#year').val(year);

        });
        return false;
    });
    
    $('#delete').live('click',function(){
	  var answer = confirm('Are you sure want to Delete?');
	  if(answer) {        
	  $.post('timesheet/remove', $('#timesheet').serializeArray(), function(data) {
            if(data == 'ok'){
                $('.list').load('timesheet/list');
            }
        });
		}else{
		}
        return false;
    });
	
    $('.copy').live('click',function(){
        var answer = confirm('Want to copy?');
	  if(answer) { 
		$.post('timesheet/clone', {id: $(this).data('id')}, function(data) {
			//confirm(data);
            if(data == 'ok'){
                $('.list').load('timesheet/list');
            }
        });
		}else{
		}
        return false;
    });
    
    //change pages
    $('#page').live('change',function(){
        var page = $(this).val();
        var param = $('#param').val();
	    var month = $('#periode').val();
	    var year = $('#year').val();
	    //var order = $data('order').val();
      $('.list').load('timesheet/list/',{page:page , param:param, month:month, year:year},function(){
            $('#page').val(page);
            $('#param').val(param);
            $('#periode').val(month);
            $('#year').val(year);
            //$data('order').val(order);
        });
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var param = $('#param').val();
	    var month = $('#periode').val();
	    var year = $('#year').val();

        $('.list').load('timesheet/list/',{page:page , param:param, month:month, year:year},function(){
            $('.page').val(page);
            $('#param').val(param);
            $('#periode').val(month);
            $('#year').val(year);

        });
        return false;
    });
    
    //search
    $('#search').live('click',function(){
        var param = $('#param').val();
        $('.list').load('timesheet/list/', {param:param} ,function(){
            $('#param').val(param);
        });
        return false;
    });
	
	$('#searchMonth').live('click',function(){
        var month = $('#periode').val();
        var year = $('#year').val();
        $('.list').load('timesheet/list/', {month:month,year:year} ,function(){
            $('#periode').val(month);
            $('#year').val(year);
        });
        return false;
    });
</script>