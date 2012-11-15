<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        // $parent = (intval($parent) == 0) ? null : intval($parent);
        //$budget = $this->Budget_model;
        //$data['budget_items'] = $budget->get_data($parent);
        $this->load->model('Contest_model');
        $data['institutions'] = $this->Contest_model->get_institutions();
        $data['organizations'] = $this->Contest_model->get_organizations();
        $this->load->view('header');
       //$this->load->view('sidebar');
        $this->load->view('contest/index', $data);
        $this->load->view('footer');
    }

}

?>