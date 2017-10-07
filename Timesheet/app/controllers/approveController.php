<?php

class approveController extends Crayd_Controller {
	
	public function preDispatch() {
		//echo $this->user->type;
	IF($this->user->type == 1){
			$this->_redirect('timesheet');
		}
	}
	
    public function indexAction() {
        $sql = "SELECT * FROM approval_project";
        $output = $this->db->fetchAll($sql);

        foreach ($output as $value) {
            $project[$value['ProjectID']]['approver'][1] = $value['Approval_1'];
            $project[$value['ProjectID']]['approver'][2] = $value['Approval_2'];
            $project[$value['ProjectID']]['approver'][3] = $value['Approval_3'];
        }

        if (in_array('10', $project['P4']['approver'])) {
            //   echo "ada";
        }


        $sql = "SELECT * FROM timesheet_detail WHERE status ='Waiting Approval'";
        $timesheet = $this->db->fetchAll($sql);

        foreach ($timesheet as $val) {
            if (in_array('40', $project[$val['project']]['approver'])) {
                $status = "ada";
            } else {
                $status = "ga ada";
            }
            echo $val['project'] . $status . "<br />";
        }
        
        exit;
    }

}