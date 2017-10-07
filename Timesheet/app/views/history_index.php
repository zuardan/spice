<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('history/list');
    
    $('.createNew a').click(function(){
        
    });
    
	$('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 1000,
            'height' : 300
        });
        return false;
    });

    
       
    //change pages
    $('#page').live('change',function(){
        var page = $(this).val();
        var param = $('#param').val();
        $('.list').load('history/list/',{page:page , param:param},function(){
            $('#page').val(page);
            $('#param').val(param);
        });
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var param = $('#param').val();

        $('.list').load('history/list',{page:page , param:param},function(){
            $('.page').val(page);
            $('#param').val(param);

        });
        return false;
    });
    
    //search
    $('#searchMonth').live('click',function(){
        var from = $('#from').val();
        var employee = $('#employee').val();
		var to = $('#to').val();
        $('.list').load('history/list/', {from:from,employee:employee,to:to} ,function(){
            $('#from').val(from);
            $('#employee').val(employee);
            $('#to').val(to);
        });
        return false;
    });
	
	$('#historyMonth').live('click',function(){
        var from = $('#from').val();
		var employee = $('#employee').val();
		var to = $('#to').val();
        $.post('history/excel/', {from:from,employee:employee,to:to} ,function(){
            $('#from').val(from); 
			$('#employee').val(employee);
			$('#to').val(to);
        });
        //return false;
    });
    
	$('#historyFrom').live('click',function(){
        var from = $('#from').val();
        var to = $('#to').val();
        $.post('history/excel/', {from:from,to:to} ,function(){
            $('#from').val(from);
            $('#to').val(to);       
        });
        // return false;
    });
	
    $('#searchFrom').live('click',function(){
        var from = $('#from').val();
        var to = $('#to').val();
        $('.list').load('history/list/', {from:from,to:to} ,function(){
            $('#from').val(from);
            $('#to').val(to);       
        });
        return false;
    });
    	
    $('.sort').live('click',function(){
        var order = $(this).data('order');
        var param = $('#param').val();

        $('.list').load('history/list',{order:order , param:param},function(){
            if(order == 'DESC'){
                $('.sort').data('order','ASC');
            }else{
                $('.sort').data('order','DESC');
            }
            $('#param').val(param);

        });
        return false;
    });
	
	
    
    
</script>