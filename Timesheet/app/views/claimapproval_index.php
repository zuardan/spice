<div class="list">

</div>

<script type="text/javascript">
    $('.list').load('claimapproval/list');
    
    $('.createNew a').click(function(){
        
    });
    //search
    $('#searchMonth').live('click',function(){
        var month = $('#month').val();
        var year = $('#year').val();
        var project = $('#project').val();
        $('.list').load('claimapproval/list', {month:month,year:year,project:project} ,function(){
            $('#month').val(month);
            $('#year').val(year);
            $('#project').val(project);
        });
        return false;
    });
    
    $('.page').live('click',function(){
        var page = $(this).data('page');
        var param = $('#param').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var project = $('#project').val();

        $('.list').load('claimapproval/list',{page:page , param:param, month:month, year:year, project:project},function(){
            $('.page').val(page);
            $('#param').val(param);
            $('#month').val(month);
            $('#year').val(year);
            $('#project').val(project);

        });
        return false;
    });
    
     $('#submit').live('click',function(){
        var answers = confirm("Approve? ");
        if(answers){
        $.post('claimapproval/submit', $('form#approval').serializeArray(), function(data) {
                                    $('.list').load('claimapproval/list');

            });
        }
        return false;       
    });
    
    $('#delete').live('click',function(){
        var answer = confirm("Reject? ");
        if(answer){
            $.post('claimapproval/reject', $('form#approval').serializeArray(), function(data) {
                                    $('.list').load('claimapproval/list');

            });
        }
        return false;       
    });
    
    
</script>