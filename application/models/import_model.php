<?php

class Import_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    function insertRecord($table, $parent, $name, $value, $class, $insti) {
        set_time_limit(1200);
        $data = array(
            'parent' => $parent,
            'name' => $name,
            'value' => $value,
            'class' => $class,
            'institucijas_id' => $insti
        );
        $this->db->insert("$table", $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function createTables($tableName) {
        $institutionTable = $tableName . 'Insti';
        $query = $this->db->query(""
                . "CREATE TABLE IF NOT EXISTS `$institutionTable` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NULL,
                    PRIMARY KEY (`id`))
                    ENGINE = InnoDB;");
        $query = $this->db->query(""
                . "CREATE TABLE IF NOT EXISTS `$tableName` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `name` VARCHAR(255) NULL,
                  `value` INT(20) NULL,
                  `program` INT(11) NULL,
                  `class` VARCHAR(45) NULL,
                  `parent` INT(11) NULL,
                  `institucijas_id` INT(11) NOT NULL,
                  `function_code` VARCHAR(20) NULL,
                  PRIMARY KEY (`id`),
                  INDEX `fk_budzets_budzets_idx` (`parent` ASC),
                  INDEX `fk_budzets_institucijas1_idx` (`institucijas_id` ASC),
                  CONSTRAINT `fk_budzets_budzets`
                    FOREIGN KEY (`parent`)
                    REFERENCES `$tableName` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT `fk_budzets_institucijas1`
                    FOREIGN KEY (`institucijas_id`)
                    REFERENCES `$institutionTable` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ENGINE = InnoDB;");
    }

    public function findInstitutionByName($name, $tableName) {
        $institutionTable = $tableName . 'Insti';
        $query = $this->db->select('id')->
                from("$institutionTable")->
                like('name', $name);
        $data = $query->get()->result();
        if (isset($data[0])) {
            return $data[0];
        }
        return false;
    }

    public function findParent($tableName, $class) {
        $query = $this->db->query(""
                . "SELECT DISTINCT id, name FROM $tableName WHERE class < $class ORDER BY class, id DESC LIMIT 0,1");
        return $query->result();
    }

    public function findValueParent($tableName) {
        $query = $this->db->query(""
                . "SELECT DISTINCT id, name FROM $tableName WHERE class != '160' ORDER BY id DESC LIMIT 0,1");
        return $query->result();
    }

    public function updateParent($tableName, $parentId, $value) {
        $query = $this->db->query(""
                . "UPDATE $tableName "
                . "SET VALUE = $value "
                . "WHERE id = $parentId");
    }

    public function insertInstitution($table, $name) {
        $institutionTable = $table . 'Insti';
        $data = array(
            'name' => $name
        );
        $this->db->insert("$institutionTable", $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

}
