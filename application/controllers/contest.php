<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {      
        $this->load->model('Contest_model');       
        $ministerieal = $this->Contest_model->get_ministerial();
        $this->load->view('header');
        $ministry_array = array();//ministriju masūvs
        foreach ($ministerieal as $ministry) {

            $instiutions = $this->Contest_model->misistry_data($ministry->id);//ministrijas publisko iepirkumu informācija
            $insti_array = array();//institūciju masīvs
            foreach ($instiutions as $instiution) {             
                array_push($insti_array, array("name" => $instiution->title, "size" => $instiution->price));//masīvs ar konkursiem
            }
            array_push($ministry_array, array("name" => $ministry->nosaukums, "children" => $insti_array));//intitūcijām piesaista iepirkumus
        }
        //root masīvam pievienoju intitūcijas ar iepirkumiem
        $head_array = array("name" => "root",
            "children" => $ministry_array);
        //Json faila ģenerīšana
        $myFile = "testFile.json";
        $fh = fopen($myFile, 'w') or die("can't open file");


        $stringData = json_encode($head_array);
        fwrite($fh, $stringData);

        fclose($fh);
        
        $this->load->view('contest/index');//galvenais skats
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