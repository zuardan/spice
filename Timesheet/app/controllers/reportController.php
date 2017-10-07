<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class reportController extends Crayd_Controller {


	public function preDispatch() {
		
		IF($this->user->types == 1 OR $this->user->types == 2){
			$this->_redirect('timesheet');
		}
		
	}
    public function listAction() {
		
        $this->view->setLayout('layoutBlank.php');
		
        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="AND MONTH(a.from_date) = {$_REQUEST['month']} ";
        }
		else {
			$where .="AND MONTH(a.from_date) = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .="AND YEAR(a.from_date) = {$_REQUEST['year']} ";
        }
		else {
			$where .="AND YEAR(a.from_date) = YEAR(CURDATE()) ";
		}
		
		if ($_REQUEST['project']){
			$where .="AND a.projectID = '{$_REQUEST['project']}'";
		}
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 400;
		
		
        $sql = " 
        select a.*, b.*, c.name
        from claim a 
		join claim_approved b on a.claimID=b.claimID join jml_users c on a.nik = c.employeeID
        where a.status='Approved'
        group by a.nik, a.projectID 
		order by name asc";
		
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		
			
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
        select a.*, b.*, c.name, group_concat(week) as weeks, group_concat(days) as day_count, group_concat(shift) as shifts
        from claim a
        left join claim_approved b
        on a.claimID=b.claimID join jml_users c on a.NIK=c.employeeID
        where a.status='Approved'
		$where
		group by a.nik, a.projectID
		order by name asc
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
				//echo $sql;
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");		
		$sql = "SELECT * FROM project ORDER BY ProjectID DESC";
        $this->view->projectsResult = $projectsResult = $this->db->fetchAll($sql, true, "ProjectID");
		$sql = "SELECT * FROM project WHERE shift = '2'";
        $this->view->projectsResult2 = $projectsResult = $this->db->fetchAll($sql, true, "Project");			
		$this->view->valueLocation = $valueLocation = $this->db->fetchAll("SELECT * FROM location", true, "locationID");
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
        $sql = "SELECT * FROM jml_users";
		$this->view->employee = $employee = $this->db->fetchAll($sql,true,"employeeID");
		
		$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		foreach ((array)$sheets as $value) {
            $sql = "SELECT name FROM jml_users WHERE employeeID={$value['approve_id']} order by name asc";
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
        
        foreach ((array)$this->view->sheets as $value) {
			IF($value['shift'] == '0'){
				$subtotal[$value['projectID']]['subtotal'][] = $value['days'] * $this->view->projectResult[$value['projectID']]['value'];
			}else{
				$subtotal[$value['projectID']]['subtotal'][] = $value['days'] * $this->view->projectResult[$value['projectID']]['value'];
			}		
		}
		
		$this->view->subtotal = $subtotal;
		
    }
	
	public function excelAction() {
        $this->view->setLayout('layoutExcelReport.php');
		
		$this->view->filename = 'report_excel' . '.xls';
		
		
        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="AND MONTH(a.from_date) = {$_REQUEST['month']} ";
        }
		else {
			$where .="AND MONTH(a.from_date) = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .="AND YEAR(a.from_date) = {$_REQUEST['year']} ";
        }
		else {
			$where .="AND YEAR(a.from_date) = YEAR(CURDATE()) ";
		}
		
		if ($_REQUEST['project']){
			$where .="AND a.projectID = '{$_REQUEST['project']}'";
		}
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 400;
		
        $sql = " 
        select a.*, b.*, c.name
        from claim a join claim_approved b on a.claimID=b.claimID join jml_users c on a.nik = c.employeeID
        where a.status='Approved'
        group by a.nik, a.projectID 
		order by name asc";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
			
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
        select a.*, b.*, c.name, group_concat(week) as weeks, group_concat(days) as day_count, group_concat(shift) as shifts
        from claim a
        left join claim_approved b
        on a.claimID=b.claimID join jml_users c on a.NIK=c.employeeID
        where a.status='Approved'
		$where
		group by a.nik, a.projectID
		order by name asc
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
				//echo $sql;
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");		
		$sql = "SELECT * FROM project ORDER BY ProjectID DESC";
        $this->view->projectsResult = $projectsResult = $this->db->fetchAll($sql, true, "ProjectID");
		$sql = "SELECT * FROM project WHERE shift = '2'";
        $this->view->projectsResult2 = $projectsResult = $this->db->fetchAll($sql, true, "Project");			
		$this->view->valueLocation = $valueLocation = $this->db->fetchAll("SELECT * FROM location", true, "locationID");
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
        $sql = "SELECT * FROM jml_users";
		$this->view->employee = $employee = $this->db->fetchAll($sql,true,"employeeID");
		
		$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		foreach ((array)$sheets as $value) {
            $sql = "SELECT name FROM jml_users WHERE employeeID={$value['approve_id']} order by name asc";
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
        
        foreach ((array)$this->view->sheets as $value) {
			IF($value['shift'] == '0'){
				$subtotal[$value['projectID']]['subtotal'][] = $value['days'] * $this->view->projectResult[$value['projectID']]['value'];
			}else{
				$days = $value['days'] - $value['shift'];				
				$h1 = $this->view->projectsResult[$value['projectID']]['value'];
				$h1 = $h1 + $this->view->projectsResult2[$this->view->projectsResult[$value['projectID']]['Project']]['value'];					
				$malam = $malam + $h1;
				$subtotal[$value['projectID']]['subtotal'][] = ($days * $this->view->projectResult[$value['projectID']]['value']) + $malam;
			}		
		}
		
		$this->view->subtotal = $subtotal;
    }
}

?>
