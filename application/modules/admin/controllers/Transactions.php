<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    /*
    *  @Description: This controller is use to manage All Transaction Module of Backend
    *  @auther: Gokul Rathod
    */ 
    
    class Transactions extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Transaction_model');
        $this->userId = $this->session->userdata('userId');// encode form
        $this->roleId=$this->session->userdata('userRoleId');
        $result=adminLoginCheck();
        if($result==""){
            redirect('login');
        }

        $activeRole = getActiveRole();
        
        //if($this->roleId!=1){   //5: sub-admin
        if (in_array($this->roleId, $activeRole)) {
            $perDetails   = getSubAdminpermission();  //  get permission variable
            $this->sharebilldetailPer  = !empty($perDetails['sharebill_detail']) ? $perDetails['sharebill_detail'] : '';
            $this->transactionsListPer  = !empty($perDetails['transactions_list']) ? $perDetails['transactions_list'] : '';
            $this->withdrawalListPer  = !empty($perDetails['Withdrawal_list']) ? $perDetails['Withdrawal_list'] : '';
            $this->depositListPer  = !empty($perDetails['deposit_list']) ? $perDetails['deposit_list'] : '';
            $this->sendmoneyListPer  = !empty($perDetails['sendmoney_list']) ? $perDetails['sendmoney_list'] : '';
            $this->reqMoneyListPer  = !empty($perDetails['requestmoney_list']) ? $perDetails['requestmoney_list'] : '';
            $this->sharebillPer  = !empty($perDetails['sharebill_list']) ? $perDetails['sharebill_list'] : '';
            $this->qrcodesPer  = !empty($perDetails['qrcodes_list']) ? $perDetails['qrcodes_list'] : '';
            $this->buttonIcon  = "disabled";
        }else{
            $this->transactionsListPer = "1";
            $this->withdrawalListPer = "1";
            $this->depositListPer = "1";
            $this->sendmoneyListPer = "1";
            $this->reqMoneyListPer = "1";
            $this->sharebillPer = "1";
            $this->qrcodesPer = "1";
            $this->sharebilldetailPer = "1";
            $this->buttonIcon  = "";
        }
    } 
     
    /*
    *  @access: public
    *  @Description: This method is used load transaction detail 
    *  @return: void
    */  
    
    public function index($id=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if(!empty($id)){

            $details =  $this->Common_model->getDataFromTabel('Users', 'role_id', array('id'=> decode($id)));
            if(!empty($details)){
                if($details[0]->role_id==2){
                    $backUrl ="/admin/users/viewUserDetail/";
                }else if($details[0]->role_id==3){
                    $backUrl="/admin/merchant/viewMerchantDetail/";
                }else{
                    $backUrl="/admin/users/viewUserDetail/";
                }
            }else{
                $backUrl="/admin/users/viewUserDetail/";
            }
            
            //echo "<pre>"; print_r($details);echo "</pre>";
            $data['user_id']=$id;
            $this->breadcrumbs->push($this->lang->line('view_details'), $backUrl.$id);
        }

        if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->breadcrumbs->push($this->lang->line('transactions'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        
        /*breadcrumb code end */
        
		$data['title']=$this->lang->line('transactions');
        if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->home_template->load('home_template','admin/transactions/transactionList', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
        
    }
    public function resetTransactionlist($filter=''){
        // if empty filter then not data show
        if(empty($filter)){
           $this->session->unset_userdata('postdata');
        }

        $data['title']=$this->lang->line('transactions');
        if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->home_template->load('home_template','admin/transactions/transactionList', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }

    /*
    *  @access: public
    *  @Description: This method is use to filter data in transaction list  
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function filterTransactionlist(){
        
        $getPostData = $this->input->post();
        if(!empty($getPostData)){
            $this->session->set_userdata('postdata',$getPostData);
            redirect(base_url('admin/transactions/index/search'));
        }
    }
    
     /*
    *  @access: public
    *  @description: This method is use to get transaction list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function transactionajaxlist($id=''){
        if(!empty($id)){
            $user_id=decode($id);
        }else{
            $user_id='';
        }
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='from_firstname';
            }else if($order[0]['column']==3){
                $column_name='amount';
            }else if($order[0]['column']==4){
                $column_name='charge';
            }else if($order[0]['column']==5){
                $column_name='third_party_tran_id';
            }else if($order[0]['column']==6){
                $column_name='role_name';
            }else if($order[0]['column']==8){
                $column_name='msg';
            }else if($order[0]['column']==9){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Transaction_model->transactionajaxlist(true, $user_id);
        $getRecordListing = $this->Transaction_model->transactionajaxlist(false,$user_id,$start,$length, $column_name, $order[0]['dir']);
        
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


                $from_firstname=!empty($recordData->from_firstname) ? $recordData->from_firstname : "";
                $from_lastname=!empty($recordData->from_lastname) ? $recordData->from_lastname : "";


                if($recordData->is_bank==1){
                    $trans_from="Bank";
                }else if($recordData->is_debit_card==1){
                    $trans_from="Debit card";
                }else if($recordData->is_credit_card==1){
                    $trans_from="Credit card";
                }else{
                    $trans_from="Wallet";
                }

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                // if($from_firstname != "" && $from_lastname != ""){
                //     $recordListing[$i][2]= $from_firstname." ".$from_lastname;
                // }
                if($recordData->tran_name =='Withdraw' || $recordData->tran_name =='Deposit' || $recordData->tran_name =='Donation'){
                    $recordListing[$i][2]= "N/A";
                }else{
                    $recordListing[$i][2]= $from_firstname." ".$from_lastname;
                }

                $money_sign =$this->lang->line('money_sign');      
                $recordListing[$i][3]= $recordData->sig." ".$money_sign."".number_format($recordData->amount,2);
                $recordListing[$i][4]= $money_sign."".number_format($recordData->charge,2);
                $recordListing[$i][5]= $recordData->third_party_tran_id;
                $recordListing[$i][6] = $recordData->tran_name;
                $recordListing[$i][7]= $trans_from;   
                $recordListing[$i][8]=  getPaymentStatusText($recordData->tran_status_id);
                $recordListing[$i][9]= change_date_formate($recordData->creation_date_time);

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

        /*
    *  @access: public
    *  @Description: This method is used load Donation detail 
    *  @return: void
    */     
    public function donation($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
          if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->breadcrumbs->push('Donation', '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        if(!empty($id)){

            $details =  $this->Common_model->getDataFromTabel('Users', 'role_id', array('id'=> decode($id)));
            if(!empty($details)){
                if($details[0]->role_id==2){
                    $backUrl ="/admin/users/viewUserDetail/";
                }else if($details[0]->role_id==3){
                    $backUrl="/admin/merchant/viewMerchantDetail/";
                }else{
                    $backUrl="/admin/users/viewUserDetail/";
                }
            }else{
                $backUrl="/admin/users/viewUserDetail/";
            }
            
            //echo "<pre>"; print_r($details);echo "</pre>";
            $data['user_id']=$id;
            $this->breadcrumbs->push($this->lang->line('view_details'), $backUrl.$id);
        }

        if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->breadcrumbs->push($this->lang->line('donation'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        
        /*breadcrumb code end */
        
        $data['title']='Donations'; 
        if($this->roleId==1 || ($this->transactionsListPer==1)){
            $this->home_template->load('home_template','admin/transactions/donation', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
        
    }
   /*
    *  @access: public
    *  @description: This method is use to get Donation list
    *  @return: json_obj
    */ 
    public function donationajaxlist($id=''){
        if(!empty($id)){
            $user_id=decode($id);
        }else{
            $user_id='';
        }
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='amount';
            }else if($order[0]['column']==3){
                $column_name='third_party_tran_id';
            }else if($order[0]['column']==4){
                $column_name='tran_name';
            }else if($order[0]['column']==7){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Transaction_model->donationajaxlist(true, $user_id);
        $getRecordListing = $this->Transaction_model->donationajaxlist(false,$user_id,$start,$length, $column_name, $order[0]['dir']);
        
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


                $from_firstname=!empty($recordData->from_firstname) ? $recordData->from_firstname : "";
                $from_lastname=!empty($recordData->from_lastname) ? $recordData->from_lastname : "";


                if($recordData->is_bank==1){
                    $trans_from="Bank";
                }else if($recordData->is_debit_card==1){
                    $trans_from="Debit card";
                }else if($recordData->is_credit_card==1){
                    $trans_from="Credit card";
                }else{
                    $trans_from="Wallet";
                }

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                $money_sign =$this->lang->line('money_sign');      
                $recordListing[$i][2]= $recordData->sig." ".$money_sign."".number_format($recordData->amount,2);
                $recordListing[$i][3]= $recordData->third_party_tran_id;
                $recordListing[$i][4] = $recordData->tran_name;
                $recordListing[$i][5]= $trans_from;   
                $recordListing[$i][6]=  getPaymentStatusText($recordData->tran_status_id);
                $recordListing[$i][7]= change_date_formate($recordData->creation_date_time);

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
    function exportTransactioncsv(){
        $file_type = $this->uri->segment(4);
        $user_id   = decode($this->input->post('user_id'));
        if(empty($user_id))
        {
            $userId="";
        }
        else
        {
            $userId=$user_id;
        }
        $getRecordListing = $this->Transaction_model->transactionCsvlist($user_id);
        $getRecordListing = json_decode(json_encode($getRecordListing),true);
        //echo "<pre>"; print_r($getRecordListing);die();
        //Code for CSV output
        $csvOutput = "";
        $file      = 'Transaction-list';
        $header    = array(
            'To User',
            'From User',
            'Amount',
            'Charge',
            'Transaction Id',
            'Transaction Type',
            'Transaction Method',
            'Message',
            'Created Date'
        );

        //Code for make header of CSV file
        for($head=0; $head<count($header); $head++)
        {
            $csvOutput .= $header[$head].",";
        }
        
        $csvOutput .= "\n";
        //Code for make rows of CSV file
        foreach($getRecordListing as $key => $recordData) {
            $from_firstname=!empty($recordData['from_firstname']) ? $recordData['from_firstname'] : "";
            $from_lastname=!empty($recordData['from_lastname']) ? $recordData['from_lastname'] : "";

            if($recordData['is_bank']==1){
                $trans_from="Bank";
            }else if($recordData['is_debit_card']==1){
                $trans_from="Debit card";
            }else if($recordData['is_credit_card']==1){
                $trans_from="Credit card";
            }else{
                $trans_from="";
            }

            $csvOutput .= $recordData['firstname']." ".$recordData['lastname'].",";
            $csvOutput .= $from_firstname." ".$from_lastname.",";

            $money_sign = $this->lang->line('money_sign');

            $csvOutput .= $recordData['sig']." ".$money_sign."".number_format($recordData['amount'],2).",";
            $csvOutput .= $money_sign."".number_format($recordData['charge'],2).",";  
            $csvOutput .= $recordData['third_party_tran_id'].",";
            $csvOutput .= $recordData['tran_name'].",";
            $csvOutput .= $trans_from.",";
            $csvOutput .= $recordData['msg'].",";
            $csvOutput .= change_date_formate($recordData['creation_date_time']).",";
            $csvOutput .= "\n";
        }

        $filename = $file."-".date("Y-m-d",time());

        // header('Content-Type: application/csv');
        // header('Content-Disposition: attachment; filename="filename.csv"');

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . ".".$file_type);
        header("Content-disposition: filename=".$filename.".".$file_type);
        print $csvOutput;
        exit;
    }


     /*
    *  @access: public
    *  @Description: This method is used load withdraw detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function withdraw($id=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if(!empty($id)){
            $details =  $this->Common_model->getDataFromTabel('Users', 'role_id', array('id'=> decode($id)));
            if(!empty($details)){
                if($details[0]->role_id==2){
                    $backUrl ="/admin/users/viewUserDetail/";
                }else if($details[0]->role_id==3){
                    $backUrl="/admin/merchant/viewMerchantDetail/";
                }else{
                    $backUrl="/admin/users/viewUserDetail/";
                }
            }else{
                $backUrl="/admin/users/viewUserDetail/";
            }
            $data['user_id']=$id;
            $this->breadcrumbs->push($this->lang->line('view_details'), $backUrl.$id);
        }
        
        if($this->roleId==1 || ($this->withdrawalListPer==1)){
            $this->breadcrumbs->push('Withdrawal', '/'); 
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }

        /*breadcrumb code end */
        
		$data['title']=$this->lang->line('withdrawal_history');
        if($this->roleId==1 || ($this->withdrawalListPer==1)){
            $this->home_template->load('home_template','admin/transactions/withdraw', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    

    /*
    *  @access: public
    *  @description: This method is use to get withdraw list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function withdrawajaxlist($id=''){
        if(!empty($id)){
            $user_id=decode($id);
        }else{
            $user_id='';
        }
		$start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='amount';
            }else if($order[0]['column']==3){
                $column_name='charge';
            }else if($order[0]['column']==5){
                $column_name='tran_name';
            }else if($order[0]['column']==6){
                $column_name='msg';
            }else if($order[0]['column']==7){
            	$column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Transaction_model->withdrawajaxlist(true,$user_id);
        $getRecordListing = $this->Transaction_model->withdrawajaxlist(false,$user_id,$start,$length, $column_name, $order[0]['dir']);
        
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
                
                if($recordData->is_bank==1){
                    $trans_from="Bank";
                }else if($recordData->is_debit_card==1){
                    $trans_from="Debit card";
                }else if($recordData->is_credit_card==1){
                    $trans_from="Credit card";
                }

				$recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;   
                $money_sign =$this->lang->line('money_sign');      
                $recordListing[$i][2]= $recordData->sig." ".$money_sign."".number_format($recordData->amount,2);
                $recordListing[$i][3]= $money_sign."".number_format($recordData->charge,2);
				$recordListing[$i][4]= $recordData->third_party_tran_id;
				// $recordListing[$i][5] = $recordData->role_name;
                $recordListing[$i][5]= $trans_from;   
                $recordListing[$i][6]=  getPaymentStatusText($recordData->tran_status_id);
                $recordListing[$i][7]= change_date_formate($recordData->creation_date_time);

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





     /*
    *  @access: public
    *  @Description: This method is used load deposit money history detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */
    public function depositHistory($id=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if(!empty($id)){
            $details =  $this->Common_model->getDataFromTabel('Users', 'role_id', array('id'=> decode($id)));
            if(!empty($details)){
                if($details[0]->role_id==2){
                    $backUrl ="/admin/users/viewUserDetail/";
                }else if($details[0]->role_id==3){
                    $backUrl="/admin/merchant/viewMerchantDetail/";
                }else{
                    $backUrl="/admin/users/viewUserDetail/";
                }
            }else{
                $backUrl="/admin/users/viewUserDetail/";
            }

            $data['user_id']=$id;
            $this->breadcrumbs->push($this->lang->line('view_details'), $backUrl.$id);
        }

        if($this->roleId==1 || ($this->depositListPer==1)){
            $this->breadcrumbs->push($this->lang->line('deposit_history'), '/');  
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
		$data['title']=$this->lang->line('deposit_history');
        if($this->roleId==1 || ($this->depositListPer==1)){
            $this->home_template->load('home_template','admin/transactions/depositHistory', $data);
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);
        }
    }
    

      /*
    *  @access: public
    *  @description: This method is use to get deposit money history list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function depositHistoryajaxlist($id=''){
        if(!empty($id)){
            $user_id=decode($id);
        }else{
            $user_id='';
        }
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');

        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==3){
                $column_name='amount';
            }else if($order[0]['column']==4){
                $column_name='charge';
            }else if($order[0]['column']==5){
                $column_name='third_party_tran_id';
            }else if($order[0]['column']==8){
                $column_name='msg';
            }else if($order[0]['column']==9){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Transaction_model->depositHistoryajaxlist(true,$user_id);
        $getRecordListing = $this->Transaction_model->depositHistoryajaxlist(false,$user_id,$start,$length, $column_name, $order[0]['dir']);
        
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
                

                $from_firstname=!empty($recordData->from_firstname) ? $recordData->from_firstname : "";
                $from_lastname=!empty($recordData->from_lastname) ? $recordData->from_lastname : "";

                if($recordData->is_bank==1){
                    $trans_from="Bank";
                }else if($recordData->is_debit_card==1){
                    $trans_from="Debit card";
                }else if($recordData->is_credit_card==1){
                    $trans_from="Credit card";
                }else{
                    $trans_from="Wallet";
                }

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                // $recordListing[$i][2]= $from_firstname." ".$from_lastname;
                $money_sign = $this->lang->line('money_sign');      
                $recordListing[$i][2]= $recordData->sig." ".$money_sign."".number_format($recordData->amount,2);
                $recordListing[$i][3]= $money_sign."".number_format($recordData->charge,2);
                $recordListing[$i][4]= $recordData->third_party_tran_id;
                // $recordListing[$i][6] = $recordData->role_name;
                $recordListing[$i][5]= $trans_from;   
                $recordListing[$i][6]=  getPaymentStatusText($recordData->tran_status_id);
                $recordListing[$i][7]= change_date_formate($recordData->creation_date_time);

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




     /*
    *  @access: public
    *  @Description: This method is used load sendMoney detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */

    public function sendMoney(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->sendmoneyListPer==1)){
            $this->breadcrumbs->push($this->lang->line('send_money'), '/'); 
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('send_money');
        
        if($this->roleId==1 || ($this->sendmoneyListPer==1)){
            $this->home_template->load('home_template','admin/transactions/sendMoney', $data);
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);
        } 
    }

      /*
    *  @access: public
    *  @description: This method is use to get send money list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function sendMoneyajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='amount';
            }else if($order[0]['column']==3){
                $column_name='charge';
            }else if($order[0]['column']==5){
                $column_name='tran_name';
            }else if($order[0]['column']==6){
                $column_name='msg';
            }else if($order[0]['column']==7){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Transaction_model->sendMoneyajaxlist(true);
        $getRecordListing = $this->Transaction_model->sendMoneyajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                
                $from_firstname=!empty($recordData->from_firstname) ? $recordData->from_firstname : "";
                $from_lastname=!empty($recordData->from_lastname) ? $recordData->from_lastname : "";

                if($recordData->is_bank==1){
                    $trans_from="Bank";
                }else if($recordData->is_debit_card==1){
                    $trans_from="Debit card";
                }else if($recordData->is_credit_card==1){
                    $trans_from="Credit card";
                }else{
                    $trans_from="Wallet";
                }

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;            
                $recordListing[$i][2]= $from_firstname." ".$from_lastname;
                $money_sign =$this->lang->line('money_sign');      
                $recordListing[$i][3]= $recordData->sig." ".$money_sign."".number_format($recordData->amount,2);
                $recordListing[$i][4]= $money_sign." ".number_format($recordData->charge,2);
                $recordListing[$i][5]= $recordData->third_party_tran_id;

                /*$recordListing[$i][5] = $recordData->tran_name; 
                $recordListing[$i][5] = $recordData->$trans_from; */
                // $recordListing[$i][6] = $recordData->role_name;
                $recordListing[$i][6]= $trans_from;   
                $recordListing[$i][7]= getPaymentStatusText($recordData->tran_status_id);
                //$recordListing[$i][9]= $recordData->creation_date_time;
                $recordListing[$i][8]= change_date_formate($recordData->creation_date_time);
                
                
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



    /*
    *  @access: public
    *  @Description: This method is used load request Money detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  

    public function requestMoney(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->reqMoneyListPer==1)){  
            $this->breadcrumbs->push($this->lang->line('request_money'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('request_money');
        
        if($this->roleId==1 || ($this->reqMoneyListPer==1)){
            $this->home_template->load('home_template','admin/transactions/requestMoney', $data);
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        } 
    }

    /*
    *  @access: public
    *  @description: This method is use to get request money list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function requestMoneyajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='ref_num';
            }else if($order[0]['column']==2){
                $column_name='firstname';
            }else if($order[0]['column']==3){
                $column_name='firstname';
            }else if($order[0]['column']==5){
                $column_name='amount';
            }else if($order[0]['column']==6){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }
        
        $totalRecord      = $this->Transaction_model->requestMoneyajaxlist(true);
        $getRecordListing = $this->Transaction_model->requestMoneyajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
        //echo "<pre>"; print_r($getRecordListing);die();
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

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->ref_num;
                $recordListing[$i][2]= $recordData->firstname." ".$recordData->lastname;            
                $recordListing[$i][3]= $recordData->to_firstname." ".$recordData->to_lastname;  
                $money_sign =$this->lang->line('money_sign');          
                $recordListing[$i][4]= $money_sign." ".number_format($recordData->amount,2);
                $recordListing[$i][5]= changeDateTimeFormate($recordData->creation_date_time);
                //$recordListing[$i][6]= $recordData->status_name;
                if($recordData->status_name=="Success"){
                    // $actionContent .='<button type="button" class="btn btn-success">Success</button>';
                    $actionContent .='<h3 type="button" class="btn btn-success status-btn">Success</h3>';
                }else if($recordData->status_name=="Pending"){
                    $actionContent .='<h3 type="button" class="btn btn-info status-btn">Pending</h3>';
                }else if($recordData->status_name=="Rejected"){
                    $actionContent .='<h3 type="button" class="btn btn-danger status-btn">Rejected</h3>';
                }else if($recordData->status_name=="Cancelled"){
                    $actionContent .='<h3 type="button" class="btn btn-warning status-btn">Cancelled</h3>';
                }else{
                    $actionContent .=$recordData->status_name;;
                }

                $recordListing[$i][6]= $actionContent;


                $actionContent = '';

                
                
                // if($this->sharebilldetailPer==1){
                    
                $imgUrl = base_url('admin/transactions/getRequestBillImage');
                $actionContent .='<a href="javascript:void(0);" onclick="requestBillImage('.$recordData->id.', \''.$imgUrl.'\');" title="View" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('bills').'"><i class="fa fa-th-list"></i> '.$this->lang->line('bills').'</a> ';
                // }else{
                //     $actionContent .='<a href="#" '.$this->buttonIcon.' title="View" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> ';
                // }

                $recordListing[$i][7]= $actionContent;
                
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


    /*
    *  @access: public
    *  @Description: This method is used load share bills request detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function shareBill(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->sharebillPer==1)){  
            $this->breadcrumbs->push($this->lang->line('sharebill_requests'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('sharebill_requests');
        if($this->roleId==1 || ($this->sharebillPer==1)){
            $this->home_template->load('home_template','admin/transactions/shareBill', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        } 
    }


    /*
    *  @access: public
    *  @description: This method is use to get share bills request list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function shareBillajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='ref_num';
            }else if($order[0]['column']==2){
                $column_name='firstname';
            }else if($order[0]['column']==3){
                $column_name='firstname';
            }else if($order[0]['column']==5){
                $column_name='amount';
            }else if($order[0]['column']==6){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }
        
        $totalRecord      = $this->Transaction_model->shareBillajaxlist(true);
        $getRecordListing = $this->Transaction_model->shareBillajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
        //echo "<pre>"; print_r($getRecordListing);die();
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
                $money_sign =$this->lang->line('money_sign');
                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->ref_num;
                $recordListing[$i][2]= $recordData->firstname." ".$recordData->lastname;            
                $recordListing[$i][3]= $money_sign." ".number_format($recordData->amount,2);
                //$image = !empty($recordData->bill_image) ? $recordData->bill_image : '';
                //$actionContent .='<img src="'.getImage($image,"share_bill").'" class="show_menu_img" height="50" width="50"/>'; 
                //$recordListing[$i][4]= $actionContent;
                $recordListing[$i][4]= changeDateTimeFormate($recordData->creation_date_time);
                /*if($recordData->status_name=="Success"){
                    $actionContent .='<button type="button" class="btn btn-success">Success</button>';
                }else if($recordData->status_name=="Pending"){
                    $actionContent .='<button type="button" class="btn btn-info">Pending</button>';
                }else if($recordData->status_name=="Rejected"){
                    $actionContent .='<button type="button" class="btn btn-danger">Rejected</button>';
                }else if($recordData->status_name=="Cancelled"){
                    $actionContent .='<button type="button" class="btn btn-warning">Cancelled</button>';
                }else{
                    $actionContent .=$recordData->status_name;;
                }*/
                $actionContent = '';

                $urls = base_url('admin/transactions/getShareBillDetail');
                
                if($this->sharebilldetailPer==1){
                    $actionContent .='<a href="javascript:void(0);" onclick="getShareBillInfo(\''.$recordData->ref_num.'\', \''.$urls.'\');" title="View" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> ';
                    $imgUrl = base_url('admin/transactions/getShareBillImage');
                    $actionContent .='<a href="javascript:void(0);" onclick="shareBillImage('.$recordData->shareBillId.', \''.$imgUrl.'\');" title="View" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('bills').'"><i class="fa fa-th-list"></i> '.$this->lang->line('bills').'</a> ';
                }else{
                    $actionContent .='<a href="#" '.$this->buttonIcon.' title="View" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> ';
                }

                $recordListing[$i][5]= $actionContent;
                
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

     /*
    *  @access: public
    *  @Description: This method is used load qr code detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function qrcode(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        
        if($this->roleId==1 || ($this->qrcodesPer==1)){  
            $this->breadcrumbs->push($this->lang->line('all_qrcodes'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('all_qrcodes');
        
        if($this->roleId==1 || ($this->qrcodesPer==1)){
            $this->home_template->load('home_template','admin/transactions/qrcodes', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        } 
    }

    /*
    *  @access: public
    *  @description: This method is use to get qr code list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function qrcodeajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='mobile_no';
            }else if($order[0]['column']==4){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }
        
        $totalRecord      = $this->Transaction_model->qrcodeajaxlist(true);
        $getRecordListing = $this->Transaction_model->qrcodeajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
        //echo "<pre>"; print_r($getRecordListing);die();
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

                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;            
                $recordListing[$i][2]= $recordData->mobile_no;
                $recordListing[$i][3]= $recordData->role_name;            
                //$recordListing[$i][4]= $recordData->creation_date_time;
                $recordListing[$i][4]= change_date_formate($recordData->creation_date_time);
                //$recordListing[$i][5]= $recordData->qr_code;
                $image = !empty($recordData->qr_code) ? $recordData->qr_code : '';
                //$actionContent .='<img src="'.getImage($image,"coupon_qr/").'" class="show_menu_img" height="60" width="60"/>'; 
                if(!empty($image)){
                    $actionContent .='<img src="'.base_url('uploads/coupon_qr/').''.$image.'" class="show_menu_img" height="60" width="60"/>';
                }else{
                    $actionContent .='<img src="'.base_url('uploads/coupon_qr/no-image.jpg').'" class="show_menu_img" height="60" width="60"/>';
                }
                
                //$recordListing[$i][6]= $recordData->status_name;
                $recordListing[$i][5]= $actionContent;
                
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



      /*
    *  @access: public
    *  @description: This method is use to get qr code list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function getShareBillDetail(){
        $id = $this->input->post('id');
        if(!empty($id)){
            $shareBillUsers = $this->Transaction_model->getShareBillUsers($id);
            $BillDetail = array();
            if(!empty($shareBillUsers)){
                foreach($shareBillUsers as $user){
                    $usersArray = array();
                    $usersArray['user']=$user->firstname." ".$user->lastname;
                    $usersArray['amount']=number_format($user->amount,2);
                    $usersArray['status']=$user->status_name;
                    $usersArray['ref_num']=$user->ref_num;
                    $BillDetail[]=$usersArray;
                }    
            }
            
            
            // $newArray = array();
            // foreach ($campaignDetails as $key => $level){
            //    foreach ($level as $attribute){
            //          $newArray[$key]['week_no'] = $attribute->week_no;
            //          $newArray[$key]['discount_date'] = date("m/d/Y", strtotime($attribute->discount_date));
            //          $newArray[$key]['start_time'] = date("g:i A", $attribute->start_time); // convert timestamp to date time
            //          $newArray[$key]['end_time'] = date("g:i A", $attribute->end_time); // convert timestamp to date time
            //          $newArray[$key]['discount'] = $attribute->discount;
            //    }
            // }
            echo json_encode($BillDetail);        
            exit();
        }   
    }



    public function getShareBillImage(){
         $id = $this->input->post('id');
        if(!empty($id)){
            $shareBillImage =  $this->Common_model->getDataFromTabel('Request_Share', 'bill_image', array('id'=> $id));
            $shareBillImage = !empty($shareBillImage) ? $shareBillImage[0] : "";
           // echo "<pre>"; print_r($shareBillImage);echo "</pre>";
            
            $BillImage = array();
            if(!empty($shareBillImage)){
                $shareBillImg=explode(",",$shareBillImage->bill_image);
                foreach($shareBillImg as $img){
                    $usersArray = array();
                    $usersArray['bill_image']=$img;
                    $BillImage[]=$usersArray;
                }    
            }
            //echo "<pre>"; print_r($BillImage);die();
            echo json_encode($BillImage);        
            exit();
        }   
    }


    public function getRequestBillImage(){
         $id = $this->input->post('id');
        if(!empty($id)){
            $requestBillImage =  $this->Common_model->getDataFromTabel('Request_Share', 'bill_image', array('id'=> $id));
            $requestBillImage = !empty($requestBillImage) ? $requestBillImage[0] : "";
            //echo "<pre>"; print_r($shareBillImage);echo "</pre>";
            
            $ReqBillImage = array();
            if(!empty($requestBillImage)){
                $reqBillImg=explode(",",$requestBillImage->bill_image);
                foreach($reqBillImg as $img){
                    $usersArray = array();
                    $usersArray['bill_image']=$img;
                    $ReqBillImage[]=$usersArray;
                }    
            }
            //echo "<pre>"; print_r($BillImage);die();
            echo json_encode($ReqBillImage);        
            exit();
        }   
    }


    

}
