<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_model{

	function __construct(){
		parent::__construct();	
		$this->master_db = $this->load->database('master', True);
	}

	public function updatedata($table, $where = array(), $data = array()) {
	    $this->master_db->where($where);
	    $this->master_db->update($table, $data);
	    $updated_status = $this->master_db->affected_rows();
 		return $updated_status;
	}

	public function checkEmail($key) {
		$arg = array(
		    'email' => $key
		);
		$query = $this->master_db->get_where("sm_users", $arg);
		if($query->num_rows() != 0){
			return $query->result_array();
		} else {
			return false;
		}
	}


}