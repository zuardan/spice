<?php ob_start(); 

//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//s$app = JFactory::getApplication('site');

class timesheetController extends Crayd_Controller {



public function validateSession(){
		session_start();

		
		$this->view->Employee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
        $emp = $this->user->employeeID;

        print_r($emp); exit();
			/*
		if($emp==NULL){
			 die("<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<center><h3><font color='#FF0000' face='Verdana, Geneva, sans-serif'>Maaf Anda belum login<br/>silahkan <a href='http://localhost:8080/webportal/'>login disini</a></font></h3></center>
				");

		}
		*/
}

    public function addAction() {

        if (isset($_GET['iframe'])) {
            $this->view->setLayout('layoutIframe.php');
            $this->view->isIframe = true;
        } else {
            $this->view->setLayout('layoutBlank.php');
        }
		$this->view->projects = $this->db->fetchAll("SELECT * FROM project", true, "Project");
		$this->view->project = $this->db->fetchAll("SELECT DISTINCT Project FROM project order by Project asc");
		$this->view->location = $this->db->fetchAll("SELECT * FROM location");
		$this->view->shift = $this->db->fetchAll("SELECT * FROM shift");
		$this->view->transport = $this->db->fetchAll("SELECT * FROM transport");
		$this->view->activity = $this->db->fetchAll("SELECT * FROM activity");


		if ($this->getRequest()->isPost()) {

			$this->view->setView('ajax');
			$data = $_POST;

			$employeeID = $this->user->employeeID;
			$emp_username=$this->user->username;
			$id = $this->user->id;
			$projID=$data['project'];
			
			$sql="select * from project where ProjectID='$projID'";
		  	$this->view->projectcode = $projectcodes = $this->db->fetchAll($sql);
		  
			foreach($projectcodes as $projcodes){
		  		$projcode=$projcodes['Project'];
		  	}
			
			$projsubs=substr($projcode, 0,2);
			
			$insert['id'] = $id;
			$insert['employeeID'] = $employeeID;
			$data['date'] = date('Y-m-d', strtotime($data['date']));
			$data['status'] = "Draft";
			$starts=$data['start_time'];
			$ends=$data['end_time'];
			$shift=$data['shift'];

			$date = $data['date'];
			$sql = "SELECT 	timesheet.employeeID, timesheet_detail.*
								FROM 	timesheet_detail
								JOIN 	timesheet
								  ON 	timesheet_detail.timesheetID = timesheet.timesheetID
								WHERE	timesheet.employeeID = '$employeeID'
								AND	timesheet_detail.status IN ('Approved','Waiting Approval','Draft')
								AND	DATE = '$date'
								AND 	(
										timesheet_detail.start_time < '$ends'
									AND		
										timesheet_detail.end_time   > '$starts'
									)";
			
			if($this->db->count($sql) > 0){
				echo 'cancel';
				//echo $sql;
			}else{
				$data['queue'] = 1;
				$timesheetID = $this->db->insert('timesheet', $insert);
				$data['timesheetID'] = $timesheetID;
				$starts = $data['start_time'];
				$ends = $data['end_time'];

				if($ends<$starts )//AND $projcode!='MS' AND $shift!=2)
				{
					echo 'endstart';
					//echo $projsubs;
				}
				else 
				{
					$count=0;
					//$counts = 0;
					$sheets = $this->db->fetchAll("SELECT a.employeeID , b.* from jml_users a join leave_history b ON b.employee_id = a.id where b.status_id = 3 and a.employeeID = '$employeeID'");

					foreach ($sheets as $sheet) {
						$startTime = strtotime($sheet['from_date']);
						$endTime = strtotime($sheet['to_date']);

			  			for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
  							$thisDate = date( 'Y-m-d', $i ); 

  							if ($thisDate == $data['date']){
  								$count++;
  							}
			  			}

						if($count > 0){
							$counts++;
						};
					}

					if($counts == 0){
						$this->db->insert('timesheet_detail', $data);
						echo 'ok';
					};

					if($counts > 0){
						echo 'test';
					};			
				}
			}
		}
    }

    public function editAction() {
        if (isset($_GET['iframe'])) {
            $this->view->setLayout('layoutIframe.php');
            $this->view->isIframe = true;
        } else {
            $this->view->setLayout('layoutBlank.php');
        }


        $id = $_REQUEST['id'];
        $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$id'";

        if ($this->db->count($sql) > 0) {
            $this->view->value = $this->db->fetchRow($sql);
        }

        $this->view->projects = $this->db->fetchAll("SELECT * FROM project order by ProjectID");
		$this->view->location = $this->db->fetchAll("SELECT * FROM location");
		$this->view->shift = $this->db->fetchAll("SELECT * FROM shift");
		$this->view->transport = $this->db->fetchAll("SELECT * FROM transport");
		$this->view->activity = $this->db->fetchAll("SELECT * FROM activity");
		
		

        if ($this->getRequest()->isPost()) {
            $this->view->setView('ajax');
            $data = $_POST;
            $id = $_REQUEST['id'];

            $data['location'] = $data['location'] ? $data['location'] : '';
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            //$data['status'] = "Draft";
			
			$user_id = $this->user->id;
			$date = $data['date'];
			$sql = "SELECT * FROM leave_history WHERE $date BETWEEN from_date AND to_date AND employee_id = '$user_id'";
			if($this->db->count($sql) > 0){
				echo 'cancel';
			}else{
				$this->db->update('timesheet_detail', $data, "timesheetID='$id'");
				echo 'ok';
				//echo $sql;
			}
        }	
    }

    public function removeAction() {
        $this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
        $data = $_REQUEST['data'];
        unset($data['page']);
        foreach ($data as $key => $value) {
            $this->db->delete('timesheet', "timesheetID = '$key'");
            $this->db->delete('timesheet_detail', "timesheetID = '$key'");
        }
        echo 'ok';
    }

    public function listAction() {
        $this->view->setLayout('layoutBlank.php');
		session_start();

		
		 $this->view->Employee = $this->db->fetchAll("SELECT * FROM jml_users",true,"employeeID");
        $emp = $this->user->employeeID;
		$types = $this->user->types;
		
		/*include("koneksi.php");
		include("test/session.php");*/
		
		$order = 'DESC';
        if ($_REQUEST['order']) {
            $order = "{$_REQUEST['order']}";
        }

        if ($_REQUEST['param']) {
            $date = date('Y-m-d', strtotime($_REQUEST['param']));
            $where = "WHERE employeeID = '{$this->user->employeeID}' AND date ='$date' ";
        } else {
            $where = "WHERE employeeID = '{$this->user->employeeID}' ";
        }
		
		if ($_REQUEST['month'] && $_REQUEST['year']) {
            $wherei ="{$_REQUEST['month']}";
			$wherea ="{$_REQUEST['year']}";
        } else {
			$wherei = "MONTH(CURDATE())";
			$wherea = "YEAR(CURDATE())";
		}
		
		
		//$this->view->month = $
		
        $page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
        $limit = 10;
        
		$sql = "
        SELECT time.employeeID , detail.* 
        FROM timesheet `time` 
        LEFT JOIN timesheet_detail detail 
        ON time.timesheetID = detail.timesheetID 
        $where AND MONTH(date) = $wherei
		AND YEAR(date) = $wherea
		AND status in ('Draft','Waiting Approval')
		ORDER BY `date` $order";

        $total = $this->db->count($sql);
        $pages = ceil($total / $limit);
        $from = ($page - 1) * $limit;

        $sql = "
        SELECT time.employeeID , detail.* 
        FROM timesheet `time` 
        LEFT JOIN timesheet_detail detail 
        ON time.timesheetID = detail.timesheetID 
        $where AND MONTH(date) = $wherei
		AND YEAR(date) = $wherea
		AND status in ('Draft','Waiting Approval')
        ORDER BY `date` $order
        LIMIT $from, $limit";
        $this->view->sheets = $this->db->fetchAll($sql);
        $this->view->pages = $pages;
		$this->view->from = $from;
		
		//$this->view->months = $this->db->fetchRow("SELECT MONTH(date) FROM '$sql'");
		
        $sql = "SELECT * FROM project";
        $this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");
		
		$sql = "SELECT * FROM location";
        $this->view->locationResult = $locationResult = $this->db->fetchAll($sql, true, "locationID");
		
		$sql = "SELECT * FROM shift";
        $this->view->shiftResult = $shiftResult = $this->db->fetchAll($sql, true, "shiftID");
		
		$sql = "SELECT * FROM transport";
        $this->view->transportResult = $transportResult = $this->db->fetchAll($sql, true, "transportID");
		
    }

    public function submitAction() {
        $this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
        $data = $_REQUEST['data'];
        unset($data['page']);
        foreach ($data as $key => $value) {
            $timesheetID = $key;
            $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$timesheetID'";
			//echo $sql;
			//echo $key;
            if ($this->db->count($sql) > 0) {
                $result = $this->db->fetchRow($sql);
				$dates = $result['date'];
				$emp = $this->user->employeeID;
				$starts = $result['start_time'];
				$ends	= $result['end_time'];
				$emp = $this->user->employeeID;
				
				if($ends<$starts)
				{
					$flag = '1';
				}
				else
				{
					 $sql =	" 
							SELECT 	timesheet.employeeID, timesheet_detail.*
							FROM 	timesheet_detail
							JOIN 	timesheet
							  ON 	timesheet_detail.timesheetID = timesheet.timesheetID
							WHERE	timesheet.employeeID = '$emp'
							AND	timesheet_detail.status IN ('Approved','Waiting Approval')
							AND	DATE = '$dates'
							AND 	(
									timesheet_detail.start_time < '$ends'
								AND		
									timesheet_detail.end_time   > '$starts'
								)
							";
				//echo '</br>'.$sql = "SELECT * FROM timesheet_detail T1, timesheet T2 WHERE T2.employeeID = '$emp' AND T1.timesheetID = T2.timesheetID AND date = '$dates' AND status in ('Approved','Waiting Approval')";			
				
					if($this->db->count($sql) > 0){
						$time = $this->db->fetchRow($sql);
					/* 	echo 'Time start : '. $time['start_time'] . '</br>';
						echo 'Time end : '. $time['end_time'] . '</br>';
						echo 'result start : '. $result['start_time'] . '</br>';
						echo 'result end : '. $result['end_time'] . '</br>';	*/			
						if($time['start_time'] < $result['end_time'] || $time['end_time'] > $result['start_time'])					
							$flag = '1'; 
					}else{
						//echo '</br>' . $flag = '0';
						$flag = '0';
					}
				}

				$timesheetID = $result['timesheetID'];
				$projectID = $result['project'];
				$employeeID = $this->user->employeeID;
				//if($flag == '0'){
				//refresh status on
				$this->db->delete('timesheet_approved',"timesheet_id = '$timesheetID'");				
				
				if ($projectID != '1') {
					$sql = "SELECT * FROM approval_project WHERE ProjectID = '$projectID'";
					//echo $sql;
					if ($this->db->count($sql) > 0) 
						$approveResult = $this->db->fetchRow($sql);
						$flag = 1;
						//unset variable first
						unset($approveResult['AppProID']);
						unset($approveResult['ProjectID']);
						unset($approveResult['EmployeeID']);
						foreach ($approveResult as $key => $value) {
							$insert[$key] = $value;
							//echo $value;
							//print_r($value);
						}
						$insert['employeeID'] = $this->user->employeeID;
						$insert['status'] = "Waiting Approval";
						$insert['timesheetID'] = $timesheetID;
						$insert['date'] = date('Y-m-d');
						//$this->db->insert('approve', $insert);
						
						$update['status'] = "Waiting Approval";
						$update['queue'] = 1;
						$update['submit_date'] = date('Y-m-d', time());
						$this->db->update('timesheet_detail', $update, "timesheetID ='$timesheetID'");
					
				} else {
					$sql = "SELECT * FROM approval_default WHERE EmployeeID = '$employeeID'";
					//echo $sql;
					if ($this->db->count($sql) > 0) 
						$approveResult = $this->db->fetchRow($sql);
						$flag = 1;
						//unset variable first
						unset($approveResult['AppProID']);
						unset($approveResult['ProjectID']);
						unset($approveResult['EmployeeID']);
						foreach ($approveResult as $key => $value) {
							$insert[$key] = $value;
							//echo $value;
							//print_r($value);
						}
						$insert['employeeID'] = $this->user->employeeID;
						$insert['status'] = "Waiting Approval";
						$insert['timesheetID'] = $timesheetID;
						$insert['date'] = date('Y-m-d');
						//$this->db->insert('approve', $insert);
						
						$update['status'] = "Waiting Approval";
						$update['queue'] = 2;
						$update['submit_date'] = date('Y-m-d', time());
						$this->db->update('timesheet_detail', $update, "timesheetID ='$timesheetID'");
					
				}  	
				//}$flag = '0';
				//echo $flag;
				//echo 'ok';
			}
        }
		//exit;
      $this->_redirect('timesheet');
		
    }

    public function detailAction() {

        if (isset($_GET['iframe'])) {
            $this->view->setLayout('layoutIframe.php');
            $this->view->isIframe = true;
        } else {
            $this->view->setLayout('layoutBlank.php');
        }
        $id = $_REQUEST['ClaimID'];
        $sql = "SELECT * FROM timesheet_detail WHERE timesheetID = '$id'";
        if ($this->db->count($sql) > 0) {
            $this->view->detail = $this->db->fetchRow($sql);
        }
    }
	
	public function importAction() {
        if ($this->getRequest()->isPost()) {
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_name = $_FILES['myfile']['name'];
            $file_type = $_FILES['myfile']['type'];

            include 'Excel/reader.php';
            $data = new Spreadsheet_Excel_Reader();

            $data->setOutputEncoding('UTF8');
            $data->read($file_tmp);

            //columns:
            //cells
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                $insert['employeeID'] = $this->user->employeeID;
                $timesheetID = $this->db->insert('timesheet', $insert);
                $sql = "INSERT INTO `timesheet_detail` VALUES ";
                $sql .= "('" . $timesheetID . "',";
                //$sql .= "'" . date("Y-m-d") . "',";
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    $data->sheets[0]['cells'][$i][1] = $this->convertExcelToNormalDate($data->sheets[0]['cells'][$i][1]);
                    //$data->sheets[0]['cells'][$i][2] = $this->convertExcelToNormalTime($data->sheets[0]['cells'][$i][2]);
                    $data->sheets[0]['cells'][$i][2] = $data->sheets[0]['cells'][$i][2];
                    //$data->sheets[0]['cells'][$i][3] = $this->convertExcelToNormalTime($data->sheets[0]['cells'][$i][3]);
                    $data->sheets[0]['cells'][$i][3] = $data->sheets[0]['cells'][$i][3];
					
					//Project					
					$project = $data->sheets[0]['cells'][$i][4];
					$pro = "SELECT * from project WHERE Project LIKE '%$project%'";
					$proj = $this->db->fetchRow($pro);
					$set1 .= $proj['ProjectID'];
                    $data->sheets[0]['cells'][$i][4] = $set1;
					//Location
					$location = $data->sheets[0]['cells'][$i][5];
					$loc = "SELECT * from location WHERE locationName LIKE '%$location%'";
					$loca = $this->db->fetchRow($loc);
					$set2 .= $loca['locationID'];
                    $data->sheets[0]['cells'][$i][5] = $set2;
					//Shift
					$shift = $data->sheets[0]['cells'][$i][6];
					$shi = "SELECT * from shift WHERE shift LIKE '%$shift%'";
					$shif = $this->db->fetchRow($shi);
					$set3 .= $shif['shiftID'];
                    $data->sheets[0]['cells'][$i][6] = $set3;
					//Transport
					$transport = $data->sheets[0]['cells'][$i][9];
					$tran = "SELECT * from transport WHERE transportName LIKE '%$transport%'";
					$trans = $this->db->fetchRow($tran);
					$set4 .= $trans['transportID'];
                    $data->sheets[0]['cells'][$i][9] = $set4; 
                    //echo $sql .= "'" . mysql_escape_string($data->sheets[0]['cells'][$i][$j]) . "',";  echo "</br>";
                    $sql .= "'" . mysql_escape_string($data->sheets[0]['cells'][$i][$j]) . "',";					
					//echo "i = ".$i." dan j = ".$j."</br>";echo "</br>";
                }

                //echo $sql .= "'Draft','1',''a";echo "</br>";
                $sql .= "'Draft','1',''a";
                //echo $sql = substr($sql, 0, 0) . ");\r\n";echo "</br>";
                $sql = substr($sql, 0, -1) . ");\r\n";
                $this->db->query($sql);
				//echo "</br>";
				//echo $sql;exit;
				$set1 = '';
				$set2 = '';
				$set3 = '';
				$set4 = '';
				
				
//break;
            }
            //  $sql = substr($sql, 0, -3) . ";";
            // echo $sql;
            $this->_redirect('timesheet');
        }
    }

    function convertExcelToNormalDate($date) {
        $day_difference = 25569; //Day difference between 1 January 1900 to 1 January 1970
        $day_to_seconds = 86400; // no. of seconds in a day
        $unixtime = ($date - $day_difference) * $day_to_seconds;
        return date('Y-m-d', $unixtime);
    }
	
	function convertExcelToNormalTime($date) {
        $day_difference = 25569; //Day difference between 1 January 1900 to 1 January 1970
        $day_to_seconds = 86400; // no. of seconds in a day
        $unixtime = ($date - $day_difference); //* $day_to_seconds;
        return date('H:i:s', $unixtime);
    }
	
	function convertLocation($location){
		$sql = "SELECT * from location WHERE locationName = '$location'";
		$locations = $this->db->fetchRow($sql);
		
		return $locations['value'];
		
	}
	
	function convertShift($shift){
		$sql = "SELECT shiftID from shift WHERE shift = '$shift'";
		$shifts = $this->db->fetchAll($sql);
		
		foreach($shifts as $shifts){
			return $shifts['shiftID'];
		}
	}
	
	function convertTransport($transport){
		$sql = "SELECT transportID from transport WHERE transportName = '$transport'";
		$transports = $this->db->fetchAll($sql);
		
		foreach($transports as $transports){
			return $transports['transportID'];
		}
	}

    function excelTime($time) {
        $day_difference = 25569; //Day difference between 1 January 1900 to 1 January 1970
        $day_to_seconds = 86400; // no. of seconds in a day
        $unixtime = ($time - $day_difference) * $day_to_seconds;
        return date('Y-m-d G:i:s', $unixtime);
    }
	
	public function cloneAction() {
		$this->view->setLayout('layoutBlank.php');
        $id = $_REQUEST['id'];
		
		$employeeID = $this->user->employeeID;
		$userid = $this->user->id; //id employee di jml_users

		$insert['id'] = $userid;
		$insert['employeeID'] = $employeeID;
		$timesheetID = $this->db->insert('timesheet', $insert);
		
		$sql = "SELECT * FROM timesheet_detail where timesheetID = '$id'";
        $this->view->sheets = $sheets = $this->db->fetchAll($sql);
		
		foreach($sheets as $data){
			$data['timesheetID'] = $timesheetID;
			$this->db->insert('timesheet_detail', $data);
		}
        echo 'ok';
		//echo $id;
	}
	
}
?>
