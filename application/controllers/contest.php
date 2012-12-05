<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Contest_model');
    }

    //Ministriju publiskie iepirkumi
    public function index() {

        $this->load->view('header');
        $data['ministerieal'] = $this->Contest_model->get_ministerial();
        $ministry_array = array(); //ministriju masūvs
        foreach ($data['ministerieal'] as $ministry) {
            $instiutions = $this->Contest_model->inst_data($ministry->id); //ministrijas publisko iepirkumu informācija
            $insti_array = array(); //institūciju masīvs
            foreach ($instiutions as $instiution) {
                array_push($insti_array, array("name" => $instiution->title, "size" => round($instiution->price))); //masīvs ar konkursiem
            }
            array_push($ministry_array, array("name" => $ministry->nosaukums, "children" => $insti_array)); //intitūcijām piesaista iepirkumus
        }
        //root masīvam pievienoju ministrijas ar iepirkumiem
        $head_array = array("name" => "root",
            "children" => $ministry_array);
        //Json faila ģenerīšana
        $this->Contest_model->json_file('ministry_data.json', $head_array);
        $this->load->view('contest/index', $data); //galvenais skats
        $this->load->view('footer');
    }

    public function inst_iub($ministry_ID = 0) {
        if ($ministry_ID == 0)
            redirect('/contest');
        $this->load->view('header');
        $data['ministry_title'] = $this->Contest_model->get_ministry_by_ID($ministry_ID);
        $inst_s = $this->Contest_model->sub_institutions($ministry_ID);
        $inst_array = array();      
        $data['inst_list'] = array(); //ministrijas padoto institīuciju masīvs, prikš leģendas
        foreach ($inst_s as $institution) {
            $other_organizations = $this->Contest_model->inst_data($institution->id);
            if (!empty($other_organizations))//ja šai institūcijai ir iepirkumi
                array_push ($data['inst_list'], $institution);
            $other_organizations_array = array();
            foreach ($other_organizations as $other_organization) {
                if (!empty($other_organization)) {
                   /// if(!array_search($institution->nosaukums, $i))
                  //  array_push($i, $institution->nosaukums);
                    array_push($other_organizations_array, array("name" => $other_organization->title, "size" => round($other_organization->price)));
                }
            }
            array_push($inst_array, array("name" => $institution->nosaukums, "children" => $other_organizations_array));
        }
      
        //root masīvam pievienoju ministrijas ar iepirkumiem
        $head_array = array("name" => "root",
            "children" => $inst_array);
        //Json faila ģenerīšana
        $this->Contest_model->json_file('sub_inst.json', $head_array);
        //$data = '';
        $this->load->view('contest/inst_iub', $data); //galvenais skats
        $this->load->view('footer');
    }

    public function contests() {
        // $parent = (intval($parent) == 0) ? null : intval($parent);
        //$budget = $this->Budget_model;
        //$data['budget_items'] = $budget->get_data($parent);
        $this->load->model('Contest_model');

        $this->load->view('header');
        //$this->load->view('sidebar');
        //Sarakstu js data failu
        // $this->Contest_model->write_file();
        $intsi = $this->Contest_model->get_all_instiutions();
        // print_r($intsi);
        $this->Contest_model->write_file(" var flare = {"); //head
        foreach ($intsi as $inst) {

            $this->Contest_model->write_file($inst->nosaukums);
        }
        $this->Contest_model->write_file(" }"); //head
        $data = '';
        $this->load->view('contest/contests', $data);
        $this->load->view('footer');
    }

}
?>