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
		<link rel="stylesheet" type="text/css" href="includes/menu_files/swimbi.css"/>

        <link rel="stylesheet" href="includes/jsUi/ui-lightness/jquery-ui-1.9.2.custom.css" />
        <script src="includes/jsUi/jquery-ui-1.9.2.custom.js"></script>
        <link rel="stylesheet" media="all" type="text/css" href="includes/timepicker/jquery-ui-timepicker-addon.css" />

        <script type="text/javascript" src="includes/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="includes/timepicker/jquery-ui-sliderAccess.js"></script>
        <!-- Fancy Box-->
        <link rel="stylesheet" type="text/css" href="includes/fancybox/jquery.fancybox-1.3.4.css">
        <script type="text/javascript" src="includes/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" href="includes/js/css/validationEngine.jquery.css" type="text/css"/>
        <script type="text/javascript" src="includes/js/languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="includes/js/jquery.validationEngine.js"></script>			
		
		
		<script type="text/javascript" src="js/cufon-yui.js"></script>
		<script type="text/javascript" src="js/cufon-replace.js"></script>  
		<script type="text/javascript" src="js/Copse_400.font.js"></script>
		<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
		<script type="text/javascript" src="js/imagepreloader.js"></script>
		
		<script type="text/javascript">
			preloadImages([
			'images/menu1_active.gif',
			'images/menu2_active.gif',
			'images/menu3_active.gif',
			'images/menu4_active.gif',
			'images/marker_right_active.jpg',
			'images/marker_left_active.jpg',
			'images/menu5_active.gif']);
		</script>
    </head>
    <body>

    
    <div class="body1">
		<div class="body2">
			<div class="main">
				<div class="wrapper">	
					<div id="swimbi">
    <ul>
    
	<?//if($this->user->status == 'ACTIVE' || $this->user->status == 'PROBATION') {?>
        <li><a data-icon="f022" href="timesheet">Timesheet</a>
            <ul>
                <li><a data-icon="f0f6" href="timesheet">Create Timesheet</a></li>
                <li><a data-icon="f03a" href="history">History Timesheet</a></li>
            </ul>
        </li>
        <li><a data-icon="f1c2" href="timesheet/import">Import</a></li>
       
	  <? IF($this->user->types == '3') { ?>	
		<li><a data-icon="f080" href="report">Report</a>
			<ul>
                <li><a data-icon="f080" href="attendancereport">Attendance Report</a></li>
            </ul>
		</li><?}?>
		
		<? IF($this->user->types == 2 or $this->user->types == 3) { ?>	
        <li><a data-icon="f046">Approval</a>
            <ul>
                <li><a data-icon="f046" href="../approval/approval/">Approve Timesheet</a></li>
				<li><a data-icon="f03a" href="historyapproval">History Approval</a></li>
				<li><a data-icon="f03a" href="historycanceled">History Canceled</a></li>
            </ul>
        </li><?}?>
        <li><a data-icon="f09d" href="claim">Claim</a><?if ($this->user->employeeID=='2080102081-AI' OR $this->user->employeeID=='DUMMY_1'){ ?>
		<ul>
                <li><a data-icon="f046" href="claimapproval">Claim Approval</a></li>
				<li><a data-icon="f03a" href="historyclaimapproval">History Claim Approval</a></li> 				
            </ul><? } ?>
		</li>
		<?//}?>
    </ul>
</div>
<script src="includes/menu_files/swimbi.js"></script>
				</div>
            </div>
        </div>
		
		<div class="body3">
			<div class="body4">
			<?//if ($this->user->status == 'ACTIVE' || $this->user->status == 'PROBATION'){?>
				<div class="main">
				<br><br><br><br><br><br>
				<div style="color:#fff; text-align:center; font:24px Arial, Helvetica, sans-serif; font-weight: bold;">
				
				<? 	if($_REQUEST['_controller']=="timesheet" && $_REQUEST['_action']=="index") { echo "<br>Create Timesheet";}
					if($_REQUEST['_controller']=="history" && $_REQUEST['_action']=="index") { echo "<br>History Timesheet";}
					if($_REQUEST['_controller']=="timesheet" && $_REQUEST['_action']=="import") { echo "<br>Import";}
					if($_REQUEST['_controller']=="report" && $_REQUEST['_action']=="index") { echo "<br>Report";}
					if($_REQUEST['_controller']=="attendancereport" && $_REQUEST['_action']=="index") { echo "<br>Attendance Report";}
					if($_REQUEST['_controller']=="historyapproval" && $_REQUEST['_action']=="index") { echo "<br>History Approval";}
					if($_REQUEST['_controller']=="historycanceled" && $_REQUEST['_action']=="index") { echo "<br>History Canceled";}
					if($_REQUEST['_controller']=="approval" && $_REQUEST['_action']=="index") { echo "<br>Timesheet Approval";}
					if($_REQUEST['_controller']=="claim" && $_REQUEST['_action']=="index") { echo "<br>Claim";}
					if($_REQUEST['_controller']=="claimapproval" && $_REQUEST['_action']=="index") { echo "<br>Claim Approval";}
					if($_REQUEST['_controller']=="historyclaimapproval" && $_REQUEST['_action']=="index") { echo "<br>History Claim Approval";}?></div>
					<? $this->content(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php 
		$session = $this->user->types; 
		//var_dump($this->user);
		if(!$session ){
				header( 'Location: http://localhost:8080/webportal') ;
				//echo 'kosong woi';

			}
	?>	
</body>
</html>

<script>
/*
$(document).ready(function(){
			var session = '<?php echo $this->user->types;?>';
			alert(session);
			var asd = '<?php var_dump($this->user);?>';
			alert(asd);
			if(!session){
				//window.location = "http://localhost:8080/webportal";
			}
});
*/

sfHover = function() {

	var sfEls = document.getElementById("navbar").getElementsByTagName("li");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" hover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" hover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>

	