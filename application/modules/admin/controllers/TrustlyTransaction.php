<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    /*
    *  @Description: This controller is use to manage Users Module of Backend
    *  @auther: Gokul Rathod
    */ 
    class TrustlyTransaction extends CI_Controller  { 
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Users_model');
        $this->load->model('Trustly_model');
        //$this->load->model('Master_model');
        
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
            $this->userListPer     = !empty($perDetails['user_list']) ? $perDetails['user_list'] : '';
            $user_edit        = !empty($perDetails['user_edit']) ? $perDetails['user_edit'] : '';
            $user_status     = !empty($perDetails['user_status']) ? $perDetails['user_status'] : '';
            $user_view        = !empty($perDetails['user_view']) ? $perDetails['user_view'] : '';

            $this->transListPer        = !empty($perDetails['transactions_list']) ? $perDetails['transactions_list'] : '';
            $this->withdrListPer     = !empty($perDetails['Withdrawal_list']) ? $perDetails['Withdrawal_list'] : '';
            $this->depoListPer        = !empty($perDetails['deposit_list']) ? $perDetails['deposit_list'] : '';

            $buttonRDisable         = "disabled";

            $this->userEdit = $user_edit;
            $this->userStatus = $user_status;
            $this->userView = $user_view;
            //$this->userDelete = $user_delete;
            $this->buttonIcon       = $buttonRDisable;
        }else{
            $this->userListPer="";
            $this->userEdit = "1";
            $this->userStatus = "1";
            $this->userView = "1";
            $this->transListPer = "1";
            $this->withdrListPer = "1";
            $this->depoListPer  = "1";
            $this->buttonIcon   = "";
        }

    } 
     
    /*
    *  @access: public
    *  @Description: This method is used load user details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function index($filter=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->userListPer==1)){
            $this->breadcrumbs->push('Trustly Transactions', '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
		// if empty filter then not data show
        if(empty($filter)){
           $this->session->unset_userdata('postdata');
        }
    
        $data['title']="Trustly Transaction Details ";
        
        if($this->roleId==1 || ($this->userListPer==1)){
            $this->home_template->load('home_template','admin/trustly_trx_details/transaction_details', $data); 
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }   
    }
     
     /*
    *  @access: public
    *  @description: This method is use to get Scan materials list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function trxajaxlist(){
        //echo "test";die;
		$start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='method';
            }else if($order[0]['column']==2){
                $column_name='order_id';
            }else if($order[0]['column']==3){
                $column_name='messageid';
            }else if($order[0]['column']==4){
                $column_name='created_date';
            }else{
                $column_name='created_date';
            }
        }

        $totalRecord      = $this->Trustly_model->trxsajaxlist(true);
        $getRecordListing = $this->Trustly_model->trxsajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
        $recordListing = array();
        $content='[';
        $i=0;		
        $srNumber=$start;		
        if(!empty($getRecordListing)) {
            $actionContent = '';
            foreach($getRecordListing as $recordData) {
                $userListData  = array(); //set default array
                $actionContent = ''; // set default empty
                $content .='[';
              
                // $userdDetails =  $this->Common_model->getDataFromTabel('Users','*',array('id'=> $recordData->user_id));
                // if(!empty($userdDetails)){
                //     $mobile_no=@$userdDetails[0]['mobile_no'];
                // }else{
                //     $mobile_no="-";
                // }
                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]=(!empty($recordData->user_id)) ? $recordData->user_id : "-";
                $recordListing[$i][2]= (!empty($recordData->type)) ? $recordData->type : "-";
                $recordListing[$i][3]= (!empty($recordData->amount)) ? number_format($recordData->amount,2) : "-";
                $recordListing[$i][4]= (!empty($recordData->currency)) ? $recordData->currency : "-";
                $recordListing[$i][5]= (!empty($recordData->order_id)) ? $recordData->order_id : "-";
                $recordListing[$i][6]= (!empty($recordData->messageid)) ? $recordData->messageid : "-";
                $money_sign =$this->lang->line('money_sign');      
                //$recordListing[$i][5]= number_format($recordData->vatPerc,2);
              
				$recordListing[$i][7]= change_date_formate($recordData->created_date);
				              
				$i++;
                $srNumber++;
            }
          
            $content .= ']';
            $final_data = json_encode($recordListing);
        } else {
            $final_data = '[]';
        }	
        		
        echo '{"draw":'.$draw.',"recordsTotal":'.$totalRecord.',"recordsFiltered":'.$totalRecord.',"data":'.$final_data.'}';
        
	}
  
}
