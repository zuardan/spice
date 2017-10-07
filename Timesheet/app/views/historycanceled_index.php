<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('historycanceled/list');
    
    $('.createNew a').click(function(){
        
    });
    

    $('a.iframe').live('click',function(){
        $('a.iframe').fancybox({
            padding:0, 
            margin:0,
            showCloseButton:true,
            enableEscapeButton:true,
            'width' : 800,
            'height' : 400
        });
        return false;
    });
    
   //change pages
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var from = $('#from').val();
		var to = $('#to').val();
		var employee = $('#employee').val();

        $('.list').load('historycanceled/list',{page:page, from:from, to:to, employee:employee},function(){
            $('.page').val(page);
            $('#from').val(from);
			$('#to').val(to);
			$('#employee').val(employee);

        });
        return false;
    });
   
    //search
    $('#searchMonth').live('click',function(){
        var from = $('#from').val();
		var to = $('#to').val();
		var employee = $('#employee').val();
        $('.list').load('historycanceled/list', {from:from, to:to, employee:employee} ,function(){
            $('#from').val(from);
            $('#to').val(to);
			$('#employee').val(employee);
        });
        return false;
    });
</script>