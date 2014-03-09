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
        $head_data['active_page'] = 'import';
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
        $lines = explode('<td', $this->input->post('text_input'));

        $this->import_model->createTable($table);

        foreach ($lines as $line) {
            if ($this->haveClass($line)) {
                if ($this->getType($line) == 'string' && $this->getValue($line) != '') {
                    $parent = $this->import_model->findParent($table, $this->findClass($line));
                    if (isset($parent[0]->id)) {
                        $parentId = $parent[0]->id;
                    } else {
                        $parentId = null;
                    }
                    $cleanValue = $this->cheackMistakes($this->getValue($line));
                    if ($cleanValue != '') {
                        $this->import_model->insertRecord($table, $parentId, $this->getValue($line), null, $this->findClass($line));
                    }
                } else if ($this->getType($line) == 'number' && ($this->findClass($line) == '160')) {
                    $parent = $this->import_model->findValueParent($table);
                    if (isset($parent[0]->id)) {
                        $parent = $this->import_model->updateParent($table, $parent[0]->id, $this->getIntValue($line));
                    }
                }
            }
        }
    }

    private function cheackMistakes($string) {
        $posBegin = strpos($string, '<span');
        $posEnd = strpos($string, '</span>');
        $subStr1 = substr($string, 0, $posBegin);
        $subStr2 = substr($string, $posEnd + 7);
        return $subStr1 . $subStr2;
    }

    private function haveClass($string) {
        return strpos($string, 'class=');
    }

    private function haveStyle($string) {
        return strpos($string, 'style=');
    }

    private function haveWidth($string) {
        return strpos($string, 'width=');
    }

    private function getType($string) {
        if (is_numeric(str_replace(' ', '', $this->getValue($string)))) {
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
            return trim($subStr);
        } else
            return false;
    }

    private function getIntValue($string) {
        $posBegin = strpos($string, '>');
        $posEnd = strpos($string, '</td>');
        if ($posBegin && $posEnd) {
            $subStr = substr($string, $posBegin + 1, $posEnd - $posBegin - 1);
            return trim(str_replace(' ', '', $this->getValue($string)));
        } else
            return false;
    }

    private function findClass($string) {
        $pos = stripos($string, "class=");
        $subStr = substr($string, $pos + 8, 3);
        return $subStr;
    }

    private function createArray($string) {
//if(!haveClass) return;
        $array = array();

        $posBegin = stripos($string, "<td");
        $posEnd = stripos($string, ">");
        if ($posBegin && $posEnd) {
            $subStr = substr($string, $posBegin + 1, $posEnd - $posBegin - 1);
            if (($this->haveClass($subStr) && $this->haveStyle($string) && $this->haveWidth($string) || ($this->haveClass($subStr) && $this->getType($subStr) == 'number')))
                array_push($array, $subStr);
            echo 'Ierakstu masīvs' . print_r($arrays);
        }
    }

}
