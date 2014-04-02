<?php

class Budget2014_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    public function getBudget() {
        $query = $this->db->query(""
                . "SELECT DISTINCT * FROM budget2014");
        return $query->result();
    }

    //create json
    public function json_file($title, $content) {
        $fh = fopen($title, 'w') or die("can't open file");
        $stringData = json_encode($content);
        fwrite($fh, $stringData);
        fclose($fh);
    }

}
