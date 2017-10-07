<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class reportController extends Crayd_Controller {

	public function preDispatch() {
		//echo $this->user->type;
		IF($this->user->types == 1 OR $this->user->types == 2){
			$this->_redirect('timesheet');
		}
	}
    public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		
		$where = "WHERE period = ";
        $wherei = "AND year = ";
        if ($_REQUEST['month'] && $_REQUEST['year']) {
            $where .="{$_REQUEST['month']}";
            $wherei .="{$_REQUEST['year']}";
            $date .="{$_REQUEST['month']}";
        }
		else{
			$where .="MONTH(CURDATE())";
			$wherei .="YEAR(CURDATE())";
			$date .="MONTH(CURDATE())";
		}
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 10;
		
        $sql = " 
        SELECT * FROM CLAIM
		$where
		$wherei
		ORDER BY projectID ASC";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
        SELECT * FROM CLAIM
		$where
		$wherei
		ORDER BY projectID ASC
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
		
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
		$this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
        $this->view->valueLocation = $valueLocation = $this->db->fetchAll("SELECT * FROM location", true, "locationID");
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
		$this->view->employee = $employee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
		
		$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		foreach ($sheets as $value) {
            $sql = "SELECT name FROM jml_users WHERE employeeID={$value['approve_id']}";
            if ($this->db->count($sql) > 0) {
                $approverID[$value['approve_id']] = $this->db->fetchRow($sql);
            }

            $sql = "SELECT date FROM timesheet_detail WHERE timesheetID={$value['timesheet_id']}";
            if ($this->db->count($sql) > 0) {
                $period[$value['timesheetID']] = $this->db->fetchRow($sql);
            }
			
		}
		
        $this->view->approverID = $approverID;
        $this->view->period = $period;
        $this->view->test = $test;
        $this->view->dates = $dates;
        $this->view->proj = $proj;
        
        foreach ($this->view->sheets as $value) {
            $subtotal[$value['projectID']]['subtotal'][] = ($this->view->projectResult[$value['projectID']]['value'] * $value['days']);			
		}
		
		$this->view->subtotal = $subtotal;
    }
	
	public function excelAction() {
        $this->view->setLayout('layoutExcel.php');
		
		$this->view->filename = 'Report_Rekap_Per_Project' . '.xls';
		
		$where = "WHERE period = ";
        $wherei = "AND year = ";
        if ($_REQUEST['month'] && $_REQUEST['year']) {
            $where .="{$_REQUEST['month']}";
            $wherei .="{$_REQUEST['year']}";
            $date .="{$_REQUEST['month']}";
        }
		else{
			$where .="MONTH(CURDATE())";
			$wherei .="YEAR(CURDATE())";
			$date .="MONTH(CURDATE())";
		}
		
        $sql = " 
        SELECT * FROM CLAIM
		$where
		$wherei
		ORDER BY projectID ASC";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);

        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");

        foreach ($sheets as $value) {
            $sql = "SELECT name FROM jml_users WHERE employeeID={$value['approve_id']}";
            if ($this->db->count($sql) > 0) {
                $approverID[$value['approve_id']] = $this->db->fetchRow($sql);
            }

            $sql = "SELECT date FROM timesheet_detail WHERE timesheetID={$value['timesheet_id']}";
            if ($this->db->count($sql) > 0) {
                $period[$value['timesheet_id']] = $this->db->fetchRow($sql);
            }
        }
        $this->view->approverID = $approverID;
        $this->view->period = $period;
        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
        $this->view->valueLocation = $valueLocation = $this->db->fetchAll("SELECT * FROM location", true, "locationID");
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
		$this->view->employee = $employee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
        foreach ($this->view->sheets as $value) {
            $subtotal[$value['projectID']]['subtotal'][] = ($this->view->projectResult[$value['projectID']]['value'] * $value['days']) ;
        }

        $this->view->subtotal = $subtotal;
    }

}

?>
