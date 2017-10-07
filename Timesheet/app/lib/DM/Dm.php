<?

class Dm {
    
    /** 
     *
     * @var Crayd_Database
     */
    var $db;
    
    var $user;
    
    public function __construct() {
        $this->db = Crayd_Database::factory();
        $this->user = Crayd_Registry::get('user');
    }
    
}