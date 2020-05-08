<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		header('Content-Type: application/json');
		$this->load->library('form_validation');
		$this->load->model('dynamic_model');
		//$this->load->library('encryption');
		//$this->load->library('Authorization_Token');
         error_reporting(0);
		 $language = $this->input->get_request_header('language');
		// if($language == "en")
		// {
		// 	$this->lang->load("message","english");
		// }
		if($language == "sw")
		{
			$this->lang->load("message","swedish");
		}
		else
		{
			$this->lang->load("message","swedish");
		}
	}

	// App Version Check
	public function version_check_get()
	{
		$arg = array();
		$version_result = version_check_helper();
		echo json_encode($version_result);
	}

	// App Version Check
	public function version_check1_get() {
		$arg = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 ){
			$arg = $version_result;
		} else {
			
		}

		echo json_encode($arg);
	}

	//Check Auth for customer
	public function check_auth($logout = NULL) {

	    $auth_token = $this->input->get_request_header('Authorization');
	    $user_token = json_decode(base64_decode($auth_token));

	    $usid     =  $user_token->userid;
		$auth_key =  $user_token->token;
		if($usid != '' && $auth_key != '') {
			$condition = array(
				'id' => $usid,
				'token' => $auth_key
			);
			$loguser = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'Users', $condition);
			if($loguser) {
				if($usid == $loguser[0]['id'] && $auth_key == $loguser[0]['token']) {

					if(!empty($logout)) {
						$data2 = array(
							'token' => '',
							'device_id'   => '',
							'device_type' => ''
							//'Is_LoggedIn' => '0'
						);
		                $wheres = array("id" => $usid);
		                $result = $this->dynamic_model->updateRowWhere($this->db->dbprefix."Users", $wheres, $data2);

						return $this->lang->line('logout_success');
					} else {
						return true;
					}
					
				} else {
					return $this->lang->line('session_expire');
				}


			} else {
				return $this->lang->line('varify_token_userid');
			}
		} else {
			return $this->lang->line('header_required');
		}
	}

	// Forgot Password Function
	public function forgot_password_post()
	{
		$arg   = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{

			$this->form_validation->set_rules('mobile_no', 'Mobile', 'required|min_length[9]|max_length[10]|numeric', array(
				'required' => $this->lang->line('mobile_required'),
				'min_length' => $this->lang->line('mobile_min_length'),
				'max_length' => $this->lang->line('mobile_max_length'),
				'numeric' => $this->lang->line('mobile_numeric'),
				'is_unique' => $this->lang->line('mobile_unique')
			));

			$this->form_validation->set_rules('varification_type', 'Varification Type', 'required|numeric|less_than[2]', array('less_than' => $this->lang->line('verification_type_0_1')));

			if ($this->form_validation->run() == FALSE)
			{
			  	$arg['status']  = 0;
			 	$arg['message'] = get_form_error($this->form_validation->error_array());
			} else {
				$checkglobalmobile = array(
					'mobile_no' => $this->input->post('mobile_no')
				);

				if($this->input->post('varification_type') == 0 ) {
					$checkmobile = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'Users', $checkglobalmobile);
					$msg = $this->lang->line('already_register');
				} else {
					$checkmobile = false;
				}
				if($checkmobile)
				{
					$arg['status']  = 0;
			 		$arg['message'] = $msg;
				}
				else
				{ 
					if($this->input->post('varification_type') == 0 )
					{
						$forcheck = true;
					}

					if($this->input->post('varification_type') == 1 ) 
					{
						$forcheck = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'Users', $checkglobalmobile);
					}

					if($forcheck)
					{
						$mobile_no=$this->input->post('mobile_no');
						$condition = array(
							'mobile_number' => $mobile_no,
							'otp_type' => $this->input->post('varification_type')
						);
						$result = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition);

						$otpnumber = generate_Pin();
						//$otpnumber = '345645';
						//$otpmsg = "Your Otp is $otpnumber";
					    $otpmsg = "Use $otpnumber as one time password (OTP) for forgot password to your ipant account. Do not share this OTP to anyone for security reasons.";
					    $condition1 = array(
							'mobile_no' => $mobile_no
						);
					    $user_data = getdatafromtable($this->db->dbprefix.'Users', $condition1);
						//print_r($user_data);die;
						pilvo_sms($user_data[0]['country_code'],$mobile_no,$otpmsg);

						$otpdetail = array(
					       	'mobile_number' => $this->input->post('mobile_no'),
					       	'otp' => $otpnumber,
					       	'otp_type' => $this->input->post('varification_type'),
					       	 'user_id' => $forcheck[0]['id']
						);

						if($result)
						{
							$otpid  = $result[0]['user_id'];
			                $wheres = array("user_id" => $otpid,'otp_type' => $this->input->post('varification_type'));
			                $updated_token = update_data($this->db->dbprefix."Users_Otp_Verification", $otpdetail, $wheres);
						}
						else
						{
							$otpid = $this->dynamic_model->insertdata($this->db->dbprefix.'Users_Otp_Verification', $otpdetail);
						}

				        if($otpid)
				        {

				        	$data_val[]        = array('user_id'=>"$otpid",'otp'=>$otpnumber,'varification_type'=>$this->input->post('varification_type'));
				        	$arg['status']     = 1;
				        	$arg['errorcode']  = REST_Controller::HTTP_OK;
						 	$arg['data']       = $data_val;
						 	$arg['message']    = $this->lang->line('otp_send');
						 	//$arg['data']['otp'] = '123456';
						 	//$arg['data']['varification_type'] = $this->input->post('varification_type');
				        }
					}
					else
					{
						$arg['data']       = array();
						$arg['errorcode']  = REST_Controller::HTTP_NOT_MODIFIED;
						$arg['status']     = 0;
					 	$arg['message']    = $this->lang->line('register_first');
					}
				}
			}
		}
			echo json_encode($arg);
		}
	}

	//Used function for register function 
	public function register_post()
	{
		$arg   = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{
				$this->form_validation->set_rules('firstname', 'First Name', 'required', array( 'required' => $this->lang->line('first_name')));
				$this->form_validation->set_rules('lastname', 'Last Name', 'required', array( 'required' => $this->lang->line('last_name')));
				$this->form_validation->set_rules('email', 'Email', 'valid_email' , array( 
					'valid_email' => $this->lang->line('email_valid')
				));
				$this->form_validation->set_rules('mobile_no', 'Mobile', 'required|min_length[9]|max_length[10]|numeric', array(
						'required' => $this->lang->line('mobile_required'),
						'min_length' => $this->lang->line('mobile_min_length'),
						'max_length' => $this->lang->line('mobile_max_length'),
						'numeric' => $this->lang->line('mobile_numeric')
					));
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]', array( 
					'required' => $this->lang->line('password_required'),
					'min_length' => $this->lang->line('password_minlength'),
					'max_length' => $this->lang->line('password_maxlenght')
				));

				if ($this->form_validation->run() == FALSE)
				{
				  	$arg['status']  = 0;
				 	$arg['message'] = get_form_error($this->form_validation->error_array());
				}
				else
				{
					$device_type = $this->input->get_request_header('device_type', true);
					$device_id   = $this->input->get_request_header('device_id', true);

					$firstname       = $this->input->post('firstname');
					$lastname        = $this->input->post('lastname');
					$email           = $this->input->post('email');
					$mobile_no       = $this->input->post('mobile_no');
					$hashed_password = encrypt_password($this->input->post('password'));

					//check mobile number is already exist or not?
					$condition = array(
								'mobile_no' => $mobile_no
							);
					$result = getdatafromtable($this->db->dbprefix.'Users', $condition);

					if(!empty($result))
					{
						if($result[0]['is_profile_complete'] == "0")
						{
							$userdata['firstname']      = $firstname;
							$userdata['lastname']       = $lastname;

							$where = array(
							    	'id' => $result[0]['id']
							    );
							$updatedata = update_data("Users",$userdata, $where);

							$condition = array(
								'mobile_number' => $mobile_no
							);
							$results = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition);
							$user_id = $result[0]['id'];
							$otpnumber = generate_Pin();
							//$otpnumber = '345645';
							//$otpmsg = "Your Otp is $otpnumber";
							$otpmsg = "Use $otpnumber as one time password (OTP) for mobile varification to your ipant account. Do not share this OTP to anyone for security reasons.";
								//sendSms($this->input->post('mobile_no'), $otpmsg);
								$otpdetail = array(
							       	'mobile_number' => $mobile_no,
							       	'otp' => $otpnumber,
							       	'otp_type' => 0
								);
								$wh= array('mobile_number' => $mobile_no,'otp_type' => 0);
								pilvo_sms($result[0]['country_code'],$mobile_no,$otpmsg);
								$otpid = $this->dynamic_model->updateRowWhere($this->db->dbprefix.'Users_Otp_Verification',$wh,$otpdetail);


							$data_val[]  = array('user_id'=>"$user_id",'otp'=>$otpnumber,'varification_type'=>0);

							$arg['status']    = 1;
							$arg['errorcode'] = REST_Controller::HTTP_OK;
						 	$arg['message']   = $this->lang->line('thank_msg');
						 	$arg['data']      = $data_val;
						}
						else
						{
							$arg['status']    = 0;
							$arg['errorcode'] = REST_Controller::HTTP_OK;
						 	$arg['message']   = $this->lang->line('already_register');
						 	$arg['data']      = array();
						}
				    }
				    else
				    {
				    	if(!empty($email))
				    	{
					    	//check email is already exist or not?
							$cond = array(
										'email' => @$email
									);
							$email_exist = getdatafromtable($this->db->dbprefix.'Users', $cond);
						}
						else
						{
							$email_exist = "";
						}
						if(empty($email_exist))
						{
				    		//function used for QRCode
							$qr_number = generateQrcode($mobile_no);

							$userdata = array(
											   	'firstname'  	=> $firstname,
											   	'lastname'   	=> $lastname,
											    'password'   	=> $hashed_password,
											    'email'      	=> $email,
											    'mobile_no'  	=> $mobile_no,
											    'qr_code'    	=> $qr_number,
											    'profile_pic' 	=> 'default.png',
											    'role_id'     	=> 2
										);
							$newuserid = $this->dynamic_model->insertdata($this->db->dbprefix.'Users', $userdata);
							$ref_num   = getuniquenumber();
					        if($newuserid)
					        {
								$otpnumber = generate_Pin();
					        	//$otpnumber = '345645';
								//$otpmsg = "Your OtP is $otpnumber";
								$otpmsg = "Use $otpnumber as one time password (OTP) for mobile varification to your ipant account. Do not share this OTP to anyone for security reasons.";
								//sendSms($this->input->post('mobile_no'), $otpmsg);
								$otpdetail = array(
							       	'mobile_number' => $mobile_no,
							       	'otp' => $otpnumber,
							       	'otp_type' => 0,
							       	'user_id' => $newuserid
								);
								$condition1 = array('id' => $newuserid);
								$result1    = getdatafromtable($this->db->dbprefix.'Users', $condition1);
								pilvo_sms($result1[0]['country_code'],$mobile_no,$otpmsg);
								$otpid = $this->dynamic_model->insertdata($this->db->dbprefix.'Users_Otp_Verification', $otpdetail);

								$data_val[]  = array('user_id'=>"$newuserid",'otp'=>$otpnumber,'varification_type'=>0);
								// $enc_user = encode($newuserid);
								// $url      = base_url().'webservices/users/varify_user?userid='.$enc_user ;

								// $data['subject']     = 'Registration Successful'; 
								// $data['description'] = "Thank You, <a href='".$url."'> Click Here </a>To Activate Your Account.";
								// $data['body']        = "";
								// $msg = $this->load->view('emailtemplate', $data, true);
								// $this->sendmail->sendmailto($email,'Verify Email From Bizxpay', "$msg");

								$arg['status']    = 1;
								$arg['errorcode'] = REST_Controller::HTTP_OK;
							 	$arg['message']   = $this->lang->line('thank_msg');
							 	$arg['data']      = $data_val;
					        }
					    }
					    else
					    {
					    	$arg['status']    = 0;
							$arg['errorcode'] = REST_Controller::HTTP_OK;
						 	//$arg['message']   = "Email address already exist.";
						 	$arg['message']   = "E-postadress finns redan.";
						 	$arg['data']      = array();
					    }
				    }
				}
			}
			echo json_encode($arg);
		}
	}

	//Used function for varify otp 
	public function varify_otp_post()
	{
		$arg = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{
				$this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
				$this->form_validation->set_rules('otp', 'OTP','required|max_length[6]|numeric', array( 'required' => $this->lang->line('otp_required'), 'max_length' => $this->lang->line('otp_max_length'), 'numeric' => $this->lang->line('otp_numeric')
				));
				$this->form_validation->set_rules('varification_type', 'Varification Type', 'required|numeric|less_than[2]', array('less_than' => $this->lang->line('verification_type_0_1')));

				if ($this->form_validation->run() == FALSE)
				{
				  	$arg['status']  = 0;
				  	$arg['message'] =  get_form_error($this->form_validation->error_array());
				} 
				else
				{
					$user_id = $this->input->post('user_id');
					$otp     = $this->input->post('otp');
					$varification_type = $this->input->post('varification_type');

					$condition = array(
								'user_id' => $user_id,
								'otp' => $otp,
						       	'otp_type' => $varification_type
							);
					$result = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition);
					if($result)
					{
						$condition = array(
							'mobile_number' => $result[0]['mobile_number'],
						);
						$forgotid = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition, 'id');

						$where1 = array(
									'mobile_no' => $result[0]['mobile_number']
								);
						$data = array(
									'is_profile_complete' => "1",
									'status' => "1"
								);
						$varify = $this->dynamic_model->updateRowWhere($this->db->dbprefix.'Users', $where1, $data);

						$data_val[] = array('user_id'=>$user_id,'varification_type'=>$varification_type);
						$arg['status']     = 1;
						if($varification_type == 1)
						{
				  			$arg['message']    = $this->lang->line('varify_success');
				  		}
				  		else
				  		{
				  			$arg['message']    = $this->lang->line('varify_success_signup');
				  		}
				  		$arg['errorcode']  = REST_Controller::HTTP_OK;
						$arg['data']       = $data_val;
					}
					else
					{
						$arg['status']     = 0;
				  		$arg['message']    = $this->lang->line('otp_not_match');
				  		$arg['errorcode']  = REST_Controller::HTTP_OK;
						$arg['data']       = array();
					}
				}
			}
			echo json_encode($arg);
		}
	}

	//Used function for resend otp 
	public function resend_otp_post()
	{
		$arg   = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{
				$this->form_validation->set_rules('mobile_no', 'Mobile', 'required|min_length[9]|max_length[10]|numeric', array(
					'required' => $this->lang->line('mobile_required'),
					'min_length' => $this->lang->line('mobile_min_length'),
					'max_length' => $this->lang->line('mobile_max_length'),
					'numeric' => $this->lang->line('mobile_numeric')
				));
				$this->form_validation->set_rules('varification_type', 'Varification Type', 'required|numeric|less_than[2]', array('less_than' => 'Varification Type between 0 to 1'));

				if ($this->form_validation->run() == FALSE)
				{
				  	$arg['status']  = 0;
				 	$arg['message'] = get_form_error($this->form_validation->error_array());
				}
				else
				{
					$mobile_no= $this->input->post('mobile_no');
					$varification_type= $this->input->post('varification_type');
					$condition = array(
						'mobile_number' => $mobile_no,
						'otp_type' => $varification_type
					);
					$result = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition);
                 
                    $otpnumber = generate_Pin();
					//$otpnumber = '345645';
					//$otpmsg = "Your Otp is $otpnumber";
					if($varification_type == 0){
						$otpmsg = "Use $otpnumber as one time password (OTP) for mobile varification to your ipant account. Do not share this OTP to anyone for security reasons.";
					}else{
						$otpmsg = "Use $otpnumber as one time password (OTP) for forgot password to your ipant account. Do not share this OTP to anyone for security reasons.";
					}
				    $condition1 = array(
						'mobile_no' => $mobile_no	
					);
				    $user_data = getdatafromtable($this->db->dbprefix.'Users', $condition1);
					pilvo_sms($user_data[0]['country_code'],$mobile_no,$otpmsg);
					$otpdetail = array(
						       	'mobile_number' => $mobile_no,
						       	'otp' => $otpnumber,
						       	'otp_type' => $varification_type,
						       	'user_id' => $user_data[0]['id']
							); 

					if($result)
					{
						$otpid = $result[0]['user_id'];
		                $wheres = array("user_id" => $otpid,'otp_type' =>$this->input->post('varification_type'));
		                $updated_token = update_data($this->db->dbprefix."Users_Otp_Verification", $otpdetail, $wheres);
					}
					else
					{
						$otpid = $this->dynamic_model->insertdata($this->db->dbprefix.'Users_Otp_Verification', $otpdetail);
					}

			        if($otpid)
			        {
			        	$data_val[]       = array('user_id'=>$otpid,'otp'=>$otpnumber,'varification_type'=>$this->input->post('varification_type'));
			        	$arg['status']    = 1;
			        	$arg['errorcode'] = REST_Controller::HTTP_OK;
					 	$arg['data']      = $data_val;
					 	$arg['message']   = $this->lang->line('otp_send');
			        }
				}
			}
			echo json_encode($arg);
		}
	}

	//Used function for Login function 
	public function login_post()
	{
		$arg = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{
				$this->form_validation->set_rules('password', '', 'required|min_length[6]|max_length[12]', array(
						'required' => $this->lang->line('password_required'),
						'min_length' => $this->lang->line('password_minlength'),
						'max_length' => $this->lang->line('password_maxlenght')
					));
				if ($this->form_validation->run() == FALSE)
				{
				  	$arg['status']  = 0;
				  	$arg['message'] = get_form_error($this->form_validation->error_array());
				}
				else
				{
					$varify = 0;
					if($this->input->post('mobile_no') != '')
					{
						$data = $this->dynamic_model->checkMobile($this->input->post('mobile_no'));
					}
					else if($this->input->post('email') != '')
					{
						$data = $this->dynamic_model->checkEmail($this->input->post('email'));
					}

					if(!empty($data))
					{
						$hashed_password = encrypt_password($this->input->post('password'));
						if($hashed_password == $data[0]['password'])
						{
							$userid = $data[0]['id'];
							$condi  = array(
										    	'id' => $userid
										    );
							$userinfo = getdatafromtable($this->db->dbprefix.'Users', $condi);
							if($data[0]['is_profile_complete'] == 1)
					     	{
								if($data[0]['status'] == 1)
								{
									//$user_id  = $data[0]['user_id'];
									$emailid  = $data[0]['email'];
								    $token    = uniqid();

									$device_id   = $this->input->get_request_header('device_id');
				                    $device_type = $this->input->get_request_header('device_type');

									$where = array('email' => $emailid);
									$tokenupdate = array(
										'token' => $token,
										'device_id' => $device_id,
										'device_type' => $device_type
									);
									$varify = $this->dynamic_model->updateRowWhere($this->db->dbprefix.'Users', $where, $tokenupdate);

									// Function for add login data in table
									$user_os        = getOS();
									$user_browser   = getBrowser();
									$device_details = "".$user_browser." on ".$user_os."";

									$co = ip_info("Visitor", "Country"); // India
									$cc = ip_info("Visitor", "Country Code"); // IN
									$ca = ip_info("Visitor", "Address"); // Proddatur, Andhra Pradesh, India
									//$ip = $_SERVER['REMOTE_ADDR'];
									$ip  = $_SERVER['HTTP_HOST'];
									$ua  = $_SERVER['HTTP_USER_AGENT'];
									$loc = "$ca ($cc)";

									$logindata = array(
												'user_id'     => $userid,
										        'ip_address'   => $ip,
										        'location' =>$loc,
										        'user_os_platform'=>$device_details
										    );
									$loginid = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Logins', $logindata);

									$tokendata = array(
										    	'userid' => $userid,
										    	'token' => $token,
										    	'status' => $data[0]['status'],
										    	//'registration_type' => $data[0]['registration_type'],
										    );

								    $user_token = base64_encode( json_encode( $tokendata ) ); 
								    $userdata = array(
										    	'Authorization' => $user_token,
										    	'email' => $data[0]['email'],
										    	'mobile_no' => $data[0]['mobile_no'],
										    	'firstname' => $userinfo[0]['firstname'],
										    	'lastname' => $userinfo[0]['lastname'],
										    	'wallet_balance' => $userinfo[0]['current_wallet_balance'],
										    	'qr_code' => site_url().'uploads/coupon_qr/'.$userinfo[0]['qr_code'].'.png',
										    	'profile_pic' => site_url().'uploads/user/'.$userinfo[0]['profile_pic'],
										    	'is_logged_in' => $userinfo[0]['is_logged_in'],										    	
										    	'is_profile_complete' => $data[0]['is_profile_complete'] =='1' ? "1" : "0",
										    	'gift_card_number' => (!empty($data[0]['gift_card_number'])) ? $data[0]['gift_card_number'] : ""
										    );

									$arg['status']     = 1;
									$arg['errorcode']  = REST_Controller::HTTP_OK;
									$arg['message']    = $this->lang->line('login_success');
									$arg['data'][]     = $userdata;
								}
								else
								{
				  					$arg['status']    = 0;
					  				$arg['message']   = $this->lang->line('user_block');
					  				$arg['errorcode'] = REST_Controller::HTTP_OK;
					  				$arg['data']      = array();
				  				}
	                        }
	                        else
	                        {
	                            $userdata = array(
									    	'userid' => $userid,
									    	'email' => $data[0]['email'],
									    	'mobile_no' => $data[0]['mobile_no'],
									    	'firstname' => $userinfo[0]['firstname'],
									    	'lastname' => $userinfo[0]['lastname'],
									    	'wallet_balance' => $userinfo[0]['current_wallet_balance'],
									    	'qr_code' => site_url().'uploads/coupon_qr/'.$userinfo[0]['qr_code'].'.png',
									    	'profile_pic' => site_url().'uploads/user/'.$userinfo[0]['profile_pic'],
									    	'is_logged_in' => $userinfo[0]['is_logged_in'],
									    	'is_profile_complete' => $data[0]['is_profile_complete'] =='1' ? "1" : "0",
									    );

	                            $arg['status']     = 0;
								$arg['errorcode']  = REST_Controller::HTTP_OK;
								$arg['message']    = $this->lang->line('profile_not_varify');
								$arg['data'][]     = $userdata;
	                        }
						}
						else
						{
							$arg['status']    = 0;
			  				$arg['message']   = $this->lang->line('password_notmatch');
			  				$arg['errorcode'] = REST_Controller::HTTP_OK;
			  				$arg['data']      = array();
						}
					}
					else
					{
						$arg['status']    = 0;
						$arg['message']   = $this->lang->line('register_first');
						$arg['errorcode'] = REST_Controller::HTTP_OK;
						$arg['data']      = array();
					}
				}
			}
			echo json_encode($arg);
		}
	}

	//Used function for logout function 
	public function logout_get()
	{
		$arg = array();
		$arg['status']     = 1;
		$arg['errorcode']  = REST_Controller::HTTP_OK;
		$arg['message']    = check_authorization('logout');
		$arg['data']       = array();
		echo json_encode($arg);
	}

	//Used function for reset password function 
	public function reset_password_post()
	{
		$arg   = array();
		$_POST = json_decode(file_get_contents("php://input"), true);
		if($_POST)
		{
			$version_result = version_check_helper1();
			if($version_result['status'] != 1 )
			{
				$arg = $version_result;
			}
			else
			{
				$this->form_validation->set_rules('user_id', 'User ID', 'required');
				$this->form_validation->set_rules('new_password', 'New Password', 'required', array('required' => $this->lang->line('new_password')));
				if ($this->form_validation->run() == FALSE)
				{
				  	$arg['status']  = 0;
				 	$arg['message'] = get_form_error($this->form_validation->error_array());
				}
				else
				{
					$condition = array(
						'id' => $this->input->post('user_id')
					);
					$temp_id = getdatafromtable($this->db->dbprefix.'Users_Otp_Verification', $condition, "mobile_number");

					$where = array(
						'mobile_no' => $temp_id[0]['mobile_number']
					);
					$data = array(
						'password' => encrypt_password($this->input->post('new_password'))
					);
					$this->dynamic_model->updateRowWhere($this->db->dbprefix.'Users', $where, $data);

					$arg['status']    = 1;
					$arg['errorcode'] = REST_Controller::HTTP_OK;
				 	$arg['message']   = $this->lang->line('reset_password');
				 	$arg['data']      = array();
				}
			}
			echo json_encode($arg);
		}
	}

	//Used function for change password
	public function changepassword_put()
	{
		$arg    = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 )
		{
			$arg = $version_result;
		}
		else
		{
			$result = check_authorization();
			if($result != 'true')
			{
				$arg['status']  = STATUS_AUTHORIZATION_CODE;
				$arg['error']   = ERROR_AUTHORIZATION_CODE;
				$arg['errorcode']   = REST_Controller::HTTP_UNAUTHORIZED;
				$arg['message'] = $result;
			}
			else
			{
				$_POST = $this->put();			 
				if($_POST)
				{
					$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required', array(
						'required' => $this->lang->line('old_password')
					));
					$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[12]', array(
						'required' => $this->lang->line('new_password'),
						'min_length' => $this->lang->line('password_minlength'),
						'max_length' => $this->lang->line('password_minlength')
					));
					if ($this->form_validation->run() == FALSE)
					{
						$arg['status']  = 0;
						$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						$auth_token = $this->input->get_request_header('Authorization');
		    			$user_token = json_decode(base64_decode($auth_token));
		    			
						$usid =  $user_token->userid;

						$where1  = array("id" => $usid);
						$loguser = $this->dynamic_model->getdatafromtable($this->db->dbprefix."Users", $where1);
						//$loguser = $this->dynamic_model->get_user_by_id($usid);

						$hashed_password = encrypt_password($this->input->post('old_password'));
						if($hashed_password == $loguser[0]['password'])
						{
							// $data1 = array(
							// 	'password' => encrypt_password($this->input->post('new_password')),
							// 	'token' => ''
							// );
							$data1 = array(
								'password' => encrypt_password($this->input->post('new_password'))
								//'token' => ''
							);
			                $where     = array("email" => $loguser[0]['email']);
			                $keyUpdate = $this->dynamic_model->updateRowWhere($this->db->dbprefix."Users", $where, $data1); 
			                if($keyUpdate) {
			                	$arg['status']    = 1;
			                	$arg['errorcode'] = REST_Controller::HTTP_OK;
								$arg['message']   = $this->lang->line('password_change_success');
								$arg['data']      = array();
			                }
			                else
			                {
			                	$arg['status']    = 0;
				                $arg['errorcode'] = REST_Controller::HTTP_NOT_MODIFIED;
								$arg['message']   = $this->lang->line('password_not_update'); 
								$arg['data']      = array();
			                }
						}
						else
						{
							$arg['status']    = 0;
			                $arg['errorcode'] = REST_Controller::HTTP_NOT_MODIFIED;
							$arg['message']   = $this->lang->line('old_password_not'); 
							$arg['data']      = array();
						}
					}
				}
			}
		}
		echo json_encode($arg);
	}

	//Used function to get profile details
	public function get_profile_get()
	{
		$arg = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 )
		{
			$arg = $version_result;
		}
		else
		{
			$result = check_authorization();
			if($result != 'true')
			{
				$arg['status']    = STATUS_AUTHORIZATION_CODE;
				$arg['error']     = ERROR_AUTHORIZATION_CODE;
				$arg['errorcode'] = REST_Controller::HTTP_UNAUTHORIZED;
				$arg['message']   = $result;
			}
			else
			{
				$auth_token = $this->input->get_request_header('Authorization');
		    	$user_token = json_decode(base64_decode($auth_token));

				$usid      = $user_token->userid;
				$where1    = array("id" => $usid);
				$userdata1 = $this->dynamic_model->getdatafromtable($this->db->dbprefix."Users", $where1);

				$condi = array(
			    	'id' => $userdata1[0]['id']
			    );
				$userinfo = getdatafromtable('Users', $condi);
				if($userinfo)
				{
					$condi = array(
				    	'code' => $userinfo[0]['country_code']
				    );
					$country_name = getdatafromtable($this->db->dbprefix.'Countries', $condi, 'name');

					$userdata[] = array(
								    	'Authorization' => $auth_token,
								    	'email' => $userinfo[0]['email'],
								    	'mobile_no' => $userinfo[0]['mobile_no'],
								    	'firstname' => $userinfo[0]['firstname'],
								    	'lastname' => $userinfo[0]['lastname'],
								    	'familyname' => $userinfo[0]['familyname'],
								    	'address'   => $userinfo[0]['address'],
								    	'wallet_balance' => $userinfo[0]['current_wallet_balance'],
								    	'qr_code' => site_url().'uploads/coupon_qr/'.$userinfo[0]['qr_code'].'.png',
								    	'profile_pic' => site_url().'uploads/user/'.$userinfo[0]['profile_pic']
									    );

					$arg['status']     = 1;
					$arg['errorcode']  = REST_Controller::HTTP_OK;
					$arg['data']       = $userdata;
					$arg['message']    = "";
				}
				else
				{
					$arg['errorcode']  = REST_Controller::HTTP_OK;
					$arg['data']       = array();
					$arg['status']     = 0;
					$arg['message']    = $this->lang->line('record_not_found');
				}
			}
		}
		echo json_encode($arg);
	}

	//Function used for update profile
	public function profile_update_post()
	{
		$arg    = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 ){
			$arg = $version_result;
		}else{
		$result = check_authorization();
		if($result != 'true') {
			$arg['status']  = STATUS_AUTHORIZATION_CODE;
			$arg['errorcode']   = REST_Controller::HTTP_UNAUTHORIZED;
			$arg['error']   = ERROR_AUTHORIZATION_CODE;
			$arg['message'] = $result;
		}else{
			$this->form_validation->set_rules('firstname', 'First Name', 'required', array( 'required' => $this->lang->line('first_name')));
			$this->form_validation->set_rules('lastname', 'Last Name', 'required', array( 'required' => $this->lang->line('last_name')));

			if ($this->form_validation->run() == FALSE) {
			  	$arg['status']  = 0;
				$arg['message'] = get_form_error($this->form_validation->error_array());
			} else {
				$userdata = array();
				if(!empty($_FILES['profile_image']['name'])){
					$profile_image = $this->dynamic_model->fileupload('profile_image', 'uploads/user');
					$userdata['profile_pic'] = $profile_image;
				}

				$userdata['firstname']      = $this->input->post('firstname');
				$userdata['lastname']       = $this->input->post('lastname');
				$userdata['familyname']     = $this->input->post('familyname');
				$userdata['address']        = $this->input->post('address');
				
				$auth_token = $this->input->get_request_header('Authorization');
		    	$user_token = json_decode(base64_decode($auth_token));

				$usid   = $user_token->userid;
				$where1 = array("id" => $usid);
				$info   = $this->dynamic_model->getdatafromtable($this->db->dbprefix."Users", $where1);

				$where = array(
				    	'id' => $info[0]['id']
				    );
				$updatedata = update_data("Users",$userdata, $where);
				if($updatedata)
				{
					$condi = array(
					    		'id' => $info[0]['id']
					    	);
					$userinfo = getdatafromtable('Users', $condi);
					$condi = array(
			    			'code' => $userinfo[0]['country_code']
				    );
					$country_name = getdatafromtable($this->db->dbprefix.'Countries', $condi, 'name');
					$userdata1[] = array(
								    	'Authorization' => $auth_token,
								    	'email' => $userinfo[0]['email'],
								    	'mobile_no' => $userinfo[0]['mobile_no'],
								    	'firstname' => $userinfo[0]['firstname'],
								    	'lastname' => $userinfo[0]['lastname'],
								    	'familyname' => $userinfo[0]['familyname'],
								    	'address'    => $userinfo[0]['address'],
								    	'wallet_balance' => $userinfo[0]['current_wallet_balance'], 
								    	'qr_code' => site_url().'uploads/coupon_qr/'.$userinfo[0]['qr_code'].'.png',
								    	'profile_pic' => site_url().'uploads/user/'.$userinfo[0]['profile_pic']
								    );

					$arg['status']    = 1;
					$arg['errorcode'] = REST_Controller::HTTP_OK;
			  		$arg['message']   = $this->lang->line('profile_update');
			  		$arg['data']      = $userdata1;
			  	}else{
			  		$arg['status']    = 0;
					$arg['errorcode'] = REST_Controller::HTTP_NOT_MODIFIED;
			  		$arg['message']   = $this->lang->line('profile_notupdate');
			  		$arg['data']      = array();
			  	}
			}
		}

	  }
		echo json_encode($arg);
	}

	//Function used for user is exist or not
	public function userExist_post()
	{
		$arg = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 )
		{
			$arg = $version_result;
		}
		else
		{
			$result = check_authorization();
			if($result != 'true')
			{
				$arg['status']    = STATUS_AUTHORIZATION_CODE;
				$arg['error']     = ERROR_AUTHORIZATION_CODE;
				$arg['errorcode'] = REST_Controller::HTTP_UNAUTHORIZED;
				$arg['message']   = $result;
			}
			else
			{
				$_POST = json_decode(file_get_contents("php://input"), true);
				if($_POST)
				{
					$this->form_validation->set_rules('emailMobile', '', 'required');
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						$device_type = $this->input->get_request_header('device_type');
						$mobileEmail = $this->input->post('emailMobile');
						$Amt         = $this->input->post('amount');
						$amount      = (!empty($Amt)) ? $Amt : '0.00';
				        $usid        = getuserid();
						$loguser     = $this->dynamic_model->get_user_by_id($usid);
				        $usermail    = isset($loguser['email']) ? $loguser['email'] : '';
				        $usermobile  = $loguser['mobile_no'];
				        $sendername  = $loguser['firstname'].' '.$loguser['lastname'];

				        if($usermobile == $mobileEmail OR $usermail == $mobileEmail )
				        {
				        	$arg['status']  = 0;
						  	$arg['message'] = 'Du kan inte skicka pengar till dig själv';
				        }
				        else
				        {
					        if($mobileEmail != "")
					        {
								$userDetail = $this->dynamic_model->check_userdetails($mobileEmail);
								if($userDetail) {
									$profilepic    = isset($userDetail['profile_pic']) ? $userDetail['profile_pic'] : 'default.png';
					            	$profile_image = site_url().'uploads/user/'. $profilepic;

					            	$userinfo[] = array(
					            		'id'            => $userDetail['id'],
					            		'firstname'     => $userDetail['firstname'],
					            		'role_id'       => $userDetail['role_id'],
					            		'lastname'      => $userDetail['lastname'],
					            		'profile_image' => $profile_image
					            	);

				            		$arg['status']    = 1;
				            		$arg['errorcode'] = REST_Controller::HTTP_OK;
					  				$arg['data']      = $userinfo;
					  				$arg['message']   = '';
								} else {
		                            $notification_title = 'Pengarna har inte överförts. En länk till iPANT har skickats till motagaren';
									//message to receiver
									$ioslink="https://apps.apple.com/se/app/ipant/id1481434426";
									$androidlink="https://play.google.com/store/apps/details?id=com.ipant&gl=SE";
									$Receivermsg = "$sendername försöker skicka dig $amount kr. Vänligen ladda ner iPANT.$androidlink
									$ioslink";

									pilvo_sms('+46',$mobileEmail,$Receivermsg);
									
									$arg['status']    = 0;
							  		$arg['message']   =  $notification_title;
							  		$arg['errorcode'] = REST_Controller::HTTP_OK;
					  				$arg['data']      = array();
								} 
					        }
					        else 
					        {
					        	$arg['status']    = 0;
							  	$arg['message']   = $this->lang->line('invalid_detail');
							  	$arg['errorcode'] = REST_Controller::HTTP_OK;
					  			$arg['data']      = array();
					        }
					    }
				    }
			    }
			}
		} 
		echo json_encode($arg);
    }

    //Function used for Get Notification List 
    public function get_notification_list_post()
    {
    	$arg = array();
    	$version_result = version_check_helper1();
		if($version_result['status'] != 1 )
		{
			$arg = $version_result;
		}
		else
		{
			$result = check_authorization();
			if($result != 'true')
			{
				$arg['status']    = STATUS_AUTHORIZATION_CODE;
				$arg['error']     = ERROR_AUTHORIZATION_CODE;
				$arg['errorcode'] = REST_Controller::HTTP_UNAUTHORIZED;
				$arg['message']   = $result;
			}
			else
			{
		    	$_POST = json_decode(file_get_contents("php://input"), true);
				if($_POST) {
					$this->form_validation->set_rules('page_no', 'Page No', 'required|numeric',array(
						'required'   => $this->lang->line('page_no'),
						'numeric'    => $this->lang->line('page_no_numeric')
					));
					if ($this->form_validation->run() == FALSE) {
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}  else {
						$arg      = array();
						$userid   = getuserid();
						$loguser  = $this->dynamic_model->get_user_by_id($userid);
						$limit    = config_item('page_data_limit');
						$offset   = $limit * $this->input->post('page_no');

						$notification_data = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'User_Notifications', array('recepient_id'=>$userid) , '*', $limit, $offset,'Id');
						if(!empty($notification_data)) {
							$user_data = array();
							foreach($notification_data as $details) {
	            				$user_data["id"]                 = $details['id'];
	            				$name                            = $loguser['firstname'].' '.$loguser['lastname'];
	            				$user_data["notification_text"]  = str_replace('*USERNAME*',$name,$details['notification_text']);
	            				$user_data["tran_type_id"]       = $details['tran_type_id'];
	            				$user_data["read"]               = $details['is_read'];
	            				$user_data['created_at']         = date('d M Y', strtotime($details['read_date_time']));
	            				$user_data['time']               = date('g:i A',strtotime($details['read_date_time']));
	            				$notification_array[]            = $user_data;
		            		}

							$arg['status']     = 1;
							$arg['errorcode']  = REST_Controller::HTTP_OK;
							$arg['data']       = $notification_array;
							$arg['message']    = "Notification List";
						} else {
							$arg['status']     = 0;
							$arg['errorcode']  = REST_Controller::HTTP_NOT_FOUND;
			            	$arg['message']    = $this->lang->line('record_not_found');
			            	$arg['data']       = array();
						}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}

	//Used function to get current wallet balance
	public function get_wallet_balance_get()
	{
		$arg = array();
		$version_result = version_check_helper1();
		if($version_result['status'] != 1 )
		{
			$arg = $version_result;
		}
		else
		{
			$result = check_authorization();
			if($result != 'true')
			{
				$arg['status']    = STATUS_AUTHORIZATION_CODE;
				$arg['error']     = ERROR_AUTHORIZATION_CODE;
				$arg['errorcode'] = REST_Controller::HTTP_UNAUTHORIZED;
				$arg['message']   = $result;
			}
			else
			{
				$auth_token = $this->input->get_request_header('Authorization');
		    	$user_token = json_decode(base64_decode($auth_token));

				$usid      = $user_token->userid;
				$where1    = array("id" => $usid);
				$userdata1 = $this->dynamic_model->getdatafromtable($this->db->dbprefix."Users", $where1);

				if($userdata1)
				{
					$arg['status'] = 1;
					$arg['errorcode']  = REST_Controller::HTTP_OK;
					$arg['message'] = "";
				 	$arg['data'][]['current_wallet_balance']  = $userdata1[0]['current_wallet_balance'];
				}
				else
				{
					$arg['status']    = 0;
					$arg['errorcode'] = REST_Controller::HTTP_NOT_FOUND;
					$arg['message']   = $this->lang->line('record_not_found');
				 	$arg['data']      = array();
				}
			}
		}
		echo json_encode($arg);
	}
	public function get_gift_card_balance_post(){
		//$card_number='9752257840738501';
		$card_number='9752257847986880';
		$amount='1.00';
		$card_data=get_gift_card_balance($card_number);
		$balance_data= json_decode($card_data);
		
		//echo "<pre>";print_r($balance_data);die;
		if(!empty(@$balance_data->faultstring)){
			//echo 1;die;
			echo @$balance_data->faultstring;die;
		}else{
			$balance_data->balanceResult->balance;
		   $balance_data->balanceResult->expireDate;
		
		echo "<pre>";print_r($balance_data);die;
	  }
		 
		//$load_data= load_card_balance($card_number,$amount)
        //$load_data_arr= json_decode($load_data);
		
		//$load_data_arr->loadResult->currentAmount;
		//$load_data_arr->loadResult->authorizationId;
	}
   // For cron job
    public function sync_gift_card_amount_balance_get()
    { 
        $user_data = $this->dynamic_model->getdatafromtable($this->db->dbprefix."Users",array("role_id !="=>1));
        //echo "<pre>";print_r($user_data);die;

        if(!empty($user_data))
        {
            foreach($user_data as $value) 
            {
	            $user_id=$value['id'];
	            $gift_card_number=$value['gift_card_number'];
	            $card_data=get_gift_card_balance($gift_card_number);
		        $balance_data= json_decode($card_data);
	           if(!empty(@$balance_data->faultstring)){
						//echo 1;die;
						//echo @$balance_data->faultstring;die;
			    }else{
						 $current_amt= $balance_data->balanceResult->balance;
                         $wh = array('id' =>$user_id,'gift_card_number'=> $gift_card_number);
				         $update_user_data = array(
					     'current_wallet_balance' =>$current_amt
				   );
				        //$this->dynamic_model->updateRowWhere('users',$wh,$update_user_data);
				}    
            }       
        } 
        else
        {
           return false;
        }
    }
    // Function used for contact us
	public function contact_us_get()
	{
		$arg = array();
		$arg['status']  = 1;
		$arg['errorcode']  = REST_Controller::HTTP_OK;
		$arg['data'][]    = array(
		"callus"  => get_options('contactphone'),
		"emailus" => get_options('contactemail'),
		"website" =>get_options('contactwebsite')
		);
		$arg['message'] = "";
		echo json_encode($arg);
	}
	 // Function name(faq)
    public function faq_get()
    {
    	$language = $this->input->get_request_header('language');
    	$arg = array();
        $arg['status'] = 1;
        $arg['error_code']  = REST_Controller::HTTP_OK;
		$arg['message'] = "";
        $arg['data'][]   = array('url' => site_url().'Welcome/faq/'.$language);
        echo json_encode($arg);
    } 



}