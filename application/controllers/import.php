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

        $this->import_model->createTables($table);
        $currentInst = false; //no institution at start
        foreach ($lines as $line) {
            if ($this->haveClass($line)) {
                if ($this->getType($line) == 'string' && $this->getValue($line) != '') {
                    $parent = $this->import_model->findParent($table, $this->findClass($line));
                    if (isset($parent[0]->id)) {
                        $parentId = $parent[0]->id;
                    } else {
                        $parentId = null;
                    }

                    if ($this->isInstitution($line)) {
                        //ievirtotDB
                        //echo $this->getInstitutionName($line);
                        //  if ($this->import_model->findInstitutionByName($this->getInstitutionName($line), $table)) { //find if institution alreay exitst in DB
                        // echo $line . ' </br>';
                        if ($this->haveSpan($line))
                            $name = $this->cheackMistakes($this->getInstitutionName($line));
                        else
                            $name = $this->getInstitutionName($line);

                        $currentInst = $this->import_model->insertInstitution($table, $name);
                    }
                    $cleanValue = $this->cheackMistakes($this->getValue($line));
                    if ($cleanValue != '' && is_numeric($currentInst) && $this->findClass($line) < '91') { //insert only if this is  institution or have parnet institution
                        echo "Inserting row parent <b>" . $parentId . "</b> nosaukumu: <b>" . $this->getValue($line) . "</b> institution: <b>" . $currentInst . '</b></br>';
                        $this->import_model->insertRecord($table, $parentId, $this->getValue($line), null, $this->findClass($line), $currentInst);
                    }
                } else if ($this->getType($line) == 'number' && (($this->findClass($line) == '160') || ($this->findClass($line) == '75'))) {
                    $parent = $this->import_model->findValueParent($table);
                    if (isset($parent[0]->id)) {
                        $parent = $this->import_model->updateParent($table, $parent[0]->id, $this->getIntValue($line));
                    }
                } else if ($this->isCode($line)) {
                   // echo $line . '</br>';
                }
            }
        }
    }

    private function isCode($string) {
                        echo $this->findClass($string);
        if (!$this->haveClass($string) && $this->findClass($string) != '73') {

            return false;
        }
        if ($this->getValue($string) != '')
            return true;
        return false;
    }

    private function isInstitution($string) {
        if (!$this->haveClass($string) || $this->findClass($string) != '88')
            return false;
        $string = trim(str_replace(' ', '', $this->getValue($string)));
        $subStr1 = substr($string, 0, 2);
        if (is_numeric($subStr1)) {
            return true;
        } else {
            return false;
        }
    }

    private function getInstitutionName($string) {
        $string = trim($this->getValue($string));
        $subStr1 = substr($string, 3);
        return trim($subStr1);
    }

    private function haveSpan($string) {
        return strpos($string, '<span');
    }

    private function cheackMistakes($string) { //to remove <span> element if exist
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
        if (stripos($subStr, ">")) {
            return trim(str_replace(' ', '', $this->checkClass($subStr)));
        } else {
            return trim(str_replace(' ', '', $subStr));
            ;
        }
    }

    private function checkClass($string) {
        $pos = strpos($string, '>');
        if ($pos) {
            $subStr = substr($string, $pos - 2, 2);
            return $subStr;
        } else {
            return;
        }
    }

}
