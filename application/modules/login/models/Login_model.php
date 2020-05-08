<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_model{

	function __construct(){
		parent::__construct();	
		
	}
	
	/*
	 * @description: This function is used to user id and password exist then login
	 * @param: $pastdata
	 * @return: boolean (true/false)
	 */ 
	
	function checkuserexit($email,$password){ 
        $this->db->select('*');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        //$this->db->where('status',1);
        //$this->db->where('role_id',1);
        //$this->db->or_where('role_id',3);
        $query = $this->db->get('Users');
        if ($query->num_rows()>0) {
            if($query->row())
                return $query->row();
            else
                return false;
        }
    }

	
    /*
     * Check Email Exists
     * @param email,type
     * @return bool/int/array
     * */
	public function emailExists($email)
	{   
		$email = trim($email);
		if($email){
		$this->db->where(array('username'=>$email,'isArchived'=>0));
		$query = $this->db->get('user_auth');
		if($query->num_rows() > 0){
             return $query->row();       
        }
	   }
	   return FALSE;
	}


	function getUserInfoForgot($email){
		$resp=array();
		if(!empty($email)){
			$this->db->select('*');
			$this->db->from('Users');
			$this->db->where("email",$email);
			$query=$this->db->get();
			$resp=$query->row();
	    }
	    return $resp;
	}
}
?>
