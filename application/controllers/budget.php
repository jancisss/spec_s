﻿<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Budget_model');
    }

    public function index($parent = 0)
    {
//        $parent = (intval($parent) == 0) ? null : intval($parent);
//        $budget = $this->Budget_model;
//        $data['budget_items'] = $budget->get_data($parent);
//        $this->load->view('header');
//        $this->load->view('sidebar');
//        $this->load->view('budget/view', $data);
//        $this->load->view('footer');
        
        $this->load->view('budget/index');
    }

}

/* End of file budget.php */
/* Location: ./application/controllers/budget.php */