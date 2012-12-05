<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Inst_model');
    }

    public function index() {
        $data['inst_s'] = $this->Inst_model->all_inst_s();
        $head_data['active_page'] = 'i';
        $this->load->view('header', $head_data);
        $this->load->view('inst/index', $data);
        $this->load->view('footer');
    }

    public function inst($inst_ID = 0) {
        $data['inst_s'] = $this->Inst_model->get_ministry_by_ID($inst_ID);
        $head_data['active_page'] = 'i';
        $this->load->view('header', $head_data);
        $this->load->view('inst/inst', $data);
        $this->load->view('footer');
    }

}