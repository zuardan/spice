<?php
	// Connection to Database
	
	//Ver. PHP
	
	ini_set('display_errors',FALSE);
	$host="localhost";
	$user="root";
	$pass="";
	//$db="jml_phinconportal";
	$db="master";
	
	$conn = mysql_connect($host,$user,$pass);
	mysql_select_db($db,$conn);
	
	if(!$conn)
	{
		?><script language="javascript">alert("Connection to Database Error. Please Contact  you System Administrator!!")</script><?php
	}

?>