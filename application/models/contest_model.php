<?php

class Contest_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_data($parent = null) {
        /* $query = $this->db->select('id,
          name,
          value,
          parent,
          program')->
          from('budget2012')->
          where('parent', $parent)->
          order_by('value', 'desc'); */
        $query = $this->db->select('nosaukums')->
                from('institutions');
        $data = $query->get()->result();
        return $data;
    }

    public function get_all_instiutions() {
        /* $query = $this->db->select('institutions.id, institutions.nosaukums')->
          from('institutions, iub_contests');
          //where('iub_contests.institution_id', 'institutions.id'); */
    }

    public function write_file($line) {
        $file = 'people.js';
// Open the file to get existing content
        $current = file_get_contents($file);
// Append a new person to the file
        $current .= $line;
// Write the contents back to the file
        file_put_contents($file, $current . "\n");
    }

    public function get_ministerial() {
        $query = $this->db->select('id,nosaukums')->
                from('institutions')->
                where('padotibas_ministrija', NULL)->
                where('id !=', '8')->
                where('id !=', '37')->
                where('id !=', '38')->
                where('id !=', '40')->
                where('id !=', '41')->
                where('id !=', '42')->
                where('id !=', '39')->
                where('id !=', '14')->
                where('id !=', '12');
        $data = $query->get()->result();
        return $data;
    }

    public function misistry_data($id) {

        $query = $this->db->select('OO.title, ICW.price')->
                from('iub_contests AS IC, other_organizations AS OO, iub_contest_winners AS ICW')->
                where('IC.institution_id', $id)->
                where('ICW.contest_id = IC.id')->
                where('ICW.id = OO.id');
        $data = $query->get()->result();
        return $data;



        return $data;
    }

}