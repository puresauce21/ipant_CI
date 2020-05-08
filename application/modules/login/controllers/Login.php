<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Login extends MX_Controller  {
     
		var $data = array(); 

		/** All users login there **/
		public function __construct(){
			parent::__construct();
			$this->load->library(array('session_check','messages'));
			$this->load->model('Login_model');
		} 
		 
		public function index(){
			if(($this->session->userdata('email')!='') && ($this->session->userdata('userRoleId')==1)){
				redirect('admin/dashboard');
			}
			// else if(($this->session->userdata('email')!='') && ($this->session->userdata('userRoleId')==2)){
			// 	redirect('web/account');
			// }
			$this->load->view('login');
		}


		/**     
		 * @method : loginAuth => check users are exits . 
		 * @param  :  Null
		 * @return : Successfully Message or not..
		 */ 
	 public function loginAuth(){
        if($this->input->post()){
            $this->form_validation->set_rules('email','email','required|trim');
            $this->form_validation->set_rules('password','password','required|trim');
            if($this->form_validation->run() === FALSE){   
                redirect('login');
                return FALSE;
            }else{
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $passwordMd5 = encrypt_password($password);  // encrypt_password   
               
				 $rememberMe = $this->input->post('keep_me');
                 if ($rememberMe == 'keep_me') {
                     $this->input->set_cookie('email', $email, time() + 3600 * 30);
                     $this->input->set_cookie('password', $password, time() + 3600 * 30);
                     $this->input->set_cookie('keep_me', $rememberMe, time() + 3600 * 30);
                 } else {
                     /* Cookie expires when browser closes */
                     delete_cookie("email");
                     delete_cookie("password");
                     delete_cookie("keep_me");
                 }
               
                $userdata = $this->Login_model->checkuserexit($email,$passwordMd5);
                if($userdata){  
                	$roleDetails =  $this->Common_model->getDataFromTabel($this->db->dbprefix.'Roles', 'id', array( 'is_login_admin'=> 1));
                	if(!empty($roleDetails)){
                		$roleArray=array();
                		foreach($roleDetails as $role){
                			$roleArray[]= $role->id;
							
                		}
                	}

                	// echo "<pre>"; print_r($roleArray);echo "</pre>";
                	// echo "<pre>"; print_r($userdata);echo "</pre>";
                	// echo "<pre>"; print_r($roleDetails);echo "</pre>";die();
					//if($userdata->role_id==1 || $userdata->role_id==5){
                	if (in_array($userdata->role_id, $roleArray)) {
						$this->session->set_userdata('userRoleId',$userdata->role_id); 
						$this->session->set_userdata('userId',encode($userdata->id)); 
						$this->session->set_userdata('email',$userdata->email);  
						$this->session->set_userdata('first_name',$userdata->firstname);  
						$this->session->set_userdata('last_name',$userdata->lastname);  
						$this->messages->setMessageFront('User Loged in successfully !','success');
						redirect(base_url('admin/dashboard'));
					}else{
						$this->messages->setMessageFront('Invalid email or password.','error');
                    	redirect(base_url('login'));
					}
				}else{
                    $this->messages->setMessageFront('Invalid email or password.','error');
                    redirect(base_url('login'));
                }
            }           
        
        }else{
			$this->messages->setMessageFront('Invalid email or password.','error');
			redirect(base_url('login'));
		}
    }



    
    
    public function forgotpassword() {	
		$post=$this->input->post();
		if ($post) {
			$response=$this->Login_model->getUserInfoForgot($post['email']);

			if (!empty($response)) { 
				$logo = getLogo();
	    		$logo=!empty($logo->option_value) ? $logo->option_value : "";
	    		$imagePath = base_url('/uploads/logo_favicon/'.$logo);
				 if ($response->status==1) {
					 $emailToken = sha1(rand());
					if($response->role_id==1){  // super admin
					
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'admin_forgot_password', 'userType'=>1);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac Admin',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id. Please reset you password",'success');
						redirect(base_url('login'));
					} elseif($response->role_id==5){ // sub-admin
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'subadmin_forgot_password', 'userType'=>5);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac Sub-Admin',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id please reset you password!.",'success');
						redirect(base_url('login'));
					} elseif($response->role_id==2){ // Users
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'user_forgot_password', 'userType'=>2);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac User',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id please reset you password!.",'success');
						redirect(base_url('login'));
					} elseif($response->role_id==3){ // Merchant
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'merchant_forgot_password', 'userType'=>3);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac Merchant',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id please reset you password!.",'success');
						redirect(base_url('login'));
					} elseif($response->role_id==4){ // Agent
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'agent_forgot_password', 'userType'=>4);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac Agent',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id please reset you password!.",'success');
						redirect(base_url('login'));
					} elseif($response->role_id==6){ // Distributor
						//--------------get template data----------------------
						$whereCondtion = array('templateKey'=>'distributor_forgot_password', 'userType'=>6);
						$templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
						$templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
						
						//$imagePath  = base_url("upload/admin/logo/Colored.png");
						
						$image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
						$userEmail      =  $response->email;
						$fullName       =  $response->firstname.' '.$response->lastname;
						$newPassword    =   randomnumber('6');
						$clickLink      =   base_url('login');
						$regards        =   'Stac';
						
						//update password into database
						$this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id));	
						
						
						// if template exist 
						if(!empty($templateresponse)){
							$templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
							$templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
							$parseArray        = array("{image_logo}" , "{fullName}" , "{newPassword}" , "{clickLink}" , "{regards}");
							$replaceArray      = array($image_logo,$fullName,$newPassword,$clickLink,$regards);
							$templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
						}
						
						//--------------load email template----------------
						$this->sendmail->sendmailto($userEmail,'Forgot Password for Stac Distributor',$templateBodyReady);
						
						$this->messages->setMessage("Mail sent your email id please reset you password!.",'success');
						redirect(base_url('login'));
					}
				}else{
					$this->messages->setMessageFront('Error: User is deactivated.','error');
					redirect(base_url('login'));
				}
			}
			else
			{
				$this->messages->setMessageFront('Email not exist.','error');
				redirect(base_url('login/forgotpassword'));
			}
		}
		else
		{
			$this->load->view('forgotpassword');
		}
	}
    
    


  
        
		/**     
		 * @method : logout => User Session Destroy . 
		 * @param  :  Null
		 * @return : Successfully Message or not..
		 */ 
		public function logout() {  
			$array_items = array('userId', 'userRoleId','email','first_name','last_name');
			$this->session->unset_userdata($array_items);
			$this->session->sess_destroy();
			redirect(base_url());
		}
    
    }
