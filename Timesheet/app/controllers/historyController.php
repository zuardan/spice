<?php
//ob_start();
class historyController extends Crayd_Controller {

    public function preDispatch() {
        $this->view->allEmployee = $this->db->fetchAll("SELECT * FROM jml_users WHERE employeeID <> 1 order by name ASC",true, "employeeID");
    }

    public function listAction() {
        $this->view->setLayout('layoutBlank.php');

        if ($_REQUEST['order']) {
            $order = " {$_REQUEST['order']}";
        }

        $where = "WHERE timesheet_id !='' ";
        if ($_REQUEST['param']) {
            $date = date('Y-m-d', strtotime($_REQUEST['param']));
            $where .= " AND date ='$date'";
        }

        if ($_REQUEST['from'] && $_REQUEST['to']) {
            $from = date('Y-m-d', strtotime($_REQUEST['from']));
            $to = date('Y-m-d', strtotime($_REQUEST['to']));
            $where .= "AND detail.date BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."' ";
        }

        /*if ($_REQUEST['month'] && $_REQUEST['year']) {
            $where .=" AND  MONTH(date) = {$_REQUEST['month']} and YEAR(date) = {$_REQUEST['year']}";
        }
		else{
			$where .=" AND  MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
		}*/
		
		if ($_REQUEST['employee']) {
            $where .=" AND  time.id = '{$_REQUEST['employee']}'";
        }
		else{
			$where .=" AND  time.id = '{$this->user->id}'";
		}			
		//echo $this->user->employeeID;
        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;


        $limit = 31;

        $sql = " 
        SELECT time.employeeID , approved.* 
        FROM timesheet `time` 
        LEFT JOIN timesheet_approved approved 
        ON time.timesheetID = approved.timesheet_id 
		LEFT JOIN timesheet_detail detail
		ON time.timesheetID = detail.timesheetID
        $where
		ORDER BY detail.date , approved.status";

        $total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;



        $sql = "
        SELECT time.employeeID , approved.* 
        FROM timesheet `time` 
        LEFT JOIN timesheet_approved approved 
        ON time.timesheetID = approved.timesheet_id 
		LEFT JOIN timesheet_detail detail
		ON time.timesheetID = detail.timesheetID
        $where 
        ORDER BY detail.date DESC, approved.status 
		LIMIT $from, $limit";

        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
        $this->view->pages = $pages;
		$this->view->from = $from;

        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");

        foreach ((array)$sheets as $value) {
            $sql = "SELECT name FROM employee WHERE employeeID={$value['approve_1']}";
            if ($this->db->count($sql) > 0) {
                $approverID[$value['approve_1']] = $this->db->fetchRow($sql);
            }

            $sql = "SELECT date FROM timesheet_detail WHERE timesheetID={$value['timesheet_id']}";
            if ($this->db->count($sql) > 0) {
                $period[$value['timesheet_id']] = $this->db->fetchRow($sql);
            }
        }
        $this->view->approverID = $approverID;
        $this->view->period = $period;

        //limiter
        if ($page > $pages) {
            $this->view->page = $page = $pages;
        } elseif ($page < 1) {
            $this->view->page = $page = 1;
        }
    }
	
	public function excelAction() {
        $this->view->setLayout('layouttimesheetExcel.php');

        $this->view->filename = 'History_Timesheet' . '.xls';
		
        $where = "WHERE timesheet_id !='' AND detail.status = 'approved'";
        
		$sql = "SELECT * FROM jml_users";
        $this->view->employees = $employees = $this->db->fetchAll($sql, true, "employeeID");
		
		if ($_REQUEST['employee']) {
			
            $where .=" AND  time.id = '{$_REQUEST['employee']}'";
			$emp = $_REQUEST['employee'];
        }
		else{
			$where .=" AND  time.id = '{$this->user->id}'";
			$emp = $this->user->id;
		}
		//print_r($_REQUEST);
		if ($_REQUEST['from'] && $_REQUEST['to']) {
            //$where .=" AND  MONTH(date) = {$_REQUEST['month']} and YEAR(date) = {$_REQUEST['year']}";
			$this->view->from = $_REQUEST['from'];
			$this->view->to = $_REQUEST['to'];
			$where .= "AND detail.date BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."' ";
			
        }
		else{
			$where .=" AND  MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
			$this->view->month = date('M');
			$this->view->year = date('Y');
		}
		
        $sql = " 
        SELECT time.employeeID , approved.*  , detail.*
        FROM timesheet `time` 
        LEFT JOIN timesheet_approved approved 
        ON time.timesheetID = approved.timesheet_id 
        LEFT JOIN  timesheet_detail `detail` 
        ON detail.timesheetID = approved.timesheet_id
        $where and approved.status='approved'
		ORDER BY detail.date";
		//echo $sql;
		
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		//print_r($sheets);

        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
		$sql = "SELECT * FROM location";
        $this->view->locationResult = $locationResult = $this->db->fetchAll($sql, true, "locationID");
		
		$sql = "SELECT * FROM shift";
        $this->view->shiftResult = $shiftResult = $this->db->fetchAll($sql, true, "shiftID");
		
		$sql = "SELECT * FROM transport";
        $this->view->transportResult = $transportResult = $this->db->fetchAll($sql, true, "transportID");

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
		//print_r($period);
        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		$this->view->valueLocation = $valueLocation = $this->db->fetchAll("SELECT * FROM location", true, "locationID");
        $this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
		//print_r($this->view);
		foreach ($this->view->sheets as $value) {
            $subtotal[$value['project']]['subtotal'][] = ($this->view->projectResult[$value['project']]['value'] * $this->view->valueLocation[$value['location']]['value'] * $this->view->valueTransport[$value['transport']]['value']) / 2;
        }

		$sql = " SELECT * FROM jml_users WHERE id = '$emp'";
        $this->view->emp = $emp = $this->db->fetchAll($sql);
		
		$sql = "SELECT DISTINCT MONTH(DATE) months,YEAR(DATE) years
		FROM timesheet `time` 
        LEFT JOIN timesheet_approved approved 
        ON time.timesheetID = approved.timesheet_id 
        LEFT JOIN  timesheet_detail `detail` 
        ON detail.timesheetID = approved.timesheet_id
        $where
		ORDER BY detail.date";
		$this->view->dates = $dates = $this->db->fetchAll($sql);
		
		$this->view->divisionResult = $departmentResult = $this->db->fetchAll("SELECT * from division", true, "divisionID"); 
		$this->view->departmentResult = $departmentResult = $this->db->fetchAll("SELECT * from department", true, "departmentID"); 
		$this->view->positionResult = $positionResult = $this->db->fetchAll("SELECT * from position", true, "positionID"); 
		
        $this->view->subtotal = $subtotal;
        
    }
	
	public function detailAction() {
		if (isset($_GET['iframe'])) {
            $this->view->setLayout('layoutIframe.php');
            $this->view->isIframe = true;
        } else {
            $this->view->setLayout('layoutBlank.php');
        }
		$id = $_REQUEST['id'];
		//echo $id;exit;
        $sql = "SELECT time.employeeID , detail.* 
				FROM timesheet `time` 
				LEFT JOIN timesheet_detail detail 
				ON time.timesheetID = detail.timesheetID 
				WHERE time.timesheetID = '$id'";
		//echo $sql;exit;
        if ($this->db->count($sql) > 0) {
            $this->view->value = $this->db->fetchRow($sql);
        }
		
		$sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
		$sql = "SELECT * FROM location";
        $this->view->locationResult = $locationResult = $this->db->fetchAll($sql, true, "locationID");
		
		$sql = "SELECT * FROM shift";
        $this->view->shiftResult = $shiftResult = $this->db->fetchAll($sql, true, "shiftID");
		
		$sql = "SELECT * FROM transport";
        $this->view->transportResult = $transportResult = $this->db->fetchAll($sql, true, "transportID");
	}
}
?>