<?php

class cbController extends Crayd_Controller {
	public function preDispatch() {
        $this->view->allEmployee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
    }
	
	public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		$order = 'DESC';
        if ($_REQUEST['order']) {
            $order = "{$_REQUEST['order']}";
        }
		
		if ($_REQUEST['month'] && $_REQUEST['employee']) {
            $wherei ="{$_REQUEST['month']}";
			$wherea ="{$_REQUEST['employee']}";
        } else {
			$wherei = "MONTH(CURDATE())";
			$wherea = "$this->userdata->employeeID";
		}
		
		
		
		
        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 10;
        
		$sql = "
        SELECT T1.*,T2.* FROM timesheet_detail T1, timesheet T2
		WHERE T1.STATUS = 'approved'
		AND T2.timesheetID = T1.timesheetID
		AND MONTH(T1.date) = $wherei
		AND T2.employeeID = '$wherea'";

        $total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;

        $sql = "
        SELECT T1.*,T2.employeeID FROM timesheet_detail T1, timesheet T2
		WHERE T1.STATUS = 'approved'
		AND T2.timesheetID = T1.timesheetID
		AND MONTH(T1.date) = $wherei
		AND T2.employeeID = '$wherea'";
        $this->view->sheets = $this->db->fetchAll($sql);
        $this->view->pages = $pages;
		
		
		
        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
		$sql = "SELECT * FROM location";
        $this->view->locationResult = $locationResult = $this->db->fetchAll($sql, true, "locationID");
		
		$sql = "SELECT * FROM shift";
        $this->view->shiftResult = $shiftResult = $this->db->fetchAll($sql, true, "shiftID");
		
		$sql = "SELECT * FROM transport";
        $this->view->transportResult = $transportResult = $this->db->fetchAll($sql, true, "transportID");
		
    }
	
	public function chargeableAction() {
        $this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
        $data = $_REQUEST['data'];
        unset($data['page']);        
        foreach ($data as $key => $value) {
            $timesheetID = $key;
            $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$timesheetID'";
            if ($this->db->count($sql) > 0) {
                $result = $this->db->fetchRow($sql);
                $timesheetID = $result['timesheetID'];
                
				$update['productivity'] = "Chargeable";
				$this->db->update('timesheet_detail', $update, "timesheetID ='$timesheetID'");
			}
                         
        }
        echo "ok";	
    }
	
	public function billableAction() {
        $this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
        $data = $_REQUEST['data'];
        unset($data['page']);        
        foreach ($data as $key => $value) {
            $timesheetID = $key;
            $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$timesheetID'";
            if ($this->db->count($sql) > 0) {
                $result = $this->db->fetchRow($sql);
                $timesheetID = $result['timesheetID'];
                
				$update['productivity'] = "Billable";
				echo $timesheetID;exit;
				$this->db->update('timesheet_detail', $update, "timesheetID ='$timesheetID'");
			}
                         
        }
        //echo "ok";	
		echo $key;
    }
	
	public function non_chargeableAction() {
        $this->view->setLayout('layoutBlank.php');
		$id = $_REQUEST['id'];
        $data = $_REQUEST['data'];
        unset($data['page']);        
        foreach ($data as $key => $value) {
            $timesheetID = $key;
            $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$timesheetID'";
            if ($this->db->count($sql) > 0) {
                $result = $this->db->fetchRow($sql);
                $timesheetID = $result['timesheetID'];
                
				$update['productivity'] = "Non Chargeable";
				$this->db->update('timesheet_detail', $update, "timesheetID ='$timesheetID'");
			}
                         
        }
        echo "ok";		
    }
}

?>