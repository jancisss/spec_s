<?php

class Test_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function test_f() {
        $query = $this->db->get('budget2012');
        return $query;
    }

}

?>