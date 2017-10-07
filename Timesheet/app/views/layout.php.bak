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


        <link rel="stylesheet" href="includes/jsUI/ui-lightness/jquery-ui-1.9.2.custom.css" />
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
					<nav id="menu">
						<ul>
							<!--img src="images/home.png" class="logo"></a-->
							<li class="nav1" <? if($_REQUEST['_controller']=="timesheet" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="timesheet"> Timesheet</a>
							 
							<li class="nav2" <? if($_REQUEST['_controller']=="history" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="history">History</a>    
							<li class="nav3" <? if($_REQUEST['_controller']=="timesheet" && $_REQUEST['_action']=="import") {?> id="active" <? } ?>><a href="timesheet/import">Import</a>    
							<? IF($this->user->types != 1 AND $this->user->types != 2) { ?>		
							<li class="nav4" <? if($_REQUEST['_controller']=="report" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="report">Report</a>  <? } ?>  
							<? IF($this->user->types != 1) { ?>	
							<li class="nav5" <? if($_REQUEST['_controller']=="approval" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="http://<?= $_SERVER["HTTP_HOST"] ?>/approval/">Approval</a>       <? } ?>  
							<?  { ?>	
							<li class="nav6" <? if($_REQUEST['_controller']=="claim" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="claim">Claim</a>       <? } ?>  
							<? IF($this->user->types != 1) { ?>	
							<!--<li class="nav7" <? if($_REQUEST['_controller']=="cb" && $_REQUEST['_action']=="index") {?> id="active" <? } ?>><a href="cb">Productivity</a>-->       <? } ?>  
							<!--a href="logout"> <img src="images/logout.png" class="logo"></a-->
						</ul>
					</nav>
				</div>
            </div>
        </div>
		
		<div class="body3">
			<div class="body4">
				<div class="main">
					<? $this->content(); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
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
