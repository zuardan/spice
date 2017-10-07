<?
	include("koneksi.php");
	include("test/session.php");
?>

<?

class indexController extends Crayd_Controller {

    public function preDispatch() {
        
    }

    public function indexAction() {
		$this->_redirect('timesheet');
    }

    public function loginAction() {
        $this->view->setLayout('layoutLogin.php');
        if ($this->getRequest()->isPost()) {
            $data = $_POST;
            $result = $this->auth->login($data['username'], $data['password']);
            if ($result == 1) {
                $this->_redirect('timesheet');
            }
        }
    }

	/*public function loginAction() {
		$this->view->setLayout('layoutLogin.php');
		
		$result = $this->auth->login($_SESSION["author"], $_SESSION["password"]);
		if ($result == 1) {
			$this->_redirect('timesheet');
		}
    }
	*/

    public function logoutAction() {
        $this->auth->logout();
		session_destroy();
        $this->_redirect('http://'.$_SERVER["HTTP_HOST"].'/login/');
		//$this->_redirect('login');
    }

}
