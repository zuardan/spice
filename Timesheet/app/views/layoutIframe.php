<!DOCTYPE html>
<html lang="en">
    <head> 

        <base href="<?= $this->config->baseHref; ?>" />

        <title>Phincon</title>
        <script type="text/javascript" src="includes/jquery.js"></script>
        <script type="text/javascript">
            $(function() {
                /* For zebra striping */
                $("table tr:nth-child(odd)").addClass("odd-row");
                /* For cell text alignment */
                $("table td:first-child, table th:first-child").addClass("first");
                /* For removing the last border */
                $("table td:last-child, table th:last-child").addClass("last");
            });
        </script>
        <link rel="stylesheet" href="includes/style.css" type="text/css"/>
        <link rel="stylesheet" href="includes/table.css" type="text/css"/>


        <link rel="stylesheet" href="includes/jsUi/ui-lightness/jquery-ui-1.9.2.custom.css" />
        <script src="includes/jsUi/jquery-ui-1.9.2.custom.js"></script>
        <link rel="stylesheet" media="all" type="text/css" href="includes/timepicker/jquery-ui-timepicker-addon.css" />

        <script type="text/javascript" src="includes/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="includes/timepicker/jquery-ui-sliderAccess.js"></script>        <!-- Fancy Box-->
        <script type="text/javascript" src="includes/timepicker/jquery.mtz.monthpicker.js"></script>        <!-- Fancy Box-->

        <link rel="stylesheet" type="text/css" href="includes/fancybox/jquery.fancybox-1.3.4.css">
        <script type="text/javascript" src="includes/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="includes/js/css/validationEngine.jquery.css" type="text/css"/>
        <script type="text/javascript" src="includes/js/languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="includes/js/jquery.validationEngine.js"></script>		
    </head>
    <body>

        <div class="wrapper">
            <div id="content" style="margin:auto; width:70%;padding:30px;">
                <? $this->content(); ?>
            </div>
        </div>
    </body>
    <script type="text/javascript">

        $('#start_time').timepicker();
        $('#end_time').timepicker();
		
        $('.buttonAdd').live('click',function(){
            if( $(".form").validationEngine('validate')) {
                $.post('timesheet/add', $('form').serializeArray(), function(data) {
                    //confirm(data);
					if(data == 'ok') {
                        $('input').val('');
                        $('.btnadd').attr('disabled', true);
						
						alert("Data Success Inserted");
						
                        parent.$('.list').load('timesheet/list', function() {
                            parent.$('.loading').hide();
                            parent.$('.field').fadeIn();
                            parent.$.fancybox.close();
                        });
                    }else if(data == 'cancel'){
						alert("\tYou are already taken timesheet on this date & time !\nPlease check your timesheet again or check your history timesheet.");						
					}
                    else if(data== 'test'){
                        alert("\tYou are already taken leave or absence on this date & time !\nPlease check your  history leave or absence.");                      
                    }
					else if(data== 'endstart'){
						alert("Please check your selected time");						
					}
                });
            }
            return false;
        });
		
		
		$('.AddClaim').live('click',function(){
            if( $(".form").validationEngine('validate')) {
                $.post('claim/add', $('form').serializeArray(), function(data) {
					//confirm(data);
                    if(data == 'ok') {
                        $('input').val('');
                        $('.btnadd').attr('disabled', true);
						
						alert("Data Success Inserted");
						
                        parent.$('.list').load('claim/list', function() {
                            parent.$('.loading').hide();
                            parent.$('.field').fadeIn();
                            parent.$.fancybox.close();
                        });
                    }else if(data == 'exist'){
						alert("Data Already exists");
					}else if(data == 'weeknotsame'){
						alert("Please fill with same week");}
					else{
						alert("You dont have timesheet in this project");
					}
                });
            }
            return false;
        });
		
		$('.buttonApply').live('click',function(){
            if( $(".form").validationEngine('validate')) {
                $.post('timesheet/add', $('form').serializeArray(), function(data) {
                    if(data == 'ok') {
                        $('input').val('');
                        $('.btnadd').attr('disabled', true);
						
						alert("Data Success Inserted");
						
						parent.load('timesheet/add/?iframe=true', function() {
                            parent.$('.loading').show();
                            parent.$('.field').fadeIn();
                            parent.$.fancybox.close();
                        });
                    }
                });
            }
            return false;
        });
        
        $('.buttonEdit').live('click',function(){
            if( $(".form").validationEngine('validate')) {
                $.post('timesheet/edit', $('form').serializeArray(), function(data) {
                    if(data == 'ok') {
                        $('input').val('');
                        $('.buttonEdit').attr('disabled', true);
						
						alert("Update Data Success");
						
                        parent.$('.list').load('timesheet/list', function() {
                            parent.$('.loading').hide();
                            parent.$('.field').fadeIn();
                            parent.$.fancybox.close();
                        });
                    }
                });
            }
            return false;
        });
    </script>
</html>
