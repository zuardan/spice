<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class attendancereportController extends Crayd_Controller {

	public function preDispatch() {
		//echo $this->user->type;
		IF($this->user->types == 1 OR $this->user->types == 2){
			$this->_redirect('timesheet');
		}
		$this->view->allProject = $this->db->fetchAll("SELECT * FROM project where ProjectID > 0");
		$this->view->allDivision = $this->db->fetchAll("SELECT * FROM division where divisionID > 0");
	}

    public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		
        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="AND MONTH(c.date) = {$_REQUEST['month']} ";
        }
		else {
			$where .="AND MONTH(c.date) = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .="AND YEAR(c.date) = {$_REQUEST['year']} ";
        }
		else {
			$where .="AND YEAR(c.date) = YEAR(CURDATE()) ";
		}
		if ($_REQUEST['division']) {
            $where .="AND f.divisionID = {$_REQUEST['division']} ";
        }
        if ($_REQUEST['project']) {
            $where .="AND e.ProjectID = {$_REQUEST['project']} ";
        }
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 400;
		
        $sql = " 
        SELECT b.name, b.SF_ID, c.date, e.Project,e.SFProjectID,f.division, hour(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalhour, minute(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalminute from timesheet a join jml_users b on a.id = b.id join timesheet_detail c on a.timesheetID = c.timesheetID join timesheet_approved d on c.timesheetID = d.timesheet_id join project e on c.project = e.ProjectID join division f on f.divisionID = b.division_id where c.status = 'approved' $where
 
 			Group by e.Project, b.name";	
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
			
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
       SELECT b.name, b.SF_ID, c.date, e.Project,e.SFProjectID,f.division, hour(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalhour, minute(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalminute from timesheet a join jml_users b on a.id = b.id join timesheet_detail c on a.timesheetID = c.timesheetID join timesheet_approved d on c.timesheetID = d.timesheet_id join project e on c.project = e.ProjectID join division f on f.divisionID = b.division_id where c.status = 'approved' $where
 
 			Group by e.Project, b.name
		order by  e.Project asc
		LIMIT $from, $limit";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
    }
	
	public function excelAction() {
        $this->view->setLayout('layoutExcelAttendanceReport.php');
		
        if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
            $where .="AND MONTH(c.date) = {$_REQUEST['month']} ";
        }
		else {
			$where .="AND MONTH(c.date) = MONTH(CURDATE()) ";
		}
		
		if ($_REQUEST['year']) {
            $where .="AND YEAR(c.date) = {$_REQUEST['year']} ";
        }
		else {
			$where .="AND YEAR(c.date) = YEAR(CURDATE()) ";
		}
		if ($_REQUEST['division']) {
            $where .="AND f.divisionID = {$_REQUEST['division']} ";
        }
        if ($_REQUEST['project']) {
            $where .="AND e.ProjectID = {$_REQUEST['project']} ";
        }
		
		$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 400;
		
      $sql = " 
        SELECT b.name, b.SF_ID, c.date, e.Project,e.SFProjectID,f.division, hour(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalhour, minute(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalminute from timesheet a join jml_users b on a.id = b.id join timesheet_detail c on a.timesheetID = c.timesheetID join timesheet_approved d on c.timesheetID = d.timesheet_id join project e on c.project = e.ProjectID join division f on f.divisionID = b.division_id where c.status = 'approved' $where
 
 			Group by e.Project, b.name";	
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
			
		$total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;
		
		$sql = " 
       SELECT b.name, b.SF_ID, c.date, e.Project,e.SFProjectID,f.division, hour(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalhour, minute(sec_to_time(sum((time_to_sec(timediff(c.end_time, c.start_time)))))) as totalminute from timesheet a join jml_users b on a.id = b.id join timesheet_detail c on a.timesheetID = c.timesheetID join timesheet_approved d on c.timesheetID = d.timesheet_id join project e on c.project = e.ProjectID join division f on f.divisionID = b.division_id where c.status = 'approved' $where
 
 			Group by e.Project, b.name
		order by  e.Project asc";

        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		$this->view->pages = $pages;
		$this->view->from = $from;
    }
}

?>
