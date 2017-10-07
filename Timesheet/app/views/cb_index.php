
<div class="list">

</div>

<script type="text/javascript">
	$('.list').load('cb/list');
    
    $('.createNew a').click(function(){
        
    });
	
	$('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 800,
            'height' : 500
        });
        return false;
    });
    
    $('.sort').live('click',function(){
        var order = $(this).data('order');
        var param = $('#param').val();
		var month = $('#periode').val();
		var year = $('#year').val();
        $('.list').load('cb/list',{order:order , param:param, month:month, year:year},function(){
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
    
    $('#chargeable').live('click',function(){
	  var answer = confirm('This is Chargeable?');
	  if(answer) {        
	  $.post('cb/chargebel', $('#cb').serializeArray(), function(data) {
            if(data == 'ok'){
                $('.list').load('cb/list');
            }
        });
		}else{
		}
        return false;
    });
    
	$('#billable').live('click',function(){
	  var answer = confirm('This is Billable?');
	  if(answer) {        
	  $.post('cb/billable', $('#cb').serializeArray(), function(data) {
			confirm(data);
            if(data == 'ok'){
                $('.list').load('cb/list');
            }
        });
		}else{
		}
        return false;
    });
	
	$('#non_chargeable').live('click',function(){
	  var answer = confirm('This is Non Chargeable?');
	  if(answer) {        
	  $.post('cb/non_chargebel', $('#cb').serializeArray(), function(data) {
            if(data == 'ok'){
                $('.list').load('cb/list');
            }
        });
		}else{
		}
        return false;
    });
	
    //change pages
    $('#page').live('change',function(){
        var page = $(this).val();
	    var month = $('#month').val();
	    var employee = $('#employee').val();
	    //var order = $data('order').val();
      $('.list').load('cb/list/',{page:page,month:month, employee:employee},function(){
            $('#page').val(page);
            $('#month').val(month);
            $('#employee').val(employee);
            //$data('order').val(order);
        });
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');        
	    var month = $('#month').val();
	    var employee = $('#employee').val();
        $('.list').load('cb/list',{page:page,month:month, employee:employee},function(){
            $('.page').val(page);
            $('#month').val(month);
            $('#employee').val(employee);

        });
        return false;
    });
    
	
	$('#searchMonth').live('click',function(){
        var month = $('#month').val();
        var employee = $('#employee').val();
        $('.list').load('cb/list/', {month:month,employee:employee} ,function(){
            $('#month').val(month);
            $('#employee').val(employee);
        });
        return false;
    });
</script>