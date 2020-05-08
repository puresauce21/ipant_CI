<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';


class Depositmoney extends REST_Controller {
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

	public function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json');
		$this->load->library('form_validation');
		$this->load->model('dynamic_model');
        error_reporting(0); 
		$language = $this->input->get_request_header('language');
		// if($language == "en")
		// {
		// 	$this->lang->load("message","english");
		// }
                log_message('info',"language==================".$language);
		if($language == "sw")
		{
			$this->lang->load("message","swedish");
		}
		else
		{
			$this->lang->load("message","english");
		}
	}

    //Function used for add money
    public function addMoney_post()
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
					$arg = array();
					$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]',array(
						'required'     => $this->lang->line('amount_req'),
						'numeric'      => $this->lang->line('amount_numeric'),
						'greater_than' => $this->lang->line('amount_greater_than')
					));
					/*$this->form_validation->set_rules('pin', 'Transaction pin', 'required|min_length[4]|max_length[4]|numeric',array(
							'required'    => $this->lang->line('pin_require'),
							'numeric'     => $this->lang->line('pin_numeric'),
							'min_length'  => $this->lang->line('pin_length'),
							'max_length'  => $this->lang->line('pin_length')
						));*/
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						/*
							add_money_method = 1 means Debit card
				        	add_money_method = 2 means Credit card 
				        	add_money_method = 4 means Saved card details
				     	*/
				        $add_money_method = $this->input->post('add_money_method');
				        $amount           = $this->input->post('amount');
				        $charge           = $this->input->post('charge');
				        $ref_num          = getuniquenumber();

				        //Check Transaction Password
						$userid    = getuserid();
						$loguser   = $this->dynamic_model->get_user_by_id($userid);

				        // Use these function for Debit or Credit card method
				        if($add_money_method == 1 || $add_money_method == 2)
				        {
	        				$this->form_validation->set_rules('security_code', 'Security Code', 'required|numeric|min_length[3]|max_length[3]',array(
									'required'   => $this->lang->line('security_code_required'),
									'min_length' => $this->lang->line('security_code_min_length'),
									'max_length' => $this->lang->line('security_code_max_length'),
									'numeric'    => $this->lang->line('security_code_numeric')
								));
							$this->form_validation->set_rules('card_number', 'Card Number', 'required|numeric|min_length[16]|max_length[16]',array(
								'required'   => $this->lang->line('card_required'),
								'min_length' => $this->lang->line('card_min_length'),
								'max_length' => $this->lang->line('card_max_length'),
								'numeric'    => $this->lang->line('card_numeric')
							));
				        	$this->form_validation->set_rules('expiry_month', 'Expiry Month', 'required|less_than_equal_to[12]|greater_than[0]',array('required'=> $this->lang->line('expiry_month_required'),
								'min_length' => $this->lang->line('expiry_month_min_length'),
								'less_than_equal_to' => $this->lang->line('expiry_month_less_than_equal_to'),
								'greater_than' => $this->lang->line('expiry_month_greater_than'),
								'numeric' => $this->lang->line('expiry_month_numeric')
							));
				        	$this->form_validation->set_rules('expiry_year', 'Expiry Year', 'required|numeric|min_length[4]|max_length[4]',array(
								'required'   => $this->lang->line('expiry_year_required'),
								'min_length' => $this->lang->line('expiry_year_min_length'),
								'max_length' => $this->lang->line('expiry_year_max_length'),
								'numeric'    => $this->lang->line('expiry_year_numeric')
							));
				        }
				        // Use these function for Saved card details method
				        if($add_money_method == 4)
				        {
				        	$this->form_validation->set_rules('security_code', 'Security Code', 'required|numeric|min_length[3]|max_length[3]',array(
									'required'   => $this->lang->line('security_code_required'),
									'min_length' => $this->lang->line('security_code_min_length'),
									'max_length' => $this->lang->line('security_code_max_length'),
									'numeric'    => $this->lang->line('security_code_numeric')
								));	
							$this->form_validation->set_rules('save_card_id', 'Saved Card Id', 'required|numeric',array(
								'required'   => $this->lang->line('card_id_required'),
								'numeric'    => $this->lang->line('card_id_numeric')
							));
				        }
						if ($this->form_validation->run() == FALSE)
						{
						  	$arg['status']  = 0;
						  	$arg['message'] = get_form_error($this->form_validation->error_array());
						}
						else
						{
							if($add_money_method == 1 || $add_money_method == 2)
							{
								$security_code    = $this->input->post('security_code');
					            $card_number      = $this->input->post('card_number');
					            $expiry_month     = $this->input->post('expiry_month');
					            $expiry_year      = $this->input->post('expiry_year');
					            $save_card_check  = $this->input->post('save_card_check');

			                	// $FirstFourNumber = substr($card_number, 0, 4); // get first 4
			                 //    $LastFourNumber  = substr($card_number, 12, 4); // get last 4
			                 //    $newCardNumber   = $FirstFourNumber.' XXXX XXXX '.$LastFourNumber;
			                    $newCardNumber   = $card_number;
								//$merchant_ref_num=uniqid(date('Ymd-'));
			                   
			                    // check year is valid
						        if(check_expiry_year($expiry_year) == false)
						        {
						        	$arg['status']  = 0;
			                        $arg['message'] = $this->lang->line('invalid_expiry_year');
						            echo json_encode($arg);die;
						        }

						        // check year is valid
						        if(check_expiry_month_year($expiry_month,$expiry_year) == false)
						        {
						        	$arg['status']  = 0;
			                        $arg['message'] = $this->lang->line('invalid_expiry_year_month');
						            echo json_encode($arg);die;
						        }
		                	}
				        	if($add_money_method == 4)
				        	{
				        		$commMsg       = $this->input->post('commMsg');
					            $security_code = $this->input->post('security_code');
					            $save_card_id  = $this->input->post('save_card_id');
				        	}
		                	$t = time();

		                    if($add_money_method == 1)
		                    {
		                    	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'card_bank_no'=>$newCardNumber,'is_debit_card'=>1));
		                    	if($card_Exist['is_deleted'] == 1 && @$save_card_check == 1)
		                    	{
		                    		$carddata['is_deleted'] = 0;
	    							$updatecarddata = $this->dynamic_model->updatedata($this->db->dbprefix.'User_Payment_Methods', $carddata, $card_Exist['id']);
		                    	}
		                    }
		                    if($add_money_method == 2)
		                    {
		                    	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'card_bank_no'=>$newCardNumber,'is_credit_card'=>1));
		                    	if($card_Exist['is_deleted'] == 1 && @$save_card_check == 1)
		                    	{
		                    		$carddata['is_deleted'] = 0;
	    							$updatecarddata = $this->dynamic_model->updatedata($this->db->dbprefix.'User_Payment_Methods', $carddata, $card_Exist['id']);
		                    	}
		                    }
		                    if($add_money_method == 4)
		                    {
		                    	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'id'=>$save_card_id));
		                    	
                                $expiry_month_year=explode('-',$card_Exist['expiry_month_year']);
		                    	//echo $card_Exist['card_bank_no'];exit;
		                    }
		                    if(empty($card_Exist))
		                    {
		                    	$payment_id = 0;
		                        // Use for faster checkout
		                        if(@$save_card_check == 1)
		                            $del_status = 0;
		                        else
		                            $del_status = 1;

		                        if($add_money_method == 1)
		                        {
			                        // Firstly insert data into User_Payment_Methods table
			                        $debitcardDetailArr = array(
	                                    'user_id'          =>$userid,
	                                    'card_bank_no'     =>$newCardNumber,
	                                    'expiry_month_year'=>$expiry_month.'-'.$expiry_year,
	                                    'is_debit_card'    =>1,
	                                    'is_deleted'       =>$del_status,
	                                    'created_by'       =>$userid,
	                                    'last_updated_by'  =>$userid
	                    			);
			                        $payment_id = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Payment_Methods', $debitcardDetailArr);
			                    }
			                    if($add_money_method == 2) 
			                    {
			                        // Firstly insert data into User_Payment_Methods table
			                        $creditcardDetailArr = array(
	                                    'user_id'          =>$userid,
	                                    'card_bank_no'     =>$newCardNumber,
	                                    'expiry_month_year'=>$expiry_month.'-'.$expiry_year,
	                                    'is_credit_card'   =>1,
	                                    'is_deleted'       =>$del_status,
	                                    'created_by'       =>$userid,
	                                    'last_updated_by'  =>$userid
	                    			);
			                        $payment_id = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Payment_Methods', $creditcardDetailArr);
			                    }
			                    if($add_money_method == 4)
			                    {
			                    	$arg['status']  = 0;
			                        $arg['message'] = $this->lang->line('invalid_card_id');
						            echo json_encode($arg);die;
			                    }
			                }
			                else
			                {
			                    $payment_id = $card_Exist['id'];
			                }

		                    //Then after insert into Transactions table
	                        $paymentaddArr = array(
	                            'tran_type_id'         =>2, //deposit money
	                            'to_payment_method_id' =>$payment_id,
	                            'amount'               =>$amount,
	                            'charge'               =>$charge,
	                            'to_user_id'           =>$userid,
	                            'from_user_id'         =>$userid,
	                            'tran_status_id'       =>6,
	                            'sig'                  =>'+',
	                            'amount_received'      =>$amount,
	                            //'third_party_tran_id'  =>$auth_id,
	                            'third_party_tran_id'  =>$ref_num,
	                            'merchant_ref_num'     =>$ref_num,
	                            'created_by'           =>$userid,
	                            'created_on'           => time(),
	                            'last_updated_by'      =>$userid

	                    	);
	                        $Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

	                        //Then after insert into Tran_Charges table
	                        $chargeaddArr = array(
	                            'transaction_id'  =>$Transaction_id,
	                            'charge_type_id'  =>0,
	                            'charge_amt'      =>0,
	                            'created_by'      =>$userid,
	                            'last_updated_by' =>$userid
	                    	);
	                        $Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

	                        //Update User current wallet balance
	                        $total_amount = $loguser['current_wallet_balance'] + $amount;
	                        $userbalancedata['current_wallet_balance'] = $total_amount;
	    					$updatebalancedata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userbalancedata, $userid);

	    					$update_user = $this->dynamic_model->get_user_by_id($userid);

	                        $notification_to = "";
	                        $myname          = ucfirst($loguser['firstname']);

	                        //$notification_title = 'Dear *USERNAME*,Your Money added intited and pending kr '.number_format((float)$amount, 2, '.', '').' to your wallet on '.date('d/m/Y '). ' at '.date('H:i A').' Ref.No: '.$ref_num.' Transaction cost kr 0.00';
                            $notification_title = 'Dear *USERNAME*,You have successfully added kr '.number_format((float)$amount, 2, '.', '').' to your wallet on '.date('d/m/Y '). ' at '.date('H:i A').' Ref.No: '.$ref_num.' Transaction cost kr 0.00';

	                        $notification_type = 2; // Use For Deposit Money
	                        if(!empty($User_Role['device_id']) && $User_Role['device_type'] == 'android')
	                        { 
	                            sendPushAndroid($notification_to,$notification_title, $notification_type );
	                        }
	                        if(!empty($User_Role['device_id']) && $User_Role['device_type'] == 'ios' )
	                        {
	                           sendPushIos($notification_to,$notification_title, $notification_type );
	                        }

	                        //Insert Notification
	                        $notiDataArr = array('recepient_id'=>$userid,'notification_text' =>$notification_title, 'tran_type_id' =>$notification_type) ;
	                        $insert_notification = $this->dynamic_model->insertdata('User_Notifications', $notiDataArr);

	    					$response[]    = array('amount' => number_format((float)$amount, 2, '.', ''),'transaction_date'=>get_formated_date(date('Y-m-d')),'transaction_id'=>$ref_num,'wallet_balance'=>$update_user['current_wallet_balance']);

	    					$arg['status']  = 1;
			  				$arg['message'] = $this->lang->line('addmoney_success');
			  				$arg['data']    = $response;
			  				$arg['errorcode'] = REST_Controller::HTTP_OK;
	    					//$this->response($arg,REST_Controller::HTTP_OK);
						}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}

	//Function used for send money
    public function sendMoney_post()
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
					$arg = array();
					$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
					$this->form_validation->set_rules('mobile_email','Email or Mobile','required');
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
				        /*  
							send_money_method = 1 means Debit card
				        	send_money_method = 2 means Credit card 
				        	send_money_method = 4 means Saved card details
				        	send_money_method = 5 means Wallet
				        	
				     	*/
				        $send_money_method = $this->input->post('send_money_method');
				        $use_my_wallet     = $this->input->post('use_my_wallet');
				        $charge            = $this->input->post('charge');
				        $mobile_email      = $this->input->post('mobile_email');
				        $amount            = $this->input->post('amount');
				        $comment           = $this->input->post('comment');
                                        
   

				        $ref_num           = getuniquenumber();
		                $flag=1;
	 
						$userid  = getuserid();
						$loguser = $this->dynamic_model->get_user_by_id($userid);

						if (($loguser['mobile_no'] == $mobile_email) || ($loguser['email'] == $mobile_email))
						{
		                	$arg['status']  = 0;
		                    $arg['message'] = $this->lang->line('send_request_yourself_error');
		                }
		                else
		                {
							// Use these function for Debit or Credit card method
							if($send_money_method == 1 || $send_money_method == 2)
							{
								$this->form_validation->set_rules('security_code', 'Security Code', 'required|numeric|min_length[3]|max_length[3]',array(
									'required'   => $this->lang->line('security_code_required'),
									'min_length' => $this->lang->line('security_code_min_length'),
									'max_length' => $this->lang->line('security_code_max_length'),
									'numeric'    => $this->lang->line('security_code_numeric')
								));
								$this->form_validation->set_rules('card_number', 'Card Number', 'required|numeric|min_length[16]|max_length[16]',array(
									'required'   => $this->lang->line('card_required'),
									'min_length' => $this->lang->line('card_min_length'),
									'max_length' => $this->lang->line('card_max_length'),
									'numeric'    => $this->lang->line('card_numeric')
								));
					        	$this->form_validation->set_rules('expiry_month', 'Expiry Month', 'required|numeric|less_than_equal_to[12]|greater_than[0]|min_length[2]',array('required'=> $this->lang->line('expiry_month_required'),
									'min_length' => $this->lang->line('expiry_month_min_length'),
									'less_than_equal_to' => $this->lang->line('expiry_month_less_than_equal_to'),
									'greater_than' => $this->lang->line('expiry_month_greater_than'),
									'numeric' => $this->lang->line('expiry_month_numeric')
								));
					        	$this->form_validation->set_rules('expiry_year', 'Expiry Year', 'required|numeric|min_length[4]|max_length[4]',array(
									'required'   => $this->lang->line('expiry_year_required'),
									'min_length' => $this->lang->line('expiry_year_min_length'),
									'max_length' => $this->lang->line('expiry_year_max_length'),
									'numeric'    => $this->lang->line('expiry_year_numeric')
								));
							}

							// Use these function for Saved card details method
							if($send_money_method == 4)
							{
								$this->form_validation->set_rules('security_code', 'Security Code', 'required|numeric|min_length[3]|max_length[3]',array(
									'required'   => $this->lang->line('security_code_required'),
									'min_length' => $this->lang->line('security_code_min_length'),
									'max_length' => $this->lang->line('security_code_max_length'),
									'numeric'    => $this->lang->line('security_code_numeric')
								));	
								$this->form_validation->set_rules('save_card_id', 'Saved Card Id', 'required|numeric',array(
									'required'   => $this->lang->line('card_id_required'),
									'numeric'    => $this->lang->line('card_id_numeric')
								));
							}
							if($this->form_validation->run() == FALSE)
							{
							  	$arg['status']  = 0;
							  	$arg['message'] = get_form_error($this->form_validation->error_array());
							}
							else
							{
								if($send_money_method == 1 || $send_money_method == 2)
								{
									$security_code    = $this->input->post('security_code');
						            $card_number      = $this->input->post('card_number');
						            $expiry_month     = $this->input->post('expiry_month');
						            $expiry_year      = $this->input->post('expiry_year');
						            $save_card_check  = $this->input->post('save_card_check');

						        	// $FirstFourNumber = substr($card_number, 0, 4); // get first 4
						         //    $LastFourNumber  = substr($card_number, 12, 4); // get last 4
						         //    $newCardNumber   = $FirstFourNumber.' XXXX XXXX '.$LastFourNumber;
						             $newCardNumber   = $card_number;

								
						        }
						    	if($send_money_method == 4)
						    	{
						            $security_code = $this->input->post('security_code');
						            $save_card_id  = $this->input->post('save_card_id');
						    	}
	        					$t = time();

						        if($send_money_method == 1)
						        {
						        	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'card_bank_no'=>$newCardNumber,'is_debit_card'=>1));
						        	if($card_Exist['is_deleted'] == 1 && @$save_card_check == 1)
			                    	{
			                    		$carddata['is_deleted'] = 0;
		    							$updatecarddata = $this->dynamic_model->updatedata($this->db->dbprefix.'User_Payment_Methods', $carddata, $card_Exist['id']);
			                    	}
						        }
						        if($send_money_method == 2)
						        {
						        	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'card_bank_no'=>$newCardNumber,'is_credit_card'=>1));
						        	if($card_Exist['is_deleted'] == 1 && @$save_card_check == 1)
			                    	{
			                    		$carddata['is_deleted'] = 0;
		    							$updatecarddata = $this->dynamic_model->updatedata($this->db->dbprefix.'User_Payment_Methods', $carddata, $card_Exist['id']);
			                    	}
						        }
						        if($send_money_method == 4)
						        {
						        	$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'id'=>$save_card_id));
						        }
						        if(empty($card_Exist))
						        {
						            // Use for faster checkout
						            if(@$save_card_check == 1)
						                $del_status = 0;
						            else
						                $del_status = 1;

						            if($send_money_method == 1)
						            {
										// Firstly insert data into User_Payment_Methods table
						                $debitcardDetailArr = array(
						                        'user_id'          => $userid,
						                        'card_bank_no'     => $newCardNumber,
						                        'expiry_month_year'=> $expiry_month.'-'.$expiry_year,
						                        'is_debit_card'    => 1,
						                        'is_deleted'       => $del_status,
						                        'created_by'       => $userid,
						                        'last_updated_by'  => $userid
						        			);
										$payment_id = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Payment_Methods', $debitcardDetailArr);
						            }
	        						if($send_money_method == 2)
	        						{
	        							// Firstly insert data into User_Payment_Methods table
					                    $creditcardDetailArr = array(
					                        'user_id'          =>$userid,
					                        'card_bank_no'     =>$newCardNumber,
					                        'expiry_month_year'=>$expiry_month.'-'.$expiry_year,
					                        'is_credit_card'   =>1,
					                        'is_deleted'       =>$del_status,
					                        'created_by'       =>$userid,
					                        'last_updated_by'  =>$userid
					        			);
					                    $payment_id = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Payment_Methods', $creditcardDetailArr);
									}
									if($send_money_method == 4)
				                    {
				                    	$arg['status']  = 0;
				                        $arg['message'] = $this->lang->line('invalid_card_id');
							            echo json_encode($arg);die;
				                    }
				                    
								}
								else
								{
									$payment_id = $card_Exist['id'];
								}

						        if($send_money_method == 4 || $send_money_method == 1 || $send_money_method == 2)
						        {
						        	if($use_my_wallet == "1")
						        	{
						       			//Get remaining balance
						            	$remaining_amount = $amount - $loguser['current_wallet_balance'];
						        	}
						        	else
						        	{
						        		$remaining_amount = $amount;
						        	}	
						        	//echo $remaining_amount;die;						 
									//Then after insert into Transactions table
								    $paymentaddArr = array(
								        'tran_type_id'         =>2, //deposit money
								        'to_payment_method_id' =>$payment_id,
								        'amount'               =>$remaining_amount,
								        'to_user_id'           =>$userid,
								        'from_user_id'         =>$userid,
								        'tran_status_id'       =>6,
								        'sig'                  =>'+',
								        'amount_received'      =>$remaining_amount,
								        //'third_party_tran_id'  =>$auth_id,
								        'third_party_tran_id'  =>$ref_num,
								        'merchant_ref_num'     =>$ref_num,
								        'created_by'           =>$userid,
								        'created_on'           => time(),
								        'last_updated_by'      =>$userid
									);
								    $Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

						            //Then after insert into Tran_Charges table
						            $chargeaddArr = array(
						                'transaction_id'  =>$Transaction_id,
						                'charge_type_id'  =>0,
						                'charge_amt'      =>0,
						                'created_by'      =>$userid,
						                'last_updated_by' =>$userid
						        	);
						            $Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

						            //Update User current wallet balance
						            $total_amount = $loguser['current_wallet_balance'] + $remaining_amount;
						            $userbalancedata['current_wallet_balance'] = $total_amount;
									$updatebalancedata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userbalancedata, $userid);

								}

								// NOTE :-start code for Send Money
								$response_array = array();
								$update_user    = $this->dynamic_model->get_user_by_id($userid);
						    	// Check send amount limit exceed
						    	if($amount <= $update_user['current_wallet_balance'])
								{
						            $t           = time();
									$userDetail  = $this->dynamic_model->check_userdetails($mobile_email);
                                    
						            if(!empty($userDetail))
						            {            
                                                                // charge method = FIX / FLOAT
                                                                //fee_charge = if fix(fixed amount) else in percent
                                                                $charge_detail = $this->dynamic_model->get_fees_charge();
                                                                $charge_method = $charge_detail['charge_method'];
                                                                $tran_charges = $charge_detail['charge_fee'];                                                                
                                                                $tran_charge_amount = 0;
                                                                if($tran_charges!=0){
                                                                if($charge_method=='FLOAT'){
                                                                    $tran_charge_amount = ($amount*$tran_charges)/100;
                                                                }elseif($charge_method=='FIX'){
                                                                    $tran_charge_amount = $tran_charges;
                                                                }}
                                                                $receive_amount = $amount-$tran_charge_amount;
                                                                        //
						    			/* Send money from one user to another user  */
						    			//Then after insert into Transactions table
										$paymentaddArr = array(
											'tran_type_id'         =>3, //send money
											'to_payment_method_id' =>0,
											'amount'               =>$amount,
											'to_user_id'           =>$userid,
											'from_user_id'         =>$userDetail['id'],
											'tran_status_id'       =>6,
											'sig'                  =>'-',
											'amount_received'      =>$receive_amount,
                                                                                        'charge'                     =>$tran_charge_amount,
											'msg'                  =>$comment,
											//'third_party_tran_id'  =>(!empty($auth_id)) ? $auth_id : $ref_num,
											'third_party_tran_id'  =>$ref_num,
											'merchant_ref_num'     =>$ref_num,
											'created_by'           =>$userid,
											'created_on'           => time(),
											'last_updated_by'      =>$userid
										);
                                                                                
										$Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

						                //Then after insert into Tran_Charges table
										$chargeaddArr = array(
											'transaction_id'  =>$Transaction_id,
											'charge_type_id'  =>0,
											'charge_amt'      =>$tran_charge_amount,
											'created_by'      =>$userid,
											'last_updated_by' =>$userid
										);
										$Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

						                /* Receive money to another user from sended user  */

						                //Then after insert into Transactions table
										$paymentaddArr = array(
											'tran_type_id'         =>4, //receive money
											'to_payment_method_id' =>0,
											'amount'               =>$amount,
											'to_user_id'           =>$userDetail['id'],
											'from_user_id'         =>$userid,
											'tran_status_id'       =>6,
											'sig'                  =>'+',
											'amount_received'      =>$receive_amount,                                                                                    
                                                                                        'charge'               =>$tran_charge_amount,
											'msg'                  =>$comment,
											//'third_party_tran_id'  =>(!empty($auth_id)) ? $auth_id : $ref_num,
											'third_party_tran_id'  =>$ref_num,
											'merchant_ref_num'     =>$ref_num,
											'created_by'           =>$userid,
											'created_on'           => time(),
											'last_updated_by'      =>$userid
										);
										$Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

										//Then after insert into Tran_Charges table
										$chargeaddArr = array(
											'transaction_id'  =>$Transaction_id,
											'charge_type_id'  =>0,
											'charge_amt'      =>$tran_charge_amount,
											'created_by'      =>$userid,
											'last_updated_by' =>$userid
										); 
										$Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

                                       //if($send_money_method == 5){
						                //update amount into users table (deduct amount from sender and update wallet amount)

										$total_wallet_amount = $update_user['current_wallet_balance'] - $amount;
										$userwalletdata['current_wallet_balance'] = $total_wallet_amount;
										 $updatewalletdata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userwalletdata, $userid);

										//update amount into users table (add amount to receiver and update wallet amount)

										$total_receiver_wallet = $userDetail['current_wallet_balance'] + $receive_amount;
										$receiverwalletdata['current_wallet_balance'] = $total_receiver_wallet;
										$updatereceiverwallet = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $receiverwalletdata, $userDetail['id']);
                                      // }

										$updated_user_wallet = $this->dynamic_model->get_user_by_id($userid);

										$response_array = array('full_name' => $userDetail['firstname'] . ' '. $userDetail['lastname'],
											'amount' =>$amount,'transaction_id'  =>$ref_num,'transaction_date'=>get_formated_date(date('Y-m-d')));
									}
									else
									{
						            	$flag           = 0;
						            	$arg['status']  = 0;
										$arg['message'] = $this->lang->line('mobile_invalid');
									}

						            if($flag)
						            {
                                      $response[]  = array(
					                	'full_name' => $userDetail['firstname'] . ' '. $userDetail['lastname'],'transaction_id'  =>$ref_num,'transaction_date'=>get_formated_date(date('Y-m-d')),
					                	'amount' => number_format((float)$amount, 2, '.', ''),'wallet_balance'=>$updated_user_wallet['current_wallet_balance']);

										$arg['status']    = 1;
										$arg['message']   = $this->lang->line('send_money_success');
										$arg['data']      = $response;
										$arg['errorcode'] = REST_Controller::HTTP_OK;
									}
								}
								else
								{
									$arg['status']    = 0;
									$arg['message']   = $this->lang->line('insufficient_wallet_balance');
									$arg['errorcode'] = REST_Controller::HTTP_OK;
									$arg['data']      = array();
								}
							}
						}
					}
				}
			}
		}
	    echo json_encode($arg);
	}

	//Function used for withdraw money
    public function withdrawMoney_post()
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
					$arg = array();
					$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]',array(
						'required'     => $this->lang->line('amount'),
						'numeric'      => $this->lang->line('amount_numeric'),
						'greater_than' => $this->lang->line('amount_greater_than')
					));
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						/* 
				        	withdraw_money_method = 3 means Bank
				     	*/
				        $withdraw_money_method = $this->input->post('withdraw_money_method');
				        $amount                = $this->input->post('amount');
				        $charge                = $this->input->post('charge');
				        $comment               = $this->input->post('comment');
				        $ref_num               = getuniquenumber();

						$userid  = getuserid();
						$loguser = $this->dynamic_model->get_user_by_id($userid);

				        // Use these function for Bank method
				        if($withdraw_money_method == 3)
				        {
				        	$this->form_validation->set_rules('bank_name', 'Bank Name', 'required',array('required'   => $this->lang->line('bank_name_required')
								));
					        $this->form_validation->set_rules('acc_number', 'Account Number', 'required|numeric',array(
									'required'   => $this->lang->line('acc_number_required'),									
									'numeric'    => $this->lang->line('acc_number_numeric')
								));
				        }
						if ($this->form_validation->run() == FALSE)
						{
						  	$arg['status']  = 0;
						  	$arg['message'] = get_form_error($this->form_validation->error_array());
						}
						else
						{
			                if($withdraw_money_method == 3)
				        	{
				        		$bank_name       = $this->input->post('bank_name');
					            $acc_holder_name = $this->input->post('acc_holder_name');
					            $acc_number      = $this->input->post('acc_number');
					            //$sort_code       = $this->input->post('sort_code');

					            // Firstly insert data into User_Payment_Methods table
		                      	$bankDetailArr = array(
			                                    'user_id'          =>$userid,
			                                    'wallet_bank_name' =>$bank_name,
			                                    //'sort_code'        =>$sort_code,
			                                    'account_no'       =>$acc_number,
			                                    'acc_holder_name'  =>$acc_holder_name,
			                                    'is_bank'          =>1,
			                                    'is_deleted'       =>1,
			                                    'created_by'       =>$userid,
			                                    'last_updated_by'  =>$userid
	            								);
		                        $payment_id = $this->dynamic_model->insertdata($this->db->dbprefix.'User_Payment_Methods', $bankDetailArr);
				        	}
		                    $t = time();

	                	    // Check withdraw amount limit exceed
	                    	if($amount <= $loguser['current_wallet_balance'])
	            			{
                                    
                                    //Changes done by Harish
                                    // charge method = FIX / FLOAT
                                    //fee_charge = if fix(fixed amount) else in percent
                                     $charge_detail = $this->dynamic_model->get_fees_charge();
                                    $charge_method = $charge_detail['charge_method'];
                                    $tran_charges = $charge_detail['charge_fee'];  
//                                    $charge_method = CHARGE_METHOD;
//                                    $tran_charges = FEE_CHARGE;                                                                
                                    $tran_charge_amount = 0;
                                    if($tran_charges!=0){
                                    if($charge_method=='FLOAT'){
                                        $tran_charge_amount = ($amount*$tran_charges)/100;
                                    }elseif($charge_method=='FIX'){
                                        $tran_charge_amount = $tran_charges;
                                    }}
                                    $amount_received = $amount-$tran_charge_amount;
        
			                    //Then after insert into Transactions table
		                        $paymentaddArr = array(
		                                                'tran_type_id'         =>1, //withdraw money
		                                                'to_payment_method_id' =>$payment_id,
		                                                'amount'               =>$amount,
		                                                'to_user_id'           =>$userid,
		                                                'tran_status_id'       =>6,
		                                                'sig'                  =>'-',
		                                                'amount_received'      =>$amount_received,
                                                                'charge'               =>$tran_charge_amount,
		                                                'third_party_tran_id'  =>$ref_num,
		                                                'created_by'           =>$userid,
		                                                'created_on'           => time(),
		                                                'last_updated_by'      =>$userid
		                                        	);
		                        $Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

		                        //Then after insert into Tran_Charges table
		                        $chargeaddArr = array(
		                                                'transaction_id'  =>$Transaction_id,
		                                                'charge_type_id'  =>0,
		                                                'charge_amt'      =>$tran_charge_amount,
		                                                'created_by'      =>$userid,
		                                                'last_updated_by' =>$userid
		                                        	);
		                        $Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

		                        //Update User current wallet balance
		                        $total_amount = $loguser['current_wallet_balance'] - $amount;
		                        $userbalancedata['current_wallet_balance'] = $total_amount;
	        					$updatebalancedata = $this->dynamic_model->updatedata('Users', $userbalancedata, $userid);

	        					$update_user = $this->dynamic_model->get_user_by_id($userid);

	        					$response[]    = array('amount' => number_format((float)$amount, 2, '.', ''),'transaction_date'=>get_formated_date(date('Y-m-d')),'transaction_id'=>$ref_num,'wallet_balance'=>$update_user['current_wallet_balance']);

	        					$arg['status']  = 1;
				  				$arg['message'] = $this->lang->line('withdraw_success');
				  				$arg['data']    = $response;
				  				$arg['errorcode'] = REST_Controller::HTTP_OK;
				  			}
				  			else
				  			{
				  				$arg['status']  = 0;
	                    		$arg['message'] = $this->lang->line('withdraw_limit_exceed');
	                    		$arg['data']    = array();
				  				$arg['errorcode'] = REST_Controller::HTTP_OK;
				  			}
						}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}

	//Function used for Get Card Details List 
    public function getCardDetails_post()
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
					$this->form_validation->set_rules('page_no', 'Page No', 'required|numeric',array(
						'required'   => $this->lang->line('page_no'),
						'numeric'    => $this->lang->line('page_no_numeric')
					));
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					} 
					else
					{
						$userid   = getuserid();
						$loguser  = $this->dynamic_model->get_user_by_id($userid);

						$limit  = config_item('page_data_limit'); 
						$offset = $limit * $this->input->post('page_no');

						$condition   = "user_id = '".$userid."' and is_deleted =0";
						$card_detail = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'User_Payment_Methods',$condition, '*', $limit, $offset,'id');
						$card_array  = array();
						if($card_detail)
						{
							$imagePath   = site_url()."uploads/static_contents/creditcardlogos.jpg";
							$user_data   = array();
							$card_array  = array();
							foreach ($card_detail as $card)
							{
								$user_data["id"]             = $card['id'];
								$user_data["user_id"]        = $card['user_id'];
								$user_data["card_number"]    = $card['card_bank_no'];
								$card_expiry                 = explode('-', $card['expiry_month_year']);
								$user_data["expiry_month"]   = $card_expiry[0];
								$user_data["expiry_year"]    = $card_expiry[1];
								$user_data["bank_image"]     = $imagePath;
								$user_data["bank_name"]      = "Test Bank";
								if($card['is_debit_card'] == 1)
									$user_data["card_type"] = "Debit Card";
								if($card['is_credit_card'] == 1)
									$user_data["card_type"] = "Credit Card";
								$card_array[]                = $user_data;
							}
							$arg['status']    = 1;
				            $arg['data']      = $card_array;
				            $arg['message']   = "";
				            $arg['errorcode'] = REST_Controller::HTTP_OK;
						}
						else
						{
							$arg['status']    = 1;
							$arg['data']      = $card_array;
				            $arg['message']   = $this->lang->line('saved_card_not_found');
				            $arg['errorcode'] = REST_Controller::HTTP_OK;
						}
					}
				}
		    }
		}
	    echo json_encode($arg);
	}

	//Function used for Delete Card Detail
    public function deleteCardDetail_post()
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
					$arg = array();
					$this->form_validation->set_rules('cardId', 'card Id', 'required|numeric',array(
						'required'   => $this->lang->line('card_id_required'),
						'numeric'    => $this->lang->line('card_id_numeric')
					));
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						$userid   = getuserid();
						$loguser  = $this->dynamic_model->get_user_by_id($userid);
						$cardId   = $this->input->post('cardId');
						$type     = $this->input->post('type');

						$card_Exist = $this->dynamic_model->get_row($this->db->dbprefix.'User_Payment_Methods',array('user_id'=> $userid,'id'=>$cardId,'is_deleted'=>0));
						if($card_Exist)
						{
							$data1 = array(
										'is_deleted' => 1,
										'last_updated_by'     =>$userid,
										'last_updated_date_time' =>date('Y-m-d H:i:s')
									);
			                $where      = array("id" => $cardId,"user_id"=>$userid);
			                $cardUpdate = update_data($this->db->dbprefix."User_Payment_Methods", $data1, $where);
			                if($type == "Card")
			                {
				                $arg['status']    = 1;
						  		$arg['message']   = $this->lang->line('card_delete_success');
						  		$arg['errorcode'] = REST_Controller::HTTP_OK;
						  		$arg['data']      = array();
						  	}
						  	else
						  	{
						  		$arg['status']    = 1;
						  		$arg['message']   = $this->lang->line('bank_delete_success');
						  		$arg['errorcode'] = REST_Controller::HTTP_OK;
						  		$arg['data']      = array();
						  	}
					  	}
					  	else
					  	{
					  		$arg['status']    = 0;
					  		$arg['message']   = $this->lang->line('record_not_found');
					  		$arg['errorcode'] = REST_Controller::HTTP_OK;
					  		$arg['data']      = array();
					  	}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}

		//Function used for Get Transaction History 
    public function get_transaction_history_post()
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
					$this->form_validation->set_rules('page_no', 'Page No', 'required|numeric',array(
						'required'   => $this->lang->line('page_no'),
						'numeric'    => $this->lang->line('page_no_numeric')
					));
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					} 
					else
					{
						$userid  = getuserid();
						$loguser = $this->dynamic_model->get_user_by_id($userid);
						$limit  = config_item('page_data_limit'); 
						$offset = $limit * $this->input->post('page_no');
						$transaction_type = $this->input->post('transaction_type');
						if($transaction_type == "")
						{
							$transaction_data = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'Transactions', array('to_user_id'=>$userid,'type'=>'Wallet') , '*', $limit, $offset,'id');
						}
						else
						{
							$transaction_data = $this->dynamic_model->getdatafromtable($this->db->dbprefix.'Transactions', array('to_user_id'=>$userid,'tran_type_id'=>$transaction_type,'type'=>'Wallet') , '*', $limit, $offset,'id');
						}

						if(!empty($transaction_data))
						{
							$user_data = array();
							foreach($transaction_data as $details)
		            		{
		            			$transaction_status = $this->dynamic_model->get_row($this->db->dbprefix.'Tran_Status',array('id'=> $details['tran_status_id']));

		            			if($details['from_user_id'])
		            				$Requested_user = $this->dynamic_model->get_user_by_id($details['from_user_id']);



		            			if($details['tran_type_id'] == "1")
		            			{
		            				$user_data["Id"]                 = $details['id'];
		            				$user_data["title"]              = $this->lang->line('transferred_bank');
		            				$user_data["order_number"]       = $details['third_party_tran_id'];
		            				$user_data["amount"]             = $details['amount'];
		            				$user_data["charge"]             = $details['charge'];
		            				$user_data['created_at']         = date('d M Y', strtotime($details['creation_date_time']));
		            				if($transaction_status['status_name'] == "Rejected")
		            					$user_data['transaction_status'] = "Failed";
		            				else
		            					$user_data['transaction_status'] = $transaction_status['status_name'];
		            				$user_data['trx_type']           = $this->lang->line('trx_type_withdraw');
		            				$user_data['tran_type_id']       = "1";
		            				$user_data['msg']                = (!empty($details['msg'])) ? $details['msg'] : '';
		            				$user_data['time']               = date('g:i A',strtotime($details['creation_date_time']));
		            				$transaction_array[]             = $user_data;
		            			}
		            			if($details['tran_type_id'] == "2")
		            			{
		            				$user_data["Id"]                 = $details['id'];
		            				$user_data["title"]              = $this->lang->line('added_wallet');
		            				$user_data["order_number"]       = $details['third_party_tran_id'];
		            				$user_data["amount"]             = $details['amount'];
		            				$user_data["charge"]             = $details['charge'];
		            				$user_data['created_at']         = date('d M Y', strtotime($details['creation_date_time']));
		            				if($transaction_status['status_name'] == "Rejected")
		            					$user_data['transaction_status'] = "Failed";
		            				else
		            					$user_data['transaction_status'] = $transaction_status['status_name'];
		            				$user_data['trx_type']           = $this->lang->line('trx_type_deposit');
		            				$user_data['tran_type_id']       = "2";
		            				$user_data['msg']                = (!empty($details['msg'])) ? $details['msg'] : '';
		            				$user_data['time']               = date('g:i A',strtotime($details['creation_date_time']));
		            				$transaction_array[]             = $user_data;
		            			}
		            			if($details['tran_type_id'] == "3")
		            			{
		            				$user_data["Id"]                 = $details['id'];
		            				$user_data["title"]              = $this->lang->line('sent_money').' '.@$Requested_user['firstname'];
		            				$user_data["order_number"]       = $details['third_party_tran_id'];
		            				$user_data["amount"]             = $details['amount'];
		            				$user_data["charge"]             = $details['charge'];
		            				$user_data['created_at']         = date('d M Y', strtotime($details['creation_date_time']));
		            				if($transaction_status['status_name'] == "Rejected")
		            					$user_data['transaction_status'] = "Failed";
		            				else
		            					$user_data['transaction_status'] = $transaction_status['status_name'];
		            				$user_data['trx_type']           = $this->lang->line('trx_type_sent_money');
		            				$user_data['tran_type_id']       = "3";
		            				$user_data['msg']                = (!empty($details['msg'])) ? $details['msg'] : '';
		            				$user_data['time']               = date('g:i A',strtotime($details['creation_date_time']));
		            				$transaction_array[]             = $user_data;
		            			}
		            			if($details['tran_type_id'] == "4")
		            			{
		            				$user_data["Id"]                 = $details['id'];
		            				$user_data["title"]              = $this->lang->line('money_received').' '.@$Requested_user['firstname'];
		            				$user_data["order_number"]       = $details['third_party_tran_id'];
		            				$user_data["amount"]             = $details['amount_received'];//received amount to show
		            				$user_data["charge"]             = $details['charge'];
		            				$user_data['created_at']         = date('d M Y', strtotime($details['creation_date_time']));
		            				if($transaction_status['status_name'] == "Rejected")
		            					$user_data['transaction_status'] = "Failed";
		            				else
		            					$user_data['transaction_status'] = $transaction_status['status_name'];
		            				$user_data['trx_type']           = $this->lang->line('trx_type_money_received');
		            				$user_data['tran_type_id']       = "4";
		            				$user_data['msg']                = (!empty($details['msg'])) ? $details['msg'] : '';
		            				$user_data['time']               = date('g:i A',strtotime($details['creation_date_time']));
		            				$transaction_array[]             = $user_data;
		            			}
		            			if($details['tran_type_id'] == "5")
		            			{
		            				$user_data["Id"]                 = $details['id'];
		            				$user_data["title"]              = $this->lang->line('donate_money');
		            				$user_data["order_number"]       = $details['third_party_tran_id'];
		            				$user_data["amount"]             = $details['amount'];
		            				$user_data["charge"]             = $details['charge'];
		            				$user_data['created_at']         = date('d M Y', strtotime($details['creation_date_time']));
		            				if($transaction_status['status_name'] == "Rejected")
		            					$user_data['transaction_status'] = "Failed";
		            				else
		            					$user_data['transaction_status'] = $transaction_status['status_name'];
		            				$user_data['trx_type']           = $this->lang->line('trx_type_donate_money');
		            				$user_data['tran_type_id']       = "3";
		            				$user_data['msg']                = (!empty($details['msg'])) ? $details['msg'] : '';
		            				$user_data['time']               = date('g:i A',strtotime($details['creation_date_time']));
		            				$transaction_array[]             = $user_data;
		            			} 
		            		}

							$arg['status']         = 1;
							$arg['data']           = $transaction_array;
							$arg['wallet_balance'] = $loguser['current_wallet_balance'];
							$arg['message']        = "Success";
							$arg['errorcode']      = REST_Controller::HTTP_OK;
						}
						else
						{
							$arg['status']    = 0;
			            	$arg['message']   = $this->lang->line('record_not_found');
			            	$arg['errorcode'] = REST_Controller::HTTP_OK;
			            	$arg['data']      = array();
						}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}
	
   // Function  addmoney using net banking
    public function addMoneyUsingNetBanking_get()
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
				//$usid   = encode($user_token->userid);
				$timezone = $this->input->get_request_header('current_time_zone');
				$lan = $this->input->get_request_header('language');
				$device_type = $this->input->get_request_header('device_type');
                $fcmt='';
                $appv=$this->input->get_request_header('version');
				$usid   = $user_token->userid;
				$userid   = getuserid();
                $loguser  = $this->dynamic_model->get_user_by_id($userid);
                $mobile_no=$loguser['mobile_no'];
                $email=$loguser['email'];
		        
		        $arg['status'] = 1;
		        $arg['error_code']  = REST_Controller::HTTP_OK;
				$arg['message'] = "";
		        //$arg['data'][]   = array('url' => site_url().'lib_trustly/payment/www/deposit.php?user_id='.$usid);
		        //$arg['data'][]   = array('url' => site_url().'paymentserver/example/www/deposit.php?enduserid='.$usid);

		       $arg['data'][]  = array('url' => site_url()."paymentserver/example1/www/deposit.php?enduserid=".$mobile_no."&auth=".$auth_token."&appv=".$appv."&timezone=".$timezone."&lan=".$lan."&dev=".$device_type."&fcmt=".$fcmt."&email=".$email);

            }
        }
        echo json_encode($arg);
    } 
      // Function  addmoney using net banking
    public function withdrawMoneyUsingNetBanking_get()
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
				$timezone = $this->input->get_request_header('current_time_zone');
				$lan = $this->input->get_request_header('language');
                $device_type = $this->input->get_request_header('device_type');
                $fcmt='';
                $appv=$this->input->get_request_header('version');
				$usid   = $user_token->userid;
				$userid   = getuserid();
                $loguser  = $this->dynamic_model->get_user_by_id($userid);
                $mobile_no=$loguser['mobile_no'];
                $email=$loguser['email'];


		        $arg['status'] = 1;
		        $arg['error_code']  = REST_Controller::HTTP_OK;
				$arg['message'] = "";
		        //$arg['data'][]   = array('url' => site_url().'lib_trustly/payment/www/withdraw.php?user_id='.$usid);
		        //$arg['data'][]   = array('url' => site_url().'paymentserver/example/www/withdraw.php?enduserid='.$usid); 
                log_message('info',site_url()."paymentserver/example1/www/withdraw.php?enduserid=".$mobile_no."&auth=".$auth_token."&appv=".$appv."&timezone=".$timezone."&lan=".$lan."&dev=".$device_type."&fcmt=".$fcmt."&email=".$email);
 
                $arg['data'][]  = array('url' => site_url()."paymentserver/example1/www/withdraw.php?enduserid=".$mobile_no."&auth=".$auth_token."&appv=".$appv."&timezone=".$timezone."&lan=".$lan."&dev=".$device_type."&fcmt=".$fcmt."&email=".$email);
                

            }
        }
        echo json_encode($arg);
    }
      //Function used for donation money
    public function donationMoney_post()
    {   log_message('info','donate money'); 
//    	$this->lang->load("message","english");
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
					$arg = array();
					$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]',array(
						'required'     => $this->lang->line('amount_req'),
						'numeric'      => $this->lang->line('amount_numeric'),
						'greater_than' => $this->lang->line('amount_greater_than')
					));
					/*$this->form_validation->set_rules('pin', 'Transaction pin', 'required|min_length[4]|max_length[4]|numeric',array(
							'required'    => $this->lang->line('pin_require'),
							'numeric'     => $this->lang->line('pin_numeric'),
							'min_length'  => $this->lang->line('pin_length'),
							'max_length'  => $this->lang->line('pin_length')
						));*/
					if ($this->form_validation->run() == FALSE)
					{
					  	$arg['status']  = 0;
					  	$arg['message'] = get_form_error($this->form_validation->error_array());
					}
					else
					{
						/*
							Donation amount 
				     	*/
				        $amount           = $this->input->post('amount');
				        $charge           = 0;
				        $ref_num          = getuniquenumber();

				        //Check Transaction Password
						$userid    = getuserid();
						$loguser   = $this->dynamic_model->get_user_by_id($userid);
						if ($this->form_validation->run() == FALSE)
						{
						  	$arg['status']  = 0;
						  	$arg['message'] = get_form_error($this->form_validation->error_array());
						}
						else
						{
		                	$t = time();
		                   // Check withdraw amount limit exceed
							if($amount <= $loguser['current_wallet_balance'])
							{
			                   //echo "test";die;
			                    //Then after insert into Transactions table
		                        $paymentaddArr = array(
		                            'tran_type_id'         =>5, //donation money
		                            'to_payment_method_id' =>0,
		                            'amount'               =>$amount,
		                            'charge'               =>$charge,
		                            'to_user_id'           =>$userid,
		                            'from_user_id'         =>$userid,
		                            'tran_status_id'       =>6,
		                            'sig'                  =>'-',
		                            'amount_received'      =>$amount,
		                            //'third_party_tran_id'  =>$auth_id,
		                            'third_party_tran_id'  =>$ref_num,
		                            'merchant_ref_num'     =>$ref_num,
		                            'created_by'           =>$userid,
		                            'created_on'           => time(),
		                            'last_updated_by'      =>$userid

		                    	);
		                        $Transaction_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Transactions', $paymentaddArr);

		                        //Then after insert into Tran_Charges table
		                        $chargeaddArr = array(
		                            'transaction_id'  =>$Transaction_id,
		                            'charge_type_id'  =>0,
		                            'charge_amt'      =>0,
		                            'created_by'      =>$userid,
		                            'last_updated_by' =>$userid
		                    	);
		                        $Transaction_charge_id = $this->dynamic_model->insertdata($this->db->dbprefix.'Tran_Charges', $chargeaddArr);

		                        //Update User current wallet balance
		                        $total_amount = $loguser['current_wallet_balance'] - $amount;
		                        $userbalancedata['current_wallet_balance'] = $total_amount;
		    					$updatebalancedata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userbalancedata, $userid);

		    					$update_user = $this->dynamic_model->get_user_by_id($userid);

		                        $notification_to = "";
		                        $myname          = ucfirst($loguser['firstname']);

		                        //$notification_title = 'Dear *USERNAME*,Your Money added intited and pending kr '.number_format((float)$amount, 2, '.', '').' to your wallet on '.date('d/m/Y '). ' at '.date('H:i A').' Ref.No: '.$ref_num.' Transaction cost kr 0.00';
	                            $notification_title = 'Dear *USERNAME*,You have successfully donate kr '.number_format((float)$amount, 2, '.', '').' to your wallet on '.date('d/m/Y '). ' at '.date('H:i A').' Ref.No: '.$ref_num;

		                        $notification_type = 5; // Use For Deposit Money
		                        if(!empty($User_Role['device_id']) && $User_Role['device_type'] == 'android')
		                        { 
		                            sendPushAndroid($notification_to,$notification_title, $notification_type );
		                        }
		                        if(!empty($User_Role['device_id']) && $User_Role['device_type'] == 'ios' )
		                        {
		                           sendPushIos($notification_to,$notification_title, $notification_type );
		                        }

		                        //Insert Notification
		                        $notiDataArr = array('recepient_id'=>$userid,'notification_text' =>$notification_title, 'tran_type_id' =>$notification_type) ;
		                        $insert_notification = $this->dynamic_model->insertdata('User_Notifications', $notiDataArr);

		    					$response[]    = array('amount' => number_format((float)$amount, 2, '.', ''),'transaction_date'=>get_formated_date(date('Y-m-d')),'transaction_id'=>$ref_num,'wallet_balance'=>$update_user['current_wallet_balance']);

		    					$arg['status']  = 1;
				  				$arg['message'] = $this->lang->line('donation_sucess');
				  				$arg['data']    = $response;
				  				$arg['errorcode'] = REST_Controller::HTTP_OK;
                            }
							else
							{
								$arg['status']  = 0;
							    $arg['message'] = $this->lang->line('insufficient_wallet_balance');
                                                            log_message('info','language====='.$this->lang->line('insufficient_wallet_balance'));
							    $arg['data']    = array();
								$arg['errorcode'] = REST_Controller::HTTP_OK;
							}


						}
					}
		    	}
		    }
		}
	    echo json_encode($arg);
	}
	//Function used for callback_card_status 
    public function callback_add_money_test_get()
    {
    	$arg = array();
		$where=array('tran_type_id'=>2,'tran_status_id'=>1);
		$trxdata = $this->dynamic_model->getdatafromtable('Transactions',$where);
		//print_r($trxdata);
		$userbalancedata =array();
		$updatetrxdata =array();
		if($trxdata)
		{
			foreach ($trxdata as $key=> $value)
			{ 
				$auth_id='';
			    $auth_id = $value['third_party_tran_id'];
			    $json_response= callback_card_status($auth_id);
			    $response=json_decode($json_response);
			    print_r($response);
			   
			  
			}
			
		}
		
	}

}