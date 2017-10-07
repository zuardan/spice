<?
//print_r($_GET);exit;
/**
 * This file is run before Controller's preDispatch
 * 
 * Not a good method, but will keep things easy
 */
// db instance, uses singleton, unquote to use
$this->db = Crayd_Database::factory();

// Auth
$this->auth = new Crayd_Auth();


//Login user

$login['username'] 	= base64_decode($_GET['u']);
$login['password']	= base64_decode($_GET['p']);

if($login['username']!=''&&$login['password']!='')
{	
	//print_r('not null');
	$result = $this->auth->Login($login['username'],$login['password']);
	//print_r($login['username'].$login['password'].'<br>'.$result.'<br>');print_r($_REQUEST);exit;
	//echo $result;exit;
	if ($result == 1) {
		$active_user = '';
		$active_id = '';
		$active_joindate = '';
		//$this->_redirect('timesheet');
	}
}

// pass userdata to registry
Crayd_Registry::set('user', $this->auth->user);

$this->user = $this->auth->user;



$this->view->userdata = $this->view->user = $this->user;
