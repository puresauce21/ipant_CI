<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Account extends MX_Controller  {
     
		var $data = array(); 

		/** All users login there **/
		public function __construct(){
			parent::__construct();
			$this->load->library(array('session_check','messages'));
			$this->load->model('Account_model');
            //$this->load->model('Master_model');            
		} 
		 
		public function index(){
			if(($this->session->userdata('email')!='') && ($this->session->userdata('userRoleId')==2)){
				redirect('web/account');
			}
			$this->load->view('web_login/account');
		}


		/**     
		 * @method : loginAuth => check users are exits . 
		 * @param  :  Null
		 * @return : Successfully Message or not..
		 */ 
	 public function loginAuth(){
        if($this->input->post()){
            //$this->form_validation->set_rules('email','email','required|trim');
            $this->form_validation->set_rules('password','password','required|trim');
            if($this->form_validation->run() === FALSE){   
                redirect('account');
                return FALSE;
            }else{
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $passwordMd5 = encrypt_password($password);  // encrypt_password   

				 // $rememberMe = $this->input->post('keep_me');
                 // if ($rememberMe == 'keep_me') {
                 //     $this->input->set_cookie('email', $email, time() + 3600 * 30);
                 //     $this->input->set_cookie('password', $password, time() + 3600 * 30);
                 //     $this->input->set_cookie('keep_me', $rememberMe, time() + 3600 * 30);
                 // } else {
                 //     /* Cookie expires when browser closes */
                 //     delete_cookie("email");
                 //     delete_cookie("password");
                 //     delete_cookie("keep_me");
                 // }
               
                $userdata = $this->Account_model->checkuserexit($email,$passwordMd5);
               //echo "<pre>"; print_r($userdata);echo "</pre>";die();
                if($userdata){  
					if($userdata->role_id==2){
                        if($userdata->status==1){
                        
						$this->session->set_userdata('userRoleId',$userdata->role_id); 
						$this->session->set_userdata('userId',encode($userdata->id)); 
						$this->session->set_userdata('email',$userdata->email);  
						$this->session->set_userdata('first_name',$userdata->firstname);  
						$this->session->set_userdata('last_name',$userdata->lastname);  
						$this->messages->setMessageFront('User Logged in successfully !','success');
						redirect(base_url('web/account'));
                        }else{
                            $this->messages->setMessageFront('Your account is not activated','error');
                            redirect(base_url('account'));
                        }    
					}else{
						$this->messages->setMessageFront('Invalid email / mobile or password.','error');
                    	redirect(base_url('account'));
					}
				}else{
                    $this->messages->setMessageFront('Invalid email / mobile or password.','error');
                    redirect(base_url('account'));
                }
            }           
        }else{
			$this->messages->setMessageFront('Invalid email / mobile or password.','error');
			redirect(base_url('account'));
		}
    }


     /*
    *  @access: Public
    *  @description: This method is use to user regristration for STAC wallet  
    *  @auther: Gokul rathod
    *  @return: void 
    */  
     
	public function register(){
        if($this->input->post()){
            $this->form_validation->set_rules('mobile_number','mobile_number','required|trim');
            $this->form_validation->set_rules('country_code','country_code','required|trim');
            $this->form_validation->set_rules('otp','otp','required|trim');   
            if($this->form_validation->run() === false){   
                $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                redirect(base_url('account/register'));
            }else{
                $country_code = $this->input->post('country_code'); 
                $countries_name = $this->Common_model->getDataFromTabel('Countries', 'name, code', array('id'=>$country_code));
                $countries_name = (!empty($countries_name))?$countries_name[0]:'';
                $data['countries_name']= $countries_name;
                $defaultotp = "123456"; //set database
                $otp = $this->input->post('otp');
                $data['mobile_no'] = $this->input->post('mobile_number');
                if($defaultotp==$otp){
                    $this->load->view('web_login/register', $data);
                }else{
                    $data['country_code'] = $country_code;
                    $data['countries_code'] = $this->Common_model->getDataFromTabel('Countries', '*');
                    $this->messages->setMessageFront("Invalid otp, Please try again.",'error');
                    $this->load->view('web_login/register_mobile', $data);
                }
            }
        }else{
            $data['mobile_no'] = "";
            $data['country_code'] = "";
            $data['countries_code'] = $this->Common_model->getDataFromTabel('Countries', '*');
            $this->load->view('web_login/register_mobile', $data);
        }
    }

    // public function nextRegister(){
    //     if($this->input->post()){
    //         $this->form_validation->set_rules('mobile_number','mobile_number','required|trim');
    //         $this->form_validation->set_rules('country_code','country_code','required|trim');
    //         $this->form_validation->set_rules('otp','otp','required|trim');   
    //         if($this->form_validation->run() === false){   
    //             $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
    //             redirect(base_url('account/register'));
    //         }else{
    //             $country_code = $this->input->post('country_code'); 
    //             $countries_name = $this->Common_model->getDataFromTabel('Countries', 'name, code', array('id'=>$country_code));
    //             $countries_name = (!empty($countries_name))?$countries_name[0]:'';
    //             $data['countries_name']= $countries_name;
    //             $defaultotp = "123456"; //set database
    //             $otp = $this->input->post('otp');
    //             $data['mobile_no'] = $this->input->post('mobile_number');
                
                
    //             if($defaultotp==$otp){
                    
    //                 $this->load->view('web_login/register', $data);
    //             }else{
    //                 $this->messages->setMessageFront("Invalid otp, Please try again.",'error');
    //                 redirect(base_url('account/register'));
    //             }
    //         }
    //     }else{
    //         redirect(base_url('account/register'));
    //     }
    // }



    public function registersave(){
        if($this->input->post()){
        	$this->form_validation->set_rules('firstname','firstname','required|trim');
            $this->form_validation->set_rules('lastname','lastname','required|trim');   
            $this->form_validation->set_rules('email','email','required|trim');
            $this->form_validation->set_rules('password','password','required|trim');   
            $this->form_validation->set_rules('mobile_number','mobile_number','required|trim');
			$this->form_validation->set_rules('passport','passport','required|trim');
            $this->form_validation->set_rules('country_code','country_code','required|trim');

            
            if($this->form_validation->run() === false){   
                $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                redirect(base_url('account/register'));
            }else{
            	
        		$email = $this->input->post('email');
        		$mobile_no = $this->input->post('mobile_number');
            	if($this->Account_model->emailExists($email, $mobile_no)==false){

                    $dirPath = 'uploads/identification';
                    // front document image
                    if (isset($_FILES["doc_front"]["name"]) && $_FILES["doc_front"]["name"]!="") {
                        $response=$this->Common_model->uploadProfileImage("identification",$dirPath,"doc_front");
                        $data['varification_front_image'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('account/register'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['varification_front_image']=$response['imageName'];
                        }
                    }

                    // back document image
                    if (isset($_FILES["doc_back"]["name"]) && $_FILES["doc_back"]["name"]!="") {
                        $response=$this->Common_model->uploadProfileImage("identification",$dirPath,"doc_back");
                        $data['varification_end_image'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('account/register'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['varification_end_image']=$response['imageName'];
                        }
                    }
                    $qr_number = generateQrcode($mobile_no);


            		$data['firstname'] = $this->input->post('firstname');
	                $data['lastname'] = $this->input->post('lastname');
	                $data['email'] = $this->input->post('email');
	                $password = $this->input->post('password');
	                $data['password'] = encrypt_password($password);
	                $data['id_pass_number'] = $this->input->post('passport');
                    $data['country_id'] = $this->input->post('country_code');
	                $data['mobile_no'] = $mobile_no;

                    $data['qr_code'] = $qr_number;
                    $data['referral_code']  = create_ref('Users','referral_code');
                    
                    $data['profile_pic'] = 'default.png';
	                $data['role_id'] = '2';
	                $data['status']  = '0';
	                $data['creation_date_time'] = date('Y-m-d H:i:s');
            	}else{
            		$this->messages->setMessageFront("Email/Mobile address already exist.",'error');
            		redirect(base_url('account/register'));
            	}
                //echo "<pre>"; print_r($data);die;
                
                $newuserid = $this->Common_model->addDataIntoTable("Users",$data);


                $url = site_url().'account/varify_user?userid='.encode($newuserid) ;

                $data['subject'] = 'Registration Successful'; 
                $data['description'] = "Thank You, <a href='".$url."'> Click Here </a>To Activate Your Account.";
                $data['body'] = "";
                $msg = $this->load->view('emailtemplate', $data, true);
                $this->sendmail->sendmailto($email,'Verify Email From Stac', "$msg");


                if(!empty($newuserid)){
                    for($i = 1; $i <= 6; $i++){
                        $masterinfo = array(
                            'user_id'    => $newuserid,
                            'email'      => $this->input->post('email'),
                            'password'   => encrypt_password($this->input->post('password')),
                            'qr_code'  => $qr_number,
                            'phone_no'   => $mobile_no,
                            'registration_type' => "1",
                            'user_status' => "0",
                            'moduletype'   => $i,
                            'referral_code'   => create_ref('Users','referral_code'),
                        );
                        $masterid = $this->Account_model->masterUsersave($masterinfo);
                    }    
                }
                
                $this->messages->setMessageFront("Thank You! Please check your email to activate your account",'success');
                redirect(base_url('account/register'));
            }
        }
    }


    public function varify_user(){
        $userId = decode($_GET['userid']);
        if(!empty($userId)){
            $findresult = $this->Account_model->getmasterInfo($userId);
            //echo "<pre>"; print_r($findresult);echo "</pre>";die();
            if($findresult){
                $email = $findresult->email;
                $varify = $this->Account_model->updatedata($email, array('user_status' => "1"));

                $this->Common_model->updateDataFromTabel("Users",array('status' => "1"),array('email'=>$email));
                
                echo 'Verify Successfully';
            } else {
                echo 'Not Verify Please Try again Later';
            }       
        }else{
            echo 'Please try again';
        }
        
    }

    
    public function forgotpassword() {  
        $post=$this->input->post();
        if ($post) {
            $response=$this->Account_model->getUserInfoForgot($post['mobile_number']);
            
            if (!empty($response)) { 
                // $logo = getLogo();
                // $logo=!empty($logo->option_value) ? $logo->option_value : "";
                // $imagePath = base_url('/uploads/logo_favicon/'.$logo);
                 if ($response->status==1) {
                     $emailToken = sha1(rand());
                    if($response->role_id==2){  // user
                    
                        //update password into database
                         $newPassword    =   "123456";
                        $this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$response->id)); 
                        
                        $this->messages->setMessage("New Password has been sent your registered mobile number!.",'success');
                        redirect(base_url('account'));
                    
                    }else{
                        $this->messages->setMessageFront('Error: Invalid user.','error');
                        redirect(base_url('account'));
                    } 
                }else{
                    $this->messages->setMessageFront('Error: User is deactivated.','error');
                    redirect(base_url('account'));
                }
            }
            else
            {
                $this->messages->setMessageFront('Mobile number not exist.','error');
                redirect(base_url('account/forgotpassword'));
            }
        }
        else
        {
            $this->load->view('web_login/forgotpassword');
        }
    }
    
    

    public function checkMobileExist(){
        $mobile_number=$this->input->post('mobile_number');
        if( $this->toCheckValidMobileNumber($mobile_number) == false){
                $response_array = array('isSuccess'=>false, 'message'=>'Mobile number only have numbers');
        }else{
            // check mobile number for master database table
            $mastercheckmobile = $this->Account_model->masterMobileExists($mobile_number);
            // check mobile number for wallet database table
            $checkmobile = $this->Account_model->mobileExists($mobile_number);
            
            if($mastercheckmobile && $checkmobile){
                $response_array = array('isSuccess'=>false, 'message'=>'Mobile number already exist');
            }else{
                // otp code here 
                $response_array = array('isSuccess'=>true, 'message'=>'Otp sent your mobile number');
            }
        }
        echo json_encode($response_array); 
    }


    
    public function toCheckValidMobileNumber($mobile_number){
        if(!preg_match('#[^0-9]#', trim($mobile_number))){
           return true;
        }else{
            return false;
        }
    }
}
