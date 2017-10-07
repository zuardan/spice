<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class importController extends Crayd_Controller {

	public function listAction() {
		$this->view->setLayout('layoutBlank.php');
		
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
                    $data->sheets[0]['cells'][$i][2] = $this->convertExcelToNormalDate($data->sheets[0]['cells'][$i][2]);
                    $data->sheets[0]['cells'][$i][3] = $this->convertExcelToNormalDate($data->sheets[0]['cells'][$i][3]);
                    $sql .= "'" . mysql_escape_string($data->sheets[0]['cells'][$i][$j]) . "',";
                }

                $sql .= "'Draft','1'a";
                $sql = substr($sql, 0, -1) . ");\r\n";
                $this->db->query($sql);
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
        return date('Y-m-d G:i:s', $unixtime);
    }

    function excelTime($time) {
        $day_difference = 25569; //Day difference between 1 January 1900 to 1 January 1970
        $day_to_seconds = 86400; // no. of seconds in a day
        $unixtime = ($time - $day_difference) * $day_to_seconds;
        return date('Y-m-d G:i:s', $unixtime);
    }
	
}

?>
