<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('historyclaimapproval/list');
    
    $('.createNew a').click(function(){
        
    });
    //search
    $('#searchMonth').live('click',function(){
        var month = $('#month').val();
        var employee = $('#employee').val();
        var year = $('#year').val();
        //var project = $('#project').val();
        $('.list').load('historyclaimapproval/list', {month:month,employee:employee,year:year} ,function(){
            $('#month').val(month);
            $('#employee').val(employee);
            $('#year').val(year);
          //  $('#project').val(project);
        });
        return false;
    });
	
	$('.page').live('click',function(){
        var page = $(this).data('page');
        var param = $('#param').val();
		var month = $('#month').val();
        var year = $('#year').val();
		var employee = $('#employee').val();
		var order1 = $('#order1').val();
        $('.list').load('historyclaimapproval/list',{page:page , param:param, month:month, year:year, employee:employee, order1:order1},function(){
            $('.page').val(page);
            $('#param').val(param);
			$('#month').val(month);
            $('#year').val(year);
			$('#employee').val(employee);
			$('#order1').val(employee);
        });
        return false;
    });
	
	//Sorting
	$('.project').live('click',function(){
        var order1 = $(this).data('order1');
        var param = $('#param').val();
		var month = $('#month').val();
        var employee = $('#employee').val();
        var year = $('#year').val();
		var page = $('#page').val();
        $('.list').load('historyclaimapproval/list',{month:month,employee:employee,year:year, order1:order1 , param:param, page:page},function(){
            if(order1 == 'ASC'){
                $('.project').data('order1','DESC');
            }else{
                $('.project').data('order1','ASC');
            }
            $('#param').val(param);
			$('#month').val(month);
            $('#employee').val(employee);
            $('#year').val(year);
			$('#page').val(page);
        });
        return false;
    });
	
	 $('#submit').live('click',function(){
        var answers = confirm("Approve? ");
		if(answers){
		$.post('historyclaimapproval/submit', $('form#approval').serializeArray(), function(data) {
									$('.list').load('historyclaimapproval/list');

			});
		}
		return false;		
    });
	
	$('#delete').live('click',function(){
		var answer = confirm("Reject? ");
		if(answer){
			$.post('historyclaimapproval/reject', $('form#approval').serializeArray(), function(data) {
									$('.list').load('historyclaimapproval/list');

			});
		}
		return false;		
    });
    
    
</script>