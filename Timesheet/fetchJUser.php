<?php 
	//THIS IS AN UNSECURE METHOD TO FETCH USERDATA!!
	//WHEN A BETTER METHOD CAME UP, USE THAT INSTEAD OF THIS
	
	define( '_JEXEC', 1 );
	//define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../../univ/' ));
	define( 'JPATH_BASE', realpath($_SERVER['DOCUMENT_ROOT'].'/webportal/' ));
	define( 'D_S', DIRECTORY_SEPARATOR );
	
	require_once( JPATH_BASE .D_S.'includes'.D_S.'defines.php' );
	require_once( JPATH_BASE .D_S.'includes'.D_S.'framework.php' );
	
	//activate mainframe
	$mainframe =& JFactory::getApplication('site');
	$mainframe->initialise();
	jimport('joomla.plugin.helper');
	
	$user = JFactory::getUser();

	if($user->guest){
		//echo 2;
	}
	if(!$user->guest){		
		 $jml_username = $user->username;
		//get the password
		include('connect.php');
		$q   = "Select * from jml_users where username='$jml_username'";
		$qrs = mysql_query($q,$conn);
		$rsuser  = mysql_fetch_array($qrs);

		$jml_password = $rsuser['password'];
		
		$ecd_username = base64_encode($jml_username);
		$ecd_password = base64_encode($jml_password);
	}
	header( 'Location: http://'.$_SERVER["HTTP_HOST"].'/timesheet?u='.$ecd_username.'&p='.$ecd_password ) ;	
	
	/*
	echo $jml_userid;
	echo "====";
	echo $jml_joindate;
	echo "====";
	echo $jml_password;
	*/
	
?>