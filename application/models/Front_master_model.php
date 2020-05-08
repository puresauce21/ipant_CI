<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Front_master_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->master_db = $this->load->database('master', True);
	}
	

	public function insertdata($tbnm = null,$var = array()){
		$this->master_db->insert($tbnm, $var);
		return $this->master_db->insert_id(); 
	}


	public function getdatafromtable($tbnm, $condition = array(), $data = "*", $limit="", $offset="", $orderby ='') {
		$this->master_db->select($data);
		$this->master_db->from($tbnm);
		if(!empty($condition)){
			$this->master_db->where($condition);
		}
        $this->master_db->order_by("$orderby", "DESC");
		If($limit != '')
		{
			$this->master_db->limit($limit, $offset);
		}

		$query = $this->master_db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}


	function updatedata($table, $where = array(), $data = array()) {
	    $this->master_db->where($where);
	    $this->master_db->update($table, $data);
	    $updated_status = $this->master_db->affected_rows();
 		return $updated_status;
	}


	public function checkMobile($key) {
		$arg = array(
		    'phone_no' => $key
		);
		$query = $this->master_db->get_where("sm_users", $arg);
		if($query->num_rows() != 0){
			return $query->result_array();
		} else {
			return false;
		}
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