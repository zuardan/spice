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
		$this->view->project = $this->db->fetchAll("SELECT DISTINCT Project FROM project WHERE value > 0 order by Project asc");
		
		if ($this->getRequest()->isPost()) {
			$data = $_POST;
			$this->view->setView('ajax');
			$period = $data['period'];
			$year=$data['year'];
			$from=date('Y-m-d', strtotime($data['from_date']));
			$to=date('Y-m-d', strtotime($data['to_date']));
			$projects = $data['projectID'];
			$employeeID = $this->user->employeeID;
			$data['shift'] = 0;
			$sql = "SELECT DISTINCT approved.timesheet_id, time.employeeID , approved.*  , detail.*, trans.value, loc.value locval
			FROM timesheet `time` 
			LEFT JOIN timesheet_approved approved 
			ON time.timesheetID = approved.timesheet_id 
			LEFT JOIN  timesheet_detail `detail` 
			ON detail.timesheetID = approved.timesheet_id
			LEFT JOIN transport trans on detail.transport=trans.transportID
			LEFT JOIN location loc on detail.location=loc.locationID
			WHERE timesheet_id !='' AND detail.status = 'approved'
			AND  time.employeeID = '$employeeID'
			AND detail.project=$projects
			AND detail.date between '$from' and '$to'
			GROUP BY approved.timesheet_id
			ORDER BY detail.date";
		//echo $sql;
			//$this->view->sheets = $this->db->fetchAll($sql);
			$sheets = $this->db->fetchAll($sql);
			foreach($sheets as $value){
				//$data['days'] = $data['days'] + $value['value'];				
				if($value['shift'] == '2'){
					$data['shift'] = $data['shift'] + 1;					
				}
				if($value['transport']['value'] == '2'){
					$values = 1;
				}
				else{
					$values = 0.5;
				}
				if($value['locval']['value']=='0'){
					$values=0;
				}
				$total = $total + $values;
				//echo $days;
			}
			//$days = 1; //dummy
			$data['days'] = $total; 
			//$data['days'] = $data['period'];
			
			$sql1 = "SELECT * from jml_users where employeeID like '$employeeID' ";

			IF($this->db->count($sql1) > 0){
				$result = $this->db->fetchRow($sql1);
				$a = $result['id'];
			}

			$data['id'] = $a;
			$data['NIK'] = $employeeID;
			$data['date'] = date('Y-m-d');
			$data['from_date']=$from;
			$data['to_date']=$to;
			$project = $data['projectID'];
			$year = $data['year'];
			$data['status']='Waiting Approval';
			$sql="SELECT * FROM claim WHERE projectID = '$project' AND NIK = '$employeeID' AND from_date between '$from' and '$to'";
			IF($this->db->count($sql) > 0){
				$flag = 1;
			}
			//exit;
			
			/*function newWeekNumberOfMonth1($date) {
			$tgl1=date_parse($date);
			$tanggal1 =  $tgl1['day'];
			$bulan1   =  $tgl1['month'];
			$tahun1  =  $tgl1['year'];
			
			//tanggal 1 tiap bulan
			/*$tanggalAwalBulan1 = mktime(0, 0, 0, $bulan1, 1, $tahun1);
			$mingguAwalBulan1 = (int) date('W', $tanggalAwalBulan1);*/

			//tanggal sekarang
			/*$bulanYangDicari1 = mktime(0, 0, 0, $bulan1, $tanggal1, $tahun1);
			$bulanTanggalYangDicari1 = (int) date('m', $bulanYangDicari1);
			$bulanKe1 = $bulanTanggalYangDicari1;

			return $bulan1Ke1;
			}
			
			function newWeekNumberOfMonth2($date) {
			$tgl2=date_parse($date);
			$tanggal2 =  $tgl2['day'];
			$bulan2   =  $tgl2['month'];
			$tahun2  =  $tgl2['year'];
			
			//tanggal 1 tiap bulan
			/*$tanggalAwalBulan2 = mktime(0, 0, 0, $bulan2, 1, $tahun2);
			$mingguAwalBulan2 = (int) date('M', $tanggalAwalBulan2);*/

			//tanggal sekarang
			/*$bulanYangDicari2 = mktime(0, 0, 0, $bulan2, $tanggal2, $tahun2);
			$bulanTanggalYangDicari2 = (int) date('m', $bulanYangDicari2);
			$bulanKe2 = $bulanTanggalYangDicari2;

			return $bulanKe2;
		}*/

		function weekNumberOfMonth1($date) {
			$tgl1=date_parse($date);
			$tanggal1 =  $tgl1['day'];
			$bulan1   =  $tgl1['month'];
			$tahun1  =  $tgl1['year'];
			
			//tanggal 1 tiap bulan
			$tanggalAwalBulan1 = mktime(0, 0, 0, $bulan1, 1, $tahun1);
			$mingguAwalBulan1 = (int) date('W', $tanggalAwalBulan1);

			//tanggal sekarang
			$tanggalYangDicari1 = mktime(0, 0, 0, $bulan1, $tanggal1, $tahun1);
			$mingguTanggalYangDicari1 = (int) date('W', $tanggalYangDicari1);
			$mingguKe1 = ($mingguTanggalYangDicari1-$mingguAwalBulan1)+1;

			return $mingguKe1;
		}
		
		function weekNumberOfMonth2($date) {
			$tgl2=date_parse($date);
			$tanggal2 =  $tgl2['day'];
			$bulan2   =  $tgl2['month'];
			$tahun2  =  $tgl2['year'];
			
			//tanggal 1 tiap bulan
			$tanggalAwalBulan2 = mktime(0, 0, 0, $bulan2, 1, $tahun2);
			$mingguAwalBulan2 = (int) date('W', $tanggalAwalBulan2);

			//tanggal sekarang
			$tanggalYangDicari2 = mktime(0, 0, 0, $bulan2, $tanggal2, $tahun2);
			$mingguTanggalYangDicari2 = (int) date('W', $tanggalYangDicari2);
			$mingguKe2 = ($mingguTanggalYangDicari2-$mingguAwalBulan2)+1;

			return $mingguKe2;
		}
		
		$tanggal1=$from;
		$number_week1=weekNumberOfMonth1($tanggal1);
			//echo $number_week1;
		$tanggal2=$to;
		$number_week2=weekNumberOfMonth2($tanggal2);
			//echo $number_week2;
		$data['week']=$number_week1;

			//$number_month1=newWeekNumberOfMonth1($tanggal1);
			//echo $number_week1;
			//$number_month2=newWeekNumberOfMonth2($tanggal2);
			//echo $number_week2;
			//$data['month']=$number_month1;


		if($data['days'] != 0){
			IF($flag == 1){
				echo 'exist';
				}/*elseif($number_week1!=$number_week2){
					echo 'weeknotsame';}*/
					elseif((int)date("W",strtotime($from)) != (int)date("W",strtotime($to))) {
						echo 'weeknotsame';
					}
					else{
						$this->db->insert('claim', $data);
						echo 'ok';
					}
				//echo $sql;
				//echo $value['value'];
				}
				else{
					echo 'cancel';
				//echo $sql;
				}
			}
		}
		
		public function listAction() {
			$this->view->setLayout('layoutBlank.php');
			$employeeID = $this->user->employeeID;
		//$where = "WHERE approved.status = 'approved' AND  MONTH(date) = ";
		//$where = "WHERE MONTH(date) = ";
			
			if($this->user->types==3){
				
				if ($_REQUEST['employee']){
					$where .="AND a.NIK = '{$_REQUEST['employee']}'";
				}
				else {
					$emp = $this->user->employeeID;
					$where .="AND a.NIK = '$emp'";
				}
				
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
				$limit = 10;
				
				$sql = " 
				select a.*, b.* from claim a left join claim_approved b on a.claimID=b.claimID where a.status='Approved'
				$where";
				//print_r($sql);
				$this->view->sheets = $sheets = $this->db->fetchAll($sql);
				
				$total = $this->db->count($sql);
				$pages = ceil($total / $limit);
				$from = ($page - 1) * $limit;
				
				$sql = " 
				select distinct a.claimID, a.*, b.* from claim a left join claim_approved b on a.claimID=b.claimID where a.status='Approved'
				$where 
				GROUP BY a.claimID
				ORDER BY date DESC
				LIMIT $from, $limit";
				//print_r($sql);
				$this->view->sheets = $sheets = $this->db->fetchAll($sql);
				$this->view->pages = $pages;
				$this->view->from = $from;
				
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
				
				$sql="SELECT distinct T2.employeeID, b.name FROM timesheet_detail T1
				left join timesheet T2 on T1.timesheetID = T2.timesheetID
				left join approval_project a on T1.project = a.ProjectID
				inner join jml_users b on T2.employeeID = b.employeeID
				WHERE (T1.status = 'Waiting Approval' OR T1.status = 'Approved')
				AND b.employeeID=T2.employeeID AND a.Approval_1='$employeeID' order by b.name ASC";
				$this->view->listemp = $this->db->fetchAll($sql);
				
				
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
			} else if($this->user->types==3 AND $employeeID==$_REQUEST['employee']){
				
				if ($_REQUEST['employee']){
					$where .=" where a.NIK = '{$_REQUEST['employee']}'";
				}
				else {
					$emp = $this->user->employeeID;
					$where .=" where a.NIK = '$emp'";
				}
				
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
				$limit = 10;
				
				$sql = " 
				select a.*, b.approvedID, b.approve_id, b.approved_date, b.status, b.description
				from claim a left join claim_approved b on a.claimID=b.claimID
				$where";
				$this->view->sheets = $sheets = $this->db->fetchAll($sql);
				//print_r($sql);
				$total = $this->db->count($sql);
				$pages = ceil($total / $limit);
				$from = ($page - 1) * $limit;
				
				$sql = " 
				select a.*, b.approvedID, b.approve_id, b.approved_date, b.status, b.description
				from claim a left join claim_approved b on a.claimID=b.claimID
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
				$this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
				$this->view->valueShift = $valueShift = $this->db->fetchAll("SELECT * FROM shift", true, "shiftID");
				$sql="SELECT * FROM approval_project where Approval_1 = '$employeeID'";
				$this->view->pmoResult = $pmoResult = $this->db->fetchAll($sql, true, "employeeID");
				$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
				$sql = "SELECT * FROM timesheet";
				$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
				
				$sql="SELECT distinct T2.employeeID, b.name FROM timesheet_detail T1
				left join timesheet T2 on T1.timesheetID = T2.timesheetID
				left join approval_project a on T1.project = a.ProjectID
				inner join jml_users b on T2.employeeID = b.employeeID
				WHERE (T1.status = 'Waiting Approval' OR T1.status = 'Approved')
				AND b.employeeID=T2.employeeID AND a.Approval_1='$employeeID' order by b.name ASC";
				$this->view->listemp = $this->db->fetchAll($sql);
				
				
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
			
			else{
				
				if ($_REQUEST['employee']){
					$where .="where a.NIK = '{$_REQUEST['employee']}'";
				}
				else {
					$emp = $this->user->employeeID;
					$where .="where a.NIK = '$emp'";
				}
				
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
				
				if ($_REQUEST['project']){
					$where .=" AND a.projectID = '{$_REQUEST['project']}'";
				}
				
				$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
				$limit = 10;
				
				$sql = " 
				select a.*, b.approvedID, b.approve_id, b.approved_date, b.status, b.description
				from claim a left join claim_approved b on a.claimID=b.claimID
				$where";
				$this->view->sheets = $sheets = $this->db->fetchAll($sql);
		//echo $sql; 
				$total = $this->db->count($sql);
				$pages = ceil($total / $limit);
				$from = ($page - 1) * $limit;
				
				$sql = " 
				select a.*, b.approvedID, b.approve_id, b.approved_date, b.status, b.description
				from claim a left join claim_approved b on a.claimID=b.claimID
				$where 
				ORDER BY date DESC
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
				$this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
				$this->view->valueShift = $valueShift = $this->db->fetchAll("SELECT * FROM shift", true, "shiftID");
				$sql="SELECT * FROM approval_project where Approval_1 = '$employeeID'";
				$this->view->pmoResult = $pmoResult = $this->db->fetchAll($sql, true, "employeeID");
				$this->view->detail = $this->db->fetchAll("SELECT * FROM timesheet_detail",true,"timesheetID");
				$sql = "SELECT * FROM timesheet";
				$this->view->timesheetDetail = $timesheetDetail = $this->db->fetchAll($sql, true,"timesheetID");
				
				$sql="SELECT distinct T2.employeeID, b.name FROM timesheet_detail T1
				left join timesheet T2 on T1.timesheetID = T2.timesheetID
				left join approval_project a on T1.project = a.ProjectID
				inner join jml_users b on T2.employeeID = b.employeeID
				WHERE (T1.status = 'Waiting Approval' OR T1.status = 'Approved')
				AND b.employeeID=T2.employeeID AND a.Approval_1='$employeeID' order by b.name ASC";
				$this->view->listemp = $this->db->fetchAll($sql);
				
				
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
			
		}
		
		public function excelAction() {
			$this->view->setLayout('layoutExcel.php');
		//echo "as";
        //$this->view->filename = 'Claim' . '.xls';

			if ($_REQUEST['month']) {
			//echo $_REQUEST['month'] . $_REQUEST['year'] . $_REQUEST['employee'];exit;
				$where .=" AND MONTH(from_date) = {$_REQUEST['month']} ";
			}
			else {
				$where .=" AND MONTH(from_date) = MONTH(CURDATE()) ";
			}
			
			if ($_REQUEST['year']) {
				$where .=" AND YEAR(from_date) = {$_REQUEST['year']} ";
			}
			else {
				$where .=" AND YEAR(from_date) = YEAR(CURDATE()) ";
			}
			
			if ($_REQUEST['employee']){
				$where .=" AND NIK = '{$_REQUEST['employee']}'";	
				$this->view->emply = $_REQUEST['employee'];
			}
			else {
				$emp = $this->user->employeeID;
				$where .=" AND NIK = '$emp'";
				$this->view->emply = $emp;
			}
			
		//echo $where;exit;
			
			$sql = " SELECT * from claim where status='Approved'
			$where
			ORDER BY from_date ASC";
			$this->view->sheets = $sheets = $this->db->fetchAll($sql);
			
			if ($this->db->count($sql) > 0) {
				$this->view->value = $this->db->fetchRow($sql);
			}
			
			set_time_limit(1800);
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
			
			$sql = "SELECT * FROM project";
			$this->view->projectResult = $projectResult = $this->db->fetchAll($sql, true, "ProjectID");		
			$sql = "SELECT * FROM project ORDER BY ProjectID DESC";
			$this->view->projectsResult = $projectsResult = $this->db->fetchAll($sql, true, "ProjectID");
			$sql = "SELECT * FROM project WHERE shift = '2'";
			$this->view->projectsResult2 = $projectsResult = $this->db->fetchAll($sql, true, "Project");	
			
			$this->view->valueTransport = $valueTransport = $this->db->fetchAll("SELECT * FROM transport", true, "transportID");
			
			$this->view->employeeclaim = $employeeclaim = $this->db->fetchAll("SELECT * FROM jml_users", true, "employeeID");

		}
		
		public function editAction() {
			if (isset($_GET['iframe'])) {
				$this->view->setLayout('layoutIframe.php');
				$this->view->isIframe = true;
			} else {
				$this->view->setLayout('layoutBlank.php');
			}
			
        //$this->view->sheets = $sheets = $this->db->fetchAll($sql);

			$id = $_REQUEST['id'];
        //$sql = "SELECT * FROM jml_users WHERE ID = '$id'";
			$sql = " 
			SELECT a.*, b.approvedID, b.approve_id, b.approved_date, b.status, b.description, c.ProjectID, c.Project, c.value
			from claim a join claim_approved b on a.claimID = b.claimID join project c on a.projectID = c.ProjectID where a.claimID = '$id'";

			if ($this->db->count($sql) > 0) {
				$this->view->value = $this->db->fetchRow($sql);
			}

			$sql1 = "SELECT * FROM project";
			$this->view->projectResult = $projectResult = $this->db->fetchAll($sql1, true, "ProjectID");

			if ($this->getRequest()->isPost()) {
				$this->view->setView('ajax');

				$data = $_POST;
				$id = $_REQUEST['id'];

				$insertfromdate['from_date'] = date('Y-m-d', strtotime($data['date']));
				$inserttodate['to_date'] = date('Y-m-d', strtotime($data['date1']));
				$insert['projectID'] = $data['project'];
				$insert['days'] = $data['day'];

            //$projectid = $insert['projectID'];

            //$selectProjectID = "SELECT * FROM project WHERE ProjectID = '$projectid'";

				if(strcmp($insertfromdate['from_date'], '1970-01-01') != 0){
					$this->db->update('claim', $insertfromdate, "claimID = '$id'");
				}

				if(strcmp($inserttodate['to_date'], '1970-01-01') != 0){
					$this->db->update('claim', $inserttodate, "claimID = '$id'");
				}

				$this->db->update('claim', $insert, "claimID = '$id'");

				echo "ok";

			} 
		}

		public function removeAction() {
			$this->view->setLayout('layoutBlank.php');
			$id = $_REQUEST['id'];
			
			$this->db->delete('claim', "claimID = '$id'");
			
			
			echo "ok";
		}
	}

	?>
