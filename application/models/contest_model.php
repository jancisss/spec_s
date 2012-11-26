<?php

class Contest_model extends CI_Model {

    function __construct() {
        
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

    //Institūciju publiskie iepirkumi
    public function inst_data($id) {
        $query = $this->db->select('OO.title, ICW.price')->
                from('iub_contests AS IC, other_organizations AS OO, iub_contest_winners AS ICW')->
                where('IC.institution_id', $id)->
                where('ICW.contest_id = IC.id')->
                where('ICW.id = OO.id');
        $data = $query->get()->result();
        return $data;
    }
    //Ministrijas padotās institūciajas
    public function sub_institutions($misinstry_ID = 0) {
        if ($misinstry_ID == 0)
            return 0;
        $query = $this->db->select('id, nosaukums')->
                from('institutions')->
                where('padotibas_ministrija', $misinstry_ID);
        $data = $query->get()->result();
        return $data;
    }

    //JSON faila rakstīšana
    public function json_file($title, $content) {
        $fh = fopen($title, 'w') or die("can't open file");
        $stringData = json_encode($content);
        fwrite($fh, $stringData);
        fclose($fh);
    }

}