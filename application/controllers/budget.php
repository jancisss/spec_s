<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Budget_model');
    }

    public function index($parent = 0)
    {
        $header_data['active_page'] = 'budget';
		  $this->load->view('header', $header_data);
        $this->load->view('budget/index');
		  $this->load->view('footer');
    }

}

/* End of file budget.php */
/* Location: ./application/controllers/budget.php */