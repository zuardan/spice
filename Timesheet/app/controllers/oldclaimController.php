<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class claimController extends Crayd_Controller {

	public function preDispatch() {
		$this->view->allEmployee = $this->db->fetchAll("SELECT * FROM jml_users WHERE employeeID <> 1 order by name");
	}
	
	public function addAction() {
        if (isset($_GET['iframe'])) {
            $this->view->setLayout('layoutIframe.php');
            $this->view->isIframe = true;
        } else {
            $this->view->setLayout('layoutBlank.php');
        }
		
		//$this->view->project = $this->db->fetchAll("SELECT DISTINCT Project FROM project WHERE value > 0");
		$this->view->projects = $this->db->fetchAll("SELECT * FROM project ORDER BY ProjectID DESC", true, "Project");
		$this->view->project = $this->db->fetchAll("SELECT DISTINCT Project FROM project WHERE value > 0");
		
		if ($this->getRequest()->isPost()) {
			$data = $_POST;
			$this->view->setView('ajax');
			$period = $data['period'];
			$projects = $data['projectID'];
			$employeeID = $this->user->employeeID;
			$data['shift'] = 0;
			$sql = "SELECT pro.*,detail.shift
					FROM timesheet_approved  app, timesheet_detail detail, transport pro, timesheet time
					WHERE app.status = 'approved'
					AND app.timesheet_id = detail.timesheetID
					AND detail.transport = pro.transportID
					AND time.timesheetID = detail.timesheetID
					AND MONTH(detail.date) = $period
					AND detail.project = $projects
					AND time.employeeID = '$employeeID'";
			//$this->view->sheets = $this->db->fetchAll($sql);
			$sheets = $this->db->fetchAll($sql);
			foreach($sheets as $value){
				$data['days'] = $data['days'] + $value['value'];				
				if($value['shift'] == '2'){
					$data['shift'] = $data['shift'] + 1;					
				}
				//echo $days;
			}
			//$days = 1; //dummy
			$data['days'] = $data['days'] / 2; 
			//$data['days'] = $data['period'];
			$data['NIK'] = $employeeID;
			$data['date'] = date('Y-m-d');
			
			$project = $data['projectID'];
			$year = $data['year'];
			$sql="SELECT * FROM claim WHERE projectID = '$project' AND NIK = '$employeeID' AND period = '$period' AND year = '$year'";
			IF($this->db->count($sql) > 0){
				$flag = 1;
			}
			//exit;
			if($data['days'] != 0){
				IF($flag == 1){
					echo 'exist';
				}else{
					$this->db->insert('claim', $data);
					echo 'ok';
				}
				//echo $sql;
				//echo $value['value'];
			}
			else{
				echo 'Wrong Input!';
				//echo $sql;
			}
        }
	}
	
    public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		
		//$where = "WHERE approved.status = 'approved' AND  MONTH(date) = ";
		//$where = "WHERE MONTH(date) = ";
        
        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="WHERE period = {$_REQUEST['month']} ";
        }
		else {
			$where .="WHERE period = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .="AND year = {$_REQUEST['year']} ";
        }
		else {
			$where .="AND year = YEAR(CURDATE()) ";
		}
		
		if ($_REQUEST['employee']){
			$where .="AND NIK = '{$_REQUEST['employee']}'";
		}
		else {
			$emp = $this->user->employeeID;
			$where .="AND NIK = '$emp'";
		}
		
		if ($_REQUEST['project']){
			$where .="AND projectID = '{$_REQUEST['project']}'";
		}
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 10;
		
        $sql = " 
        SELECT * from claim
		$where";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
        SELECT * from claim
		$where 
		ORDER BY date DESC
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
		
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");		
		$sql = "SELECT * FROM project ORDER BY ProjectID DESC";
        $this->view->projectsResult = $projectsResult = $this->db->fetchAll($sql, true, "ProjectID");
		$sql = "SELECT * FROM project WHERE shift = '2'";
        $this->view->projectsResult2 = $projectsResult = $this->db->fetchAll($sql, true, "Project");			
		echo $projectsResult['value'];
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
        $this->view->valueShift = $valueShift = $this->db->fetchAll("SELECT * FROM shift", true, "shiftID");
		
		
		$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		foreach ($sheets as $value) {
            $sql = "SELECT name FROM employee WHERE employeeID={$value['approve_id']}";
            if ($this->db->count($sql) > 0) {
                $approverID[$value['approve_id']] = $this->db->fetchRow($sql);
            }

            $sql = "SELECT date FROM timesheet_detail WHERE timesheetID={$value['timesheet_id']}";
            if ($this->db->count($sql) > 0) {
                $period[$value['timesheetID']] = $this->db->fetchRow($sql);
            }
			
			$sql = "SELECT date FROM timesheet_detail WHERE timesheetID = {$value['timesheet_id']}";
			if ($this->db->count($sql) > 0) {
				$dates[$value['timesheetID']] = $this->db->fetchRow($sql);
			}
			
			$sql = "SELECT time.employeeID, detail.project,DATE, COUNT(DATE) days
					FROM timesheet_detail detail,timesheet TIME,timesheet_approved app
					AND time.timesheetID = detail.timesheetID
					AND app.timesheet_id = detail.timesheetID
					AND app.status = 'approved'
					AND time.employeeID = '{$value['employeeID']}'
					AND MONTH(DATE) = 3";
			if ($this->db->count($sql) > 0) {
				$test[$value['employeeID']] = $this->db->fetchRow($sql);
			}
		}
		
        $this->view->approverID = $approverID;
        $this->view->period = $period;
        $this->view->test = $test;
        
        foreach ($this->view->sheets as $value) {
			IF($this->view->valueShift[$value['shift']]['value'] > 1){
				$proj = $value['project'];
				$shift = $value['shift'];
				$sql = "SELECT * FROM project WHERE ProjectID = '$proj';";
				$val = $this->db->fetchRow($sql);
				$project = $val['Project'];
				$sql = "SELECT value FROM project WHERE Project = '$project' AND shift = '$shift';";
				$val = $this->db->fetchRow($sql);
				foreach($val as $val){
					$harga = $val['value'];
				}
				$subtotal[$value['project']]['subtotal'][] = (
					$this->view->projectResult[$value['project']]['value'] 
					* $this->view->valueLocation[$value['location']]['value'] 
					* $this->view->valueTransport[$value['transport']]['value']
					+ $harga
				);
			}else{
				$subtotal[$value['project']]['subtotal'][] = ($this->view->projectResult[$value['project']]['value'] * $this->view->valueLocation[$value['location']]['value'] * $this->view->valueTransport[$value['transport']]['value']) / 2;			
			}
		}
		
		$this->view->subtotal = $subtotal;
    }
	
	public function excelAction() {
        $this->view->setLayout('layoutExcel.php');
		echo "as";
        $this->view->filename = 'Claim' . '.xls';

        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="WHERE period = {$_REQUEST['month']} ";
			$this->view->month = $_REQUEST['month'];
        }
		else {
			$where .="WHERE period = MONTH(CURDATE()) ";
			$this->view->month = date('M');
		}
		
		if ($_REQUEST['year']) {
            $where .="AND year = {$_REQUEST['year']} ";
			$this->view->year = $_REQUEST['year'];
        }
		else {
			$where .="AND year = YEAR(CURDATE()) ";
			$this->view->year = date('Y');
		}
		
		if ($_REQUEST['employee']){
			$where .="AND NIK = '{$_REQUEST['employee']}'";	
			$this->view->emply = $_REQUEST['employee'];
		}
		else {
			$emp = $this->user->employeeID;
			$where .="AND NIK = '$emp'";
			$this->view->emply = $emp;
		}
		
		//echo $where;exit;
		
		$sql = " SELECT * from claim
				 $where
				 ORDER BY date DESC";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		if ($this->db->count($sql) > 0) {
            $this->view->value = $this->db->fetchRow($sql);
        }
		
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
		
		$this->view->employeeclaim = $employeeclaim = $this->db->fetchAll("SELECT * FROM jml_users", true, "employeeID");
    }
	
	public function removeAction() {
        $this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
		
		$this->db->delete('claim', "claimID = '$id'");
		
		
        echo "ok";
    }
}

?>
