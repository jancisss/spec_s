<?php

class Budget_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    var $programs  = null;
	
    public function get_data($parent = null)
    {
        $query = $this->db->select('program_id,
                                    name,
                                    institution')->
                              from('2012_budget_programs')->
							 where('type', 'P');
        $data = $query->get()->result();
		
		foreach ($data as $program){
			$query = $this->db->select('program_id,
										name,
										institution')->
								  from('2012_budget_programs')->
								 where(array('type' => 'A',
											 'parent_id' => $program->program_id));
			$program->children = $query->get()->result();
		}
		
        return $data;
    }
	
	public function get_2012programs()
	{
		$query = $this->db->
					select('id AS program_id,
							name,
							institution,
							subprogram_code,
							function_code')->
					  from('budget_program2012')->
					 where('id > 6')->
				  not_like('name', '3.mērķa "Eiropas teritoriālā sadarbība"');
		$this->programs = $query->get()->result();
		
		$this->add_parent();
	}
	
	public function add_parent()
	{
		$cur_parent = 0;
		foreach ($this->programs as $program)
		{
			//echo intval(substr($program->title, 0, 2)).'<br />';
			if(intval(substr($program->name, 0, 2)) > 0 ){
				//echo $program->title.'<br />';
				$cur_parent = $program->program_id;
				$program->parent_id = NULL;
				$program->type = 'P'; //Programma
			} else if($cur_parent != 0){
				//echo $program->title.'<br />';
				$program->parent_id = $cur_parent;
				switch ($program->name) {
					case 'Resursi izdevumu segšanai':
						$program->type = 'R'; //Resursi
						break;
					case 'Izdevumi – kopā':
						$program->type = 'I'; //Izdevumi
						break;
					default:
						$program->type = 'A'; //Apakšprogramma
				}
			}
		}
		
		//$this->db->truncate('2012_budget_programs');
		//@$this->db->insert_batch('2012_budget_programs', $this->programs);
		//632
		//echo '<pre>';
		//print_r($this->programs);
		//echo '</pre>';
		
	}

}

