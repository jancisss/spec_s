<?php

class Inst_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    //Informācija par ministriju pēc ID
    public function get_ministry_by_ID($misinstry_ID = 0) {
        if ($misinstry_ID == 0)
            return 0;
        $query = $this->db->select('id,
            nosaukums,
            juridiskais_ststuss,
            padotibas_forma,
            padotibas_ministrija,
            adrese,
            telefons,
            majas_lapa`,
            e_pasts, 
            darba_laiks`,
            pienemsanas_laiki,
            noteikumi, 
            reglaments, 
            struktura, 
            normativo_aktu_saraksts, 
            publisks_parskats,
            mk_rikojums,
            mk_padotibas_loceklis, 
            strategija,
            merki_rezultati,
            budzets, 
            papildus_skaidrojums, 
            amatpersonas')->
                from('institutions')->
                where('id', $misinstry_ID);
        $data = $query->get()->result();
        return $data;
    }

    public function all_inst_s() {
        $query = $this->db->select('id, nosaukums, padotibas_ministrija')->
                from('institutions');
        $data = $query->get()->result();
        return $data;
    }
    
    

}