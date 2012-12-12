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
        $this->load->model('Contest_model');
        $data['inst_s'] = $this->Inst_model->get_ministry_by_ID($inst_ID);
        //pakļautības ministrijas ID par nosaukumu
        if (isset($data['inst_s'][0]->padotibas_ministrija)) {
            $sub_ministry_name = $this->Contest_model->get_ministry_by_ID($data['inst_s'][0]->padotibas_ministrija);
            $data['inst_s'][0]->sub_inst_link = $data['inst_s'][0]->padotibas_ministrija;
            $data['inst_s'][0]->padotibas_ministrija = $sub_ministry_name[0]->nosaukums;
            
        }
        $head_data['active_page'] = 'i';
        $this->load->view('header', $head_data);
        $inst_array = array();
        $other_organizations_array = array();
        $other_organizations = $this->Contest_model->inst_data($inst_ID);
        foreach ($other_organizations as $other_organization) {
            if (!empty($other_organization)) {
                array_push($other_organizations_array, array("name" => $other_organization->title, "size" => round(sqrt($other_organization->price))));
            }
        }
        array_push($inst_array, array("name" => "institūcija", "children" => $other_organizations_array));
        if (empty($other_organizations_array))//ja nav ieprikumi
            $data['yes_iub'] = FALSE;
        else {
            $data['yes_iub'] = TRUE;
            //root masīvam pievienoju ministrijas ar iepirkumiem
            $head_array = array("name" => "root",
                "children" => $inst_array);
            //Json faila ģenerīšana
            $this->Contest_model->json_file('inst_json.json', $head_array);
        }
        $this->load->view('inst/inst', $data);
        $this->load->view('footer');
    }

}