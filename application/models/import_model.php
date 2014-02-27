<?php

class Import_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    function insertRecord($table, $parent, $name, $value, $class) {
        $data = array(
            'parent' => $parent,
            'name' => $name,
            'value' => $value,
            'class' => $class,
        );
        $this->db->insert("$table", $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function createTable($tableName) {
        $query = $this->db->query(""
                . "CREATE TABLE IF NOT EXISTS `$tableName` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                       `value` bigint(20) DEFAULT NULL,
                       `parent` int(11) DEFAULT NULL,
                       `program` int(11) DEFAULT NULL,
                       `class` int(5) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `program` (`program`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6537 ;");
        return $query;
    }

    //Informācija par ministriju pēc ID
    public function get_ministry_by_ID($misinstry_ID = 0) {
        if ($misinstry_ID == 0)
            return 0;
        $query = $this->db->select('id, nosaukums')->
                from('institutions')->
                where('id', $misinstry_ID);
        $data = $query->get()->result();
        return $data;
    }

}
