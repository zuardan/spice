<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('claim/list');
    
    $('.create a').click(function(){
        
    });
    
    $('.create b').click(function(){
        
    });

	$('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 450,
            'height' : 250
        });
        return false;
    });

    $('b.iframe').live('click',function(){
        $('b.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 600,
            'height' : 500
        });
        return false;
    });

   
    
    //search
    $('#searchMonth').live('click',function(){
        var month = $('#month').val();
        var employee = $('#employee').val();
        var year = $('#year').val();
        //var project = $('#project').val();
        $('.list').load('claim/list/', {month:month,employee:employee,year:year} ,function(){
            $('#month').val(month);
            $('#employee').val(employee);
            $('#year').val(year);
          //  $('#project').val(project);
        });
        return false;
    });
	
	$('#claimMonth').live('click',function(){
        var month = $('#month').val();
        var employee = $('#employee').val();
        var year = $('#year').val();
        $.post('claim/excel/', {month:month,employee:employee,year:year} ,function(){
            $('#month').val(month);
            $('#employee').val(employee);
            $('#year').val(year);
        });
        //return false;
    });
    
	$('#historyFroma').live('click',function(){
        var from = $('#from').val();
        var to = $('#to').val();
        $.post('claim/excel/', {from:from,to:to} ,function(){
            $('#from').val(from);
            $('#to').val(to);       
        });
        // return false;
    });
	
    $('#searchFrom').live('click',function(){
        var from = $('#from').val();
        var to = $('#to').val();
        $('.list').load('claim/list/', {from:from,to:to} ,function(){
            $('#from').val(from);
            $('#to').val(to);       
        });
        return false;
    });
    	
    $('.sort').live('click',function(){
        var order = $(this).data('order');
        var param = $('#param').val();

        $('.list').load('claim/list',{order:order , param:param},function(){
            if(order == 'DESC'){
                $('.sort').data('order','ASC');
            }else{
                $('.sort').data('order','DESC');
            }
            $('#param').val(param);

        });
        return false;
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var param = $('#param').val();

        $('.list').load('claim/list',{page:page , param:param},function(){
            $('.page').val(page);
            $('#param').val(param);

        });
        return false;
    });
	
	 $('.delete').live('click',function(){
        var answer = confirm('Are you sure want to Delete?');
	  if(answer) { 
		$.post('claim/remove', {id: $(this).data('id')}, function(data) {
			//confirm(data);
            if(data == 'ok'){
                $('.list').load('claim/list');
            }
        });
		}else{
		}
        return false;
    });
    
    
</script>