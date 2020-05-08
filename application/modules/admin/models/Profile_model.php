<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Profile_model extends CI_model{

	function __construct(){
		parent::__construct();	
		
	}
	
	 /*
    *  @access: Public
    *  @description: This method is use to get user data
    *  @auther: Gokul rathod
    *  @return: void 
    */
    
	 function getuserdata($userId=''){
        if(!empty($userId)){  
            $this->db->select('*');
            $this->db->where('id',$userId);
            $this->db->where('status','1');
            $query = $this->db->get('Users');
            if($query->row())
                return $query->row();
            else
                return false;
                
        }else{
            return false;
        }	
	}
	
	
   /*
    *  @access: Public
    *  @description: This method is use to update user for admin
    *  @auther: Gokul rathod
    *  @return: void
    */
    
    
    public function userUpdate($userId='',$data, $oldImageName=''){
		//~ if(!empty($data['admin_profile']) && !empty($oldImageName)){
			//~ $dirPath = "upload/admin/adminProfle/".$oldImageName;
			//~ unlink($dirPath);
			//~ $this->session->set_userdata('admin_profile', $data['admin_profile']); // profile set in session 
		//~ }
		$this->db->where('id', $userId);
        return $this->db->update('Users' ,$data); 
    }
	
	
	
	/*
    *  @access: Public
    *  @description: This method is use to change password for a user
    *  @auther: Gokul rathod
    *  @return: void
    */
	
    public  function change_password($userId,$newPass){ 
         if(!empty($userId)) {
             $data=array('password'=>$newPass);
             $this->db->where('id', $userId);
            return $this->db->update('Users' ,$data);
        }else{
            return false;
        }
	}
}
?>
