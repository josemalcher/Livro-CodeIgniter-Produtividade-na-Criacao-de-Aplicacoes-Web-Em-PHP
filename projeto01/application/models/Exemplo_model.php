<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examplo_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function Save($data){
        $this->db->insert('table',$data);
        if($this->db->insert_id()){
            return true;
        }
        else{
            return FALSE;
        }
    }
}