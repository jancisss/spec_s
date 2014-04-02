<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class budget2014 extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('budget2014_model');
    }

    public function index() {
        // $data['inst_s'] = $this->Inst_model->all_inst_s();
        $head_data['active_page'] = 'budget2014';
       // $data = $this->budget2014_model->getBudget();
       // print_r($data);
        $data='';
       // $array = array();
       // array_push($array, 'janis');
        
        $this->budget2014_model->json_file('test.json',  $this->budget2014_model->getBudget());
        $this->load->view('header', $head_data);
        $this->load->view('budget2014/import_view', $data);
        $this->load->view('footer');
    }

}
