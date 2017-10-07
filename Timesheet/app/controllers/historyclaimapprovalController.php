<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class historyclaimapprovalController extends Crayd_Controller {

	public function preDispatch() {
		$this->view->allEmployee = $this->db->fetchAll("SELECT * FROM jml_users WHERE employeeID <> 1 order by name");
	}
	
    public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		$employeeID = $this->user->employeeID;
		//$where = "WHERE approved.status = 'approved' AND  MONTH(date) = ";
		//$where = "WHERE MONTH(date) = ";
        
       if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .=" AND MONTH(a.from_date) = {$_REQUEST['month']} ";
        }
		else {
			$where .=" AND MONTH(a.from_date) = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .=" AND YEAR(a.from_date) = {$_REQUEST['year']} ";
        }
		else {
			$where .=" AND YEAR(a.from_date) = YEAR(CURDATE()) ";
		}
		
		if ($_REQUEST['employee']=='all'){
			$where .="AND a.NIK<>1";
		}else{
			$where .="AND a.NIK = '{$_REQUEST['employee']}'";
		}
		if ($_REQUEST['order1']) {
            $order = " ORDER BY a.projectID {$_REQUEST['order1']}";
			$this->view->order1 = $_REQUEST['order1'];
        } else {
			$order = " ORDER BY a.projectID desc";}
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 10;
		
        $sql = " 
        SELECT a.*,b.name, c.* from claim a left join jml_users b on a.NIK=b.employeeID
		left join claim_approved c on a.claimID=c.claimID
		where (a.status='Approved' OR a.status='Rejected')
		$where
		$order";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
        SELECT a.*,b.name, c.* from claim a left join jml_users b on a.NIK=b.employeeID
		left join claim_approved c on a.claimID=c.claimID
		where (a.status='Approved' OR a.status='Rejected')
		$where 
		$order
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
		//print_r($sql);
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");		
		$sql = "SELECT * FROM project ORDER BY ProjectID DESC";
        $this->view->projectsResult = $projectsResult = $this->db->fetchAll($sql, true, "ProjectID");
		$sql = "SELECT * FROM project WHERE shift = '2'";
        $this->view->projectsResult2 = $projectsResult = $this->db->fetchAll($sql, true, "Project");			
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
        $this->view->valueShift = $valueShift = $this->db->fetchAll("SELECT * FROM shift", true, "shiftID");
		$sql="SELECT * FROM approval_project where Approval_1 = '$employeeID'";
		$this->view->pmoResult = $pmoResult = $this->db->fetchAll($sql, true, "employeeID");
		$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		foreach ((array)$sheets as $value) {
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
			
			/*$sql = "SELECT time.employeeID, detail.project,DATE, COUNT(DATE) days
					FROM timesheet_detail detail,timesheet TIME,timesheet_approved app
					AND time.timesheetID = detail.timesheetID
					AND app.timesheet_id = detail.timesheetID
					AND app.status = 'approved'
					AND time.employeeID = '{$value['employeeID']}'
					AND MONTH(DATE) = 3";
			if ($this->db->count($sql) > 0) {
				$test[$value['employeeID']] = $this->db->fetchRow($sql);
			}*/
		}
		
        $this->view->approverID = $approverID;
        $this->view->period = $period;
        $this->view->test = $test;
        
        foreach ((array)$this->view->sheets as $value) {
			IF($this->view->valueShift[$value['shift']]['value'] > 1){
				$proj = $value['project'];
				$shift = $value['shift'];
				$sql = "SELECT * FROM project WHERE ProjectID = '$proj';";
				$val = $this->db->fetchRow($sql);
				$project = $val['Project'];
				$sql = "SELECT value FROM project WHERE Project = '$project' AND shift = '$shift'";
				$val = $this->db->fetchRow($sql);
				
					$harga = $val['value'];
				
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
	
	public function submitAction() {
        $this->view->setLayout('layoutBlank.php');

        unset($_POST['page']);
		
		$userID = $this->user->employeeID;
        foreach ($_POST['data'] as $key => $value) {
            $claimID = $key;
            $update['status'] = "Approved";
            $this->db->update('claim', $update, "claimID ='$claimID'");
			
			$insert['claimID'] = $claimID;
			$insert['approve_id'] = $userID; 
			$insert['approved_date'] = date('Y-m-d'); 
			$insert['status'] = 'Approved';
			$insert['description'] = $_POST['desciption'];
			$this->db->insert('claim_approved',$insert);
        }

      //  echo 'ok';
		
       //$this->_redirect('timesheet/claimapproval/list');
    }
	
	public function rejectAction() {
        $this->view->setLayout('layoutBlank.php');

        unset($_POST['page']);
		
		$userID = $this->user->employeeID;
        foreach ($_POST['data'] as $key => $value) {
            $claimID = $key;
            $update['status'] = "Rejected";
            $this->db->update('claim', $update, "claimID ='$claimID'");
			
			$insert['claimID'] = $claimID;
			$insert['approve_id'] = $userID; 
			$insert['approved_date'] = date('Y-m-d'); 
			$insert['status'] = 'Rejected';
			$insert['description'] = $_POST['desciption'];
			$this->db->insert('claim_approved',$insert);
        }

      //  echo 'ok';
		
       //$this->_redirect('timesheet');
    }
}

?>
