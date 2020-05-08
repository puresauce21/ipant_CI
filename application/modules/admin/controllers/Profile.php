<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Profile extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Profile_model');
        $this->userId = $this->session->userdata('userId');// encode form
    } 
     
     
     
    /*
    *  @access: public
    *  @Description: This method is used load admin profile 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function index(){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
		$this->breadcrumbs->push($this->lang->line('edit_profile'), '/');
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('edit_profile');
		$data['adminInfo'] =  $this->Profile_model->getuserdata(decode($this->userId));
        $this->home_template->load('home_template','admin/profile/profile', $data);    
    }
    
    
    
  /*
    *  @access: public
    *  @Description: This method is used update user profile detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function profileUpdate($id){
		if(!empty($id)){
			if($this->input->post()){
				$this->form_validation->set_rules('firstname','firstname','required|trim');
				$this->form_validation->set_rules('lastname','lastname','required|trim');
				//$this->form_validation->set_rules('mobile','mobile','required|trim');
				
				if($this->form_validation->run() === false){   
					$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
					redirect(base_url('admin/profile'));
				}else{
					$userId = decode($id);
					$data['firstname']  = $this->input->post('firstname');
					$data['lastname']   = $this->input->post('lastname');
					//$data['mobile_no']=$this->input->post('mobile');
					 $oldImageName = !empty($this->input->post('oldImageName')) ? $this->input->post('oldImageName') : '';
					 $dirPath = 'uploads/admin_profile';
					if (isset($_FILES["adminProfile"]["name"]) && $_FILES["adminProfile"]["name"]!="") {
						 $response=$this->Common_model->uploadProfileImage("admin",$dirPath,"adminProfile");
						 $data['profile_pic'] = '';
						 if (!empty($response) && $response['status']=="error") {
							 redirect(base_url('admin/profile')); 
						 } else if(!empty($response) && $response['status']=="success") {
							 $data['profile_pic']=$response['imageName'];
						 }
					 }
					$insertId = $this->Profile_model->userUpdate($userId,$data, $oldImageName="");
					if($insertId){
						$this->messages->setMessageFront($this->lang->line('update_successful'),'success'); 
						redirect(base_url('admin/profile'));
					}else{
						$this->messages->setMessageFront($this->lang->line('please_try_again'),'error'); 
						redirect(base_url('admin/profile'));
					}
				}
			}
		}
	}
		
	
	
		
    /*
    *  @access: public
    *  @Description: This method is used load change password page 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function changePassword(){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
        $this->breadcrumbs->push('Change Password', '/');
        /*breadcrumb code end */
        $data['title']='Change Password';
        $data['notification_val'] = $this->Profile_model->get_notification(decode($this->userId));
		$this->home_template->load('home_template','admin/profile/changepassword', $data);    
    }
    
    
    
     /*
    *  @access: Public
    *  @description: This method is use to change password for admin
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
	public function resetPassword(){
		$userId=decode($this->userId);
		if(!empty($userId)){
           $oldPassword  = $this->input->post('oldPassword');
           $mdpass = encrypt_password($oldPassword);
           $newPassword  = $this->input->post('newPassword');
           $newmdPass = encrypt_password($newPassword);
           $confPassword  = $this->input->post('confPassword');
           
			$currentPassword = $this->Profile_model->getuserdata($userId);
			$currPass = $currentPassword->password;
            if($mdpass == $currPass){
                if($newPassword==$confPassword){
                    $insertId = $this->Profile_model->change_password($userId,$newmdPass);
                    if($insertId){
                        $this->messages->setMessageFront("Password Changed",'success');
                        redirect(base_url('admin/profile/changepassword'));
                    }
                }else{
                    $this->messages->setMessageFront("New password or confirm password not match",'error');
                    redirect(base_url('admin/profile/changepassword'));
                }
            }else{
                $this->messages->setMessageFront("Old Password Invalid",'error');
                redirect(base_url('admin/profile/changepassword'));
            }
        } 
        
	}
    
}
