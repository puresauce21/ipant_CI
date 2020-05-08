<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('dynamic_model');
	}
	public function index(){
		
	}
	public function frontendtemplates($view, $data = array(), $headerdata = array()){
		$footerdata = array();
		$this->load->view('web/template/header', $headerdata);
		$this->load->view('web/'.$view,$data);
		$this->load->view('web/template/footer',$footerdata);
	}


	public function frontenddashboardtemplates($view, $data = array(), $headerdata = array()){
		$footerdata = array();
		$this->load->view('web/template/innerheader', $headerdata);
		$this->load->view('web/dashboard/'.$view,$data);
		$this->load->view('web/template/footer',$footerdata);
	}



	public function frontenddashboardtemplates1($view, $data = array(), $headerdata = array()){
		if($this->session->userdata('userId')){
	 		$footerdata = array();
			$userid   = decode($this->session->userdata('userId'));
			$loguser  = $this->dynamic_model->get_user_by_id($userid);
			$notification_data = $this->dynamic_model->getdatafromtable('User_Notifications', array('recepient_id'=>$userid));

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
				$headerdata['notification_list'] = $notification_array;
			} else {
				$headerdata['notfound'] = "Recoud Not Found";
			}
			$this->load->view('web/template/innerheader', $headerdata);
			$this->load->view('web/dashboard/'.$view,$data);
			$this->load->view('web/template/footer',$footerdata);
		} else {

			$urlMethod= $this->router->fetch_method();
			if($urlMethod=="index"){ // dashboard 
				// set guest user dashboard
				$this->load->view('web/template/innerheader');
				$this->load->view('web/dashboard/'.$view);
				$this->load->view('web/template/footer');
			}else{
				redirect('/account', 'refresh');   	
			}
		}
	}



	public function admintemplates($view, $data = array(), $headerdata = array()){
		if($this->session->userdata('logged_in')){
		  	$this->load->view('templates/header', $headerdata);
			$this->load->view('admin/'.$view,$data);
			$this->load->view('templates/footer');
		} else {
		  $this->load->view('login');
		}	
	}

	public function merchanttemplates($view, $data = array(), $headerdata = array()){
		if($this->session->userdata('logged_in')){
			$this->load->view('templates/header', $headerdata);
			$this->load->view('merchant/'.$view,$data);
			$this->load->view('templates/footer');
		} else {
		  $this->load->view('login');
		}	
	}


	public function subadmintemplates($view, $data = array(), $headerdata = array()){
		if($this->session->userdata('logged_in')){
			$this->load->view('templates/header', $headerdata);
			$this->load->view('subadmin/'.$view,$data);
			$this->load->view('templates/footer');
		} else {
		  $this->load->view('login');
		}	
	}


}