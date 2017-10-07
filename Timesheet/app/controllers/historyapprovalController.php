<?php

class historyapprovalController extends Crayd_Controller {

    public function preDispatch() {
        $this->view->Employee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
        $emp = $this->user->employeeID;
		$types = $this->user->types;
		/*if($types != '3'){
			$sql = "SELECT DISTINCT(T1.employeeID)
					FROM TIMESHEET T1, TIMESHEET_DETAIL T2
					WHERE T1.timesheetID = T2.timesheetID
					AND T1.employeeID IN (SELECT EmployeeID 
						FROM approval_default
						WHERE Approval_1 = '$emp'
						OR Approval_2 = '$emp'
						OR Approval_3 = '$emp'
						OR HR_1 = '$emp'
						OR HR_2 = '$emp')	
					AND T2.status = 'Waiting Approval'
					AND T1.employeeID <> '1';	";
			$this->view->EmpDef = $this->db->fetchAll($sql);
			
			$sql = "SELECT DISTINCT(T1.employeeID)
					FROM JML_USERS T1, TIMESHEET T2, TIMESHEET_DETAIL T3
					WHERE T1.employeeID = T2.employeeID
					AND T2.timesheetID = T3.timesheetID
					AND T3.project IN (SELECT ProjectID 
						FROM approval_project
						WHERE Approval_1 = '$emp'
						OR Approval_2 = '$emp'
						OR Approval_3 = '$emp')
					AND T3.status = 'Waiting Approval'
					AND T1.employeeID <> '1'";
			$this->view->EmpPro = $this->db->fetchAll($sql);
						
		}else {												
			$this->view->allEmployee = $this->db->fetchAll("SELECT DISTINCT(T1.name), T1.* FROM jml_users T1,timesheet T2 , timesheet_detail T3
			WHERE T2.employeeID = T1.employeeID
			AND T2.timesheetID = T3.timesheetID
			AND T3.status = 'Waiting Approval'
			;");
		}*/
    }
	
	public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		
        
		$user = $this->user->employeeID;
		
		$sql = "SELECT * FROM jml_users order by name asc";
		$this->view->allEmployee = $allEmployee = $this->db->fetchAll($sql, true, "id");
		
		$sql = "SELECT * FROM location";
        $this->view->locationResult = $locationResult = $this->db->fetchAll($sql, true, "locationID");
		
		$sql = "SELECT * FROM shift";
        $this->view->shiftResult = $shiftResult = $this->db->fetchAll($sql, true, "shiftID");
		
		$sql = "SELECT * FROM transport";
        $this->view->transportResult = $transportResult = $this->db->fetchAll($sql, true, "transportID");
		
		$sql = "SELECT * FROM timesheet";
		$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
		
		$sql="SELECT distinct T2.employeeID, b.name FROM timesheet_detail T1
		left join timesheet T2 on T1.timesheetID = T2.timesheetID
		left join approval_project a on T1.project = a.ProjectID
		inner join jml_users b on T2.employeeID = b.employeeID
		WHERE (T1.status = 'Waiting Approval' OR T1.status = 'Approved')
		AND b.employeeID=T2.employeeID AND a.Approval_1='$user' order by b.name ASC";
		$this->view->listemp = $this->db->fetchAll($sql);
		//print_r($sql);
		
		if(($_REQUEST['from']) && ($_REQUEST['to'])){
			
			if ($_REQUEST['employee']=='all'){
			$and .="AND d.employeeID <> 1 ";
			}else{
			$and .="AND d.employeeID = '{$_REQUEST['employee']}'";
			}
			$from = $_REQUEST['from'];
			$to=$_REQUEST['to'];
            $where = "AND (a.date BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."') ";
			
			$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
			$limit = 10;
			
			if($types = $this->user->types==2){			
			$sql="SELECT a.*, b.*, c.*, d.*, e.name from timesheet_detail a join project b on a.project=b.ProjectID 
			left join approval_project c on a.project=c.ProjectID 
			left join timesheet d on a.timesheetID=d.timesheetID
			left join jml_users e on d.employeeID=e.employeeID
			where c.Approval_1='$user' and a.queue='2' and (a.status='Approved' or a.status='Waiting Approval')
			$and
			$where
			ORDER BY a.date desc";
			
			$total = $this->db->count($sql);
			$pages = ceil($total / $limit);
			$from = ($page - 1) * $limit;
			
			$sql="SELECT a.*, b.*, c.*, d.*, e.name from timesheet_detail a join project b on a.project=b.ProjectID 
			left join approval_project c on a.project=c.ProjectID 
			left join timesheet d on a.timesheetID=d.timesheetID
			left join jml_users e on d.employeeID=e.employeeID
			where c.Approval_1='$user' and a.queue='2' and (a.status='Approved' or a.status='Waiting Approval')
			$and
			$where
			ORDER BY a.date desc
			LIMIT $from, $limit";
			//print_r($sql);
			$this->view->history = $this->db->fetchAll($sql);
			$timesheet_history = $this->view->history;
			$this->view->pages = $pages;
			$this->view->from = $from;
			}
			
			if($types = $this->user->types==3){
			$empid=$_REQUEST['employee'];
			
			$sql="SELECT a.*, b.*, c.*, d.*, e.name from timesheet_detail a join project b on a.project=b.ProjectID 
			left join approval_project c on a.project=c.ProjectID 
			left join timesheet d on a.timesheetID=d.timesheetID
			left join jml_users e on d.employeeID=e.employeeID
			where d.employeeID='$empid' and a.queue='2' and (a.status='Approved' or a.status='Waiting Approval')
			$where
			ORDER BY a.date desc";
			//print_r($sql);
			$total = $this->db->count($sql);
			$pages = ceil($total / $limit);
			$from = ($page - 1) * $limit;
			
			$sql="SELECT a.*, b.*, c.*, d.*, e.name from timesheet_detail a join project b on a.project=b.ProjectID 
			left join approval_project c on a.project=c.ProjectID 
			left join timesheet d on a.timesheetID=d.timesheetID
			left join jml_users e on d.employeeID=e.employeeID
			where d.employeeID='$empid' and a.queue='2' and (a.status='Approved' or a.status='Waiting Approval')
			$where
			ORDER BY a.date desc
			LIMIT $from, $limit";
			
			$this->view->history = $this->db->fetchAll($sql);
			$timesheet_history = $this->view->history;
			$this->view->pages = $pages;
			$this->view->from = $from;
			}
		}
				
		}
		
	public function cancelAction() {
        $this->view->setLayout('layoutBlank.php');
		
		$userID = $this->user->employeeID;
      if($_REQUEST['timesheet_id']){
	  
	  $timesheetID=$_REQUEST['timesheet_id'];
	  
	  $sql="select * from timesheet_detail where timesheetID=$timesheetID";
	  $this->view->cancel = $cancel = $this->db->fetchAll($sql);
	  //$this->view->canceled_timesheet = $this->db->fetchAll($sql);
	  //$canceled_timesheet = $this->view->canceled_timesheet;
		/*echo $date;
		echo $start_time;
		echo $end_time;
		echo $project;
		echo $location;
		echo $shift;
		echo $detail;
		echo $transport;*/
		foreach($cancel as $canceled){
	  
	  $insert['timesheet_id']=$timesheetID;
	  $insert['date']=$canceled['date'];
	  $insert['start_time']=$canceled['start_time'];
	  $insert['end_time']=$canceled['end_time'];
	  $insert['project']=$canceled['project'];
	  $insert['location']=$canceled['location'];
	  $insert['shift']=$canceled['shift'];
	  $insert['detail']=$canceled['detail'];
	  $insert['transport']=$canceled['transport'];
	  $insert['submit_date']=$canceled['submit_date'];
	  $insert['canceled_by']=$userID;
	  $insert['canceled_date']=date('Y-m-d');}
		$insert_canceled=$this->db->insert('timesheet_canceled', $insert);
	  
	  
	  if($insert_canceled){
	  
	  $update['status']='Draft';
	  $update['queue']='1';
	  $update_timesheet=$this->db->update('timesheet_detail', $update, "timesheetID = '$timesheetID'");
	  //echo $update_timesheet;
	  
	 $delete_approved=$this->db->delete('timesheet_approved',"timesheet_id = '$timesheetID'");
	 echo $delete_approved;
	 $delete_queue=$this->db->delete('timesheet_queue',"timesheet_id = '$timesheetID'");
	  //echo $delete_queue;
        //echo "<pre>"; print_r($value); 
		//print_r($_POST['data']);
		}}
	$this->_redirect('historyapproval');
    }
}

?>
