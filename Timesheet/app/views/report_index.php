
<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('report/list');
    
    $('.createNew a').click(function(){
        
    });
	
	$('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 500,
            'height' : 200
        });
        return false;
    });
    
    //search
    $('#searchMonth').live('click',function(){
        var month = $('#month').val();
        var year = $('#year').val();
        var employee = $('#employee').val();
        $('.list').load('report/list/', {month:month,employee:employee,year:year} ,function(){
            $('#month').val(month);
            $('#employee').val(employeee);
            $('#year').val(year);
        });
        return false;
    });
    
    /*$('#reportMonth').live('click',function(){
        var month = $('#month').val();
        $.post('report/excel/', {month:month} ,function(){
            $('#month').val(month);
        });
        //   return false;
    });*/
	
	$('#reportMonth').live('click',function(){
        var month = $('#month').val();
		var employee = $('#employee').val();
		var year = $('#year').val();
        $.post('report/excel/', {month:month,employee:employee,year:year} ,function(){
            $('#month').val(month); 
            $('#employee').val(employee); 
            $('#year').val(year); 
        });
        //return false;
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var month = $('#month').val();
		var employee = $('#employee').val();
		var year = $('#year').val();

        $('.list').load('report/list',{page:page,month:month,employee:employee,year:year},function(){
            $('.page').val(page);
            $('#month').val(month); 
            $('#employee').val(employee); 
            $('#year').val(year); 

        });
        return false;
    });
</script>