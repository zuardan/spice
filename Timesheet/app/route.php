<?
/**
 * Configured route is stored in this file
 * 
 * @author vee@gate00.net
 */
/**
 * Protection
 */

session_start();

	if(!isset($_GET['u'])){
		header( 'Location: http://'.$_SERVER['HTTP_HOST'].'/login/') ;
	}
	else{
		$active_u = $_GET['u'];
		$_SESSION['username'] = $active_u;
		
		header( 'Location: http://'.$_SERVER['HTTP_HOST'].'/Timesheet/app/views/timesheet_index.php?page=timesheet') ;

	}



if(!defined('INFRAMEWORK')) {
    exit;
}

$_route = array();

	
?>