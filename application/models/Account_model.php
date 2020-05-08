<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Account_model extends CI_model{

	function __construct(){
		parent::__construct();	
		$this->master_db = $this->load->database('master', True);
	}	
	
	/*
	 * @description: This function is used to user id and password exist then login
	 * @param: $pastdata
	 * @return: boolean (true/false)
	 */ 
	
	function checkuserexit($email,$password){ 
        $this->db->select('*');
        $where = '(email="'.$email.'" or mobile_no="'.$email.'")';
        $this->db->where($where);
        $this->db->where('password',$password);
        $query = $this->db->get('Users');
        if ($query->num_rows()>0) {
            if($query->row())
                return $query->row();
            else
                return false;
        }
    }

	


    
    public function emailExists($email,$mobile_no){
        $this->db->select('*');
		$this->db->where('mobile_no',$mobile_no);
		$this->db->where('email',$email);
		$query =$this->db->get('Users');
        if($query->num_rows() > 0){
            return true;
		}else {
            return false;
		}
	}
    


    public function mobileExists($mobile_number){
    	$this->db->select('*');
		$this->db->where('mobile_no',$mobile_number);
		$this->db->where("role_id",2);
		$query =$this->db->get('Users');
        if($query->num_rows() > 0){
            return true;
		}else {
            return false;
		}	
    }


	
	function getUserInfoForgot($mobile){
		$resp=array();
		if(!empty($mobile)){
			$this->db->select('*');
			$this->db->from('Users');
			$this->db->where("role_id",2);
			$this->db->where("mobile_no",$mobile);
			$query=$this->db->get();
			$resp=$query->row();
	    }
	    return $resp;
	}



	public function masterMobileExists($mobile_number){
    	$this->master_db->select('*');
		$this->master_db->where('phone_no',$mobile_number);
		$query =$this->master_db->get('sm_users');
        if($query->num_rows() > 0){
            return true;
		}else {
            return false;
		}	
    }


     public function masterUsersave($data){
        $this->master_db->insert('sm_users', $data); 
	    return $this->db->insert_id();
    }
	

    function getmasterInfo($userId){
		$resp=array();
		if(!empty($userId)){
			$this->master_db->select('*');
			$this->master_db->from('sm_users');
			$this->master_db->where("user_id",$userId);
			$query=$this->master_db->get();
			$resp=$query->row();
	    }
	    return $resp;
	}



	public function updatedata($email, $data){
		$this->master_db->where('email', $email);
        return $this->master_db->update('sm_users' ,$data); 
    }

}
?>
