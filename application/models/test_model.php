<?php

class Test_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function test_f() {
        $query = $this->db;;
        $query1=$query->select('name')->from('budget2012');
        return $query1;
        
    }

}

?>