<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
	
    //test
    public function index() {
        $this->load->model('test_model', 'data');
        print_r($res = $this->data->test_f());
        
    }

}
