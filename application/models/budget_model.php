<?php

class Budget_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function get_data($parent = null)
    {
        $query = $this->db->select('id,
                                    name,
                                    value,
                                    parent,
                                    program')->
                              from('budget2012')->
                             where('parent', $parent)->
                          order_by('value', 'desc');
        $data = $query->get()->result();
        return $data;
    }

}

