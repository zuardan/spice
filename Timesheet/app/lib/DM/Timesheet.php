<?
class Dm_Timesheet extends Dm {
	
    var $timesheet;
    var $id;
    var $where = array('enabled = 1');
    var $page = 1;
    var $perpage = 24;
    var $order = "priority DESC, id DESC";
	
    public function __construct() {
        parent::__construct();
    }
	
	public function load(){
	    $where = implode(" AND ", $this->where);
        $from = ($this->page - 1) * $this->perpage;
        //$sql = "SELECT * FROM packs WHERE $where ORDER BY {$this->order} LIMIT $from, {$this->perpage} ";
	}
}
?>