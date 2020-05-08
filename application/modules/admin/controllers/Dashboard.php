<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Dashboard extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        $this->load->model('Dashboard_model');
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->userId = $this->session->userdata('userId');// encode form
        $this->roleId=$this->session->userdata('userRoleId');
        $result=adminLoginCheck();
        if($result==""){
            redirect('login');
        }
        $activeRole = getActiveRole();

        //if($this->roleId!=1){   //5: sub-admin
        if (in_array($this->roleId, $activeRole)) {
            $perDetails         = getSubAdminpermission();  
            $this->userListPer      = !empty($perDetails['user_list']) ? $perDetails['user_list'] : '';
            $this->merchantListPer  = !empty($perDetails['merchant_list']) ? $perDetails['merchant_list'] : '';
            $this->agentListPer     = !empty($perDetails['agent_list']) ? $perDetails['agent_list'] : '';
            $this->distributorListPer = !empty($perDetails['distributor_list']) ? $perDetails['distributor_list'] : '';
            $this->buttonIcon         = "disabled";
        }else{
            $this->userListPer     = "";
            $this->merchantListPer = "";
            $this->agentListPer    = "";
            $this->distributorListPer = "";
            $this->buttonIcon  = "";
        }
    } 
     
   /*
    *  @access: public
    *  @Description: This method is used load admin dashboard page 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function index(){
        $data['title']=$this->lang->line('dashboard');
        
        /* permission var start */
        $data['userListPer']=$this->userListPer;
        $data['merchantListPer']=$this->merchantListPer;
        $data['agentListPer']=$this->agentListPer;
        $data['distributorListPer']=$this->distributorListPer;
        /* permission var end */

        $data['total_user'] = $this->Common_model->countResult($this->db->dbprefix.'Users', array('role_id' => '2')); //'status' => 1
        $data['total_merchant'] = $this->Common_model->countResult($this->db->dbprefix.'Users', array('role_id' => '3'));
        $data['total_agent'] = $this->Common_model->countResult($this->db->dbprefix.'Users', array('role_id' => '4'));
        $data['total_distributor'] = $this->Common_model->countResult($this->db->dbprefix.'Users', array('role_id' => '6'));

        $data['total_machine'] = $this->Common_model->countResult($this->db->dbprefix.'Machine_Detail', array('user_id' => decode($this->userId)));

        //total withdraw
        $data['total_withdraw'] = $this->Common_model->countResult($this->db->dbprefix.'Transactions', array('tran_type_id' => '1'));
        
        // total Deposit amount
        $totalDepositAmt = $this->Dashboard_model->getTransMethodAmt(2);

        
        //echo "<pre>"; print_r($totalDepositAmt);die;
        $data['totalDepositAmt'] = !empty($totalDepositAmt->totalAmount) ? $totalDepositAmt->totalAmount : "0";
        // total Withdra amount
        $totalWithdraAmt = $this->Dashboard_model->getTransMethodAmt(1);
        $data['totalWithdraAmt'] = !empty($totalWithdraAmt->totalAmount) ? $totalWithdraAmt->totalAmount : "0";

        // total Charge amount
        $totalChargeAmt = $this->Dashboard_model->getTransChargeAmt();
        $data['totalChargeAmt'] = !empty($totalChargeAmt->totalCharge) ? $totalChargeAmt->totalCharge : "0";


        
        $this->home_template->load('home_template','admin/dashboard',$data);    
    }
    
	
	/*
    *  @access: public
    *  @Description: This method is used for user logout 
    *  @auther: Gokul Rathod
    *  @return: void
    */ 
    
     public function logout() {     
        $array_items = array('userId', 'userRoleId','email','first_name','last_name');
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        redirect(base_url('login'));
     }
 }
