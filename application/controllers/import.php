<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('import_model');
    }

    public function index() {
        // $data['inst_s'] = $this->Inst_model->all_inst_s();
        $head_data['active_page'] = 'i';
        $data = "";
        $this->load->view('header', $head_data);
        $this->load->view('import/import_view', $data);
        $this->load->view('footer');
    }

    public function take() {
        $table = trim($this->input->post('table_name'));
        if (!$table) {
            echo "Please enter table name";
            return;
        }
        if (!trim($this->input->post('text_input'))) {
            echo "Please enter file text";
            return;
        }
        $lines = explode(PHP_EOL, $this->input->post('text_input'));
        // $lines[0] = '<td class=>123</td>';
        $this->import_model->createTable($table);
        // print_r($lines);
        $classes = array();
        foreach ($lines as $line) {
            if ($this->haveClass($line)) {
                $f = 0;
                if ($this->getType($line) == 'string') {
                    for ($i = 0; $i < count($classes); $i++) {
                        echo '</br></br>' . $classes[$i]->class . '=' . $this->findClass($line) . '</br></br>';
                        if ($classes[$i]->class == $this->findClass($line)) {
                            $f = 1;
                            if ($i == 0)
                                $parent = null;
                            else
                                $parent = $classes[$i - 1]->key;
                            echo '</br>' . "ievietoju tabulā $table ar vacāku   $parent    vārdu " . $this->getValue($line) . " klasi " . $this->findClass($line);
                            $this->import_model->insertRecord($table, $parent, $this->getValue($line), null, $this->findClass($line));
                            break;
                        }
                    }
                    if ($f == 0) {
                        $elem = new stdClass();
                        echo '</br>' . $line . '</br>';
                        echo '</br>' . "Ievietoju tabulā $table  vārdu " . $this->getValue($line) . " klasi " . $this->findClass($line) . '</br>';
                        $elem->key = $this->import_model->insertRecord($table, null, $this->getValue($line), null, $this->findClass($line));
                        echo 'Tika ievietots ieraksts ' . $elem->key . '</br>';
                        $elem->class = $this->findClass($line);
                        array_push($classes, $elem);
                        echo 'Masīvs ' . print_r($classes) . '</br>';
                    }
                } else {
                    $elem->key = $this->import_model->insertRecord($table, null, '123', null, '0000');
                }
            }
        }
    }

    private function haveClass($string) {
        return strpos($string, 'class=');
    }

    private function getType($string) {
        if (is_numeric($this->getValue($string))) {
            return 'number';
        } else {
            return 'string';
        }
    }

    private function getValue($string) {
        $posBegin = strpos($string, '>');
        $posEnd = strpos($string, '</td>');
        if ($posBegin && $posEnd) {
            $subStr = substr($string, $posBegin + 1, $posEnd - $posBegin - 1);
            return trim(str_replace(' ', '', $subStr));
        } else
            return false;
    }

    private function findClass($string) {
        $pos = stripos($string, "class=");
        $subStr = substr($string, $pos + 7, 4);
        return $subStr;
    }
    
    private function createArray($string){
        
    }

}
