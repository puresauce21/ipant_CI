<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    /*
    *  @Description: This controller is use to manage App/Web Settings Module of Backend
    *  @auther: Gokul Rathod
    */ 
    class Settings extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Setting_model');
        $this->userId = $this->session->userdata('userId');// encode form
        $this->roleId=$this->session->userdata('userRoleId');
        $result=adminLoginCheck();
        if($result==""){
            redirect('login');
        }

        $activeRole = getActiveRole();
        
        //if($this->roleId!=1){   //5: sub-admin
        if (in_array($this->roleId, $activeRole)) {
            $perDetails        = getSubAdminpermission();  
            
            $this->requestPer  = !empty($perDetails['request_list']) ? $perDetails['request_list'] : '';
            $this->faqPermission  = !empty($perDetails['faq_list']) ? $perDetails['faq_list'] : '';
            $this->faqAddPer     = !empty($perDetails['faq_add']) ? $perDetails['faq_add'] : '';
            $this->faq_edit    = !empty($perDetails['faq_edit']) ? $perDetails['faq_edit'] : '';
            $this->faq_status  = !empty($perDetails['faq_status']) ? $perDetails['faq_status'] : '';
            $this->faq_delete  = !empty($perDetails['faq_delete']) ? $perDetails['faq_delete'] : '';
            $this->virtualFaqPerm  = !empty($perDetails['virtual_faq_list']) ? $perDetails['virtual_faq_list'] : '';
            $this->add_virtual_faq  = !empty($perDetails['add_virtual_faq']) ? $perDetails['add_virtual_faq'] : '';
            $this->edit_virtual_faq = !empty($perDetails['edit_virtual_faq']) ? $perDetails['edit_virtual_faq'] : '';
            $this->virtual_faq_status = !empty($perDetails['virtual_faq_status']) ? $perDetails['virtual_faq_status'] : '';
            $this->virtual_faq_delete = !empty($perDetails['virtual_faq_delete']) ? $perDetails['virtual_faq_delete'] : '';
            $this->TSwalletPerm = !empty($perDetails['tutorialSplashWallet']) ? $perDetails['tutorialSplashWallet'] : '';
            $this->TSwalletStatus    = !empty($perDetails['tutorialSplashWalletStatus']) ? $perDetails['tutorialSplashWalletStatus'] : '';
            $this->TSwalletDelete    = !empty($perDetails['tutorialSplashWalletDelete']) ? $perDetails['tutorialSplashWalletDelete'] : '';
            $this->TSwalletMulDelete = !empty($perDetails['tutorialSplashWalletMulDelete']) ? $perDetails['tutorialSplashWalletMulDelete'] : '';
            $this->TSmasterPerm    = !empty($perDetails['tutorialSplashMaster']) ? $perDetails['tutorialSplashMaster'] : '';
            $this->TSmasterStatus    = !empty($perDetails['tutorialSplashMasterStatus']) ? $perDetails['tutorialSplashMasterStatus'] : '';
            $this->TSmasterDelete    = !empty($perDetails['tutorialSplashMasterDelete']) ? $perDetails['tutorialSplashMasterDelete'] : '';
            $this->TSmasterMulDelete = !empty($perDetails['tutorialSplashMasterMulDelete']) ? $perDetails['tutorialSplashMasterMulDelete'] : '';
            $this->TSmasterAddPer    = !empty($perDetails['addTutSpwalletMaster']) ? $perDetails['addTutSpwalletMaster'] : '';
            $this->webSettingPer = !empty($perDetails['web_setting']) ? $perDetails['web_setting'] : '';
            $this->changePasswordPer = !empty($perDetails['change_password']) ? $perDetails['change_password'] : '';
            $this->buttonIcon = "disabled";
        }else{
            $this->requestPer = "1";
            $this->faqPermission = "1";
            $this->faqAddPer = "1";
            $this->faq_edit = "1";
            $this->faq_status = "1";
            $this->faq_delete = "1";
            $this->virtualFaqPerm = "1";
            $this->add_virtual_faq = "1";
            $this->edit_virtual_faq = "1";
            $this->virtual_faq_status = "1";
            $this->virtual_faq_delete = "1";
            $this->TSwalletPerm = "1";
            $this->TSwalletStatus    = "1";
            $this->TSwalletDelete    = "1";
            $this->TSwalletMulDelete = "1";
            $this->TSmasterPerm = "1";
            $this->TSmasterStatus    = "1";
            $this->TSmasterDelete    = "1";
            $this->TSmasterMulDelete = "1";
            $this->TSmasterAddPer = "1";
            $this->webSettingPer = "1";
            $this->changePasswordPer = "1";
            $this->buttonIcon       = "";
        }
    } 
     
   
	/*
    *  @access: public
    *  @Description: This method is used load splash wallet details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function tutorialSplashWallet(){  
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->TSwalletPerm==1)){
            $this->breadcrumbs->push($this->lang->line('tutorial_splash_wallet'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        $data['TSwalletMulDelete']=$this->TSwalletMulDelete;
        $data['title']=$this->lang->line('tutorial_splash_wallet');
        if($this->roleId==1 || ($this->TSwalletPerm==1)){
            $this->home_template->load('home_template','admin/settings/tutorialSplashWallet', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    


     /*
    *  @access: public
    *  @description: This method is use to get tutorial wallet list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function tutorialSplashWallajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='title';
            }else if($order[0]['column']==2){
                $column_name='content';
            }else{
                $column_name='title';
            }
        }

        $totalRecord      = $this->Setting_model->tutorialSplashAjaxlist(true, 'Wallet');
        $getRecordListing = $this->Setting_model->tutorialSplashAjaxlist(false, 'Wallet',$start,$length, $column_name, $order[0]['dir']);
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
                
                
                if($this->TSwalletMulDelete==1){
                    $recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                }else{
                    $recordListing[$i][0]=  '<input type="checkbox" '.$this->buttonIcon.'  name="deleteId[]" value="" class="checkbox ischeckedaction"/>';
                }
                $recordListing[$i][1]= $recordData->title;
                $recordListing[$i][2]= $recordData->content;

                $image = !empty($recordData->image) ? $recordData->image : '';
                $actionContent .='<img src="'.base_url('uploads/static_contents/').''.$image.'" class="show_menu_img" height="40" width="40"/>'; 

                $recordListing[$i][3]= $actionContent;



                $recordListing[$i][4]= $recordData->type;
                
                $actionContent = '';
                
                $table='Tutorial_Splash';
                $field='status';
                $urls = base_url('admin/settings/updateStatus');
                $warning_msg=$this->lang->line('do_you_want_to_change_status');
                
                if($this->TSwalletStatus==1){
                    if($recordData->status=='Active'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Inactive">Inactive</a>';
                    }
                }else{
                    if($recordData->status=='Active'){
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="Active">Active</a>';
                    }else{ 
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-red waves-effect" href="#" title="Deactive">Deactive</a>';
                    }
                }
                
                $recordListing[$i][5]= $actionContent;              
                

                $actionContent = '';
                
                $urls = base_url('admin/settings/tutorialSplashDelete');
                

                if($this->TSwalletDelete==1){
                    $actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData('.$recordData->id.', \''.$urls.'\');" class="btn btn-default" title="'.$this->lang->line('delete').'"><i class="fa fa-trash"></i> </a>';
                }else{
                    $actionContent .='<a class="btn btn-danger" href="#" '.$this->buttonIcon.' class="btn btn-default" title="'.$this->lang->line('delete').'"><i class="fa fa-trash"></i> </a>';
                }


                $recordListing[$i][6]= $actionContent;              

                
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
    *  @Description: This method is used load splash master wallet details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function tutorialSplashMaster(){  
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->TSmasterPerm==1)){
            $this->breadcrumbs->push($this->lang->line('tutorial_splash_master'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        $data['TSmasterMulDelete']=$this->TSmasterMulDelete;
        $data['title']=$this->lang->line('tutorial_splash_master');
        if($this->roleId==1 || ($this->TSmasterPerm==1)){
            $this->home_template->load('home_template','admin/settings/tutorialSplashMaster', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    


     /*
    *  @access: public
    *  @description: This method is use to get tutorial master wallet list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function tutorialSplashMasajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='title';
            }else if($order[0]['column']==2){
                $column_name='content';
            }else{
                $column_name='title';
            }
        }

        $totalRecord      = $this->Setting_model->tutorialSplashAjaxlist(true, 'Master');
        $getRecordListing = $this->Setting_model->tutorialSplashAjaxlist(false, 'Master',$start,$length, $column_name, $order[0]['dir']);
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
                
                if($this->TSmasterMulDelete==1){
                    $recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                }else{
                    $recordListing[$i][0]=  '<input type="checkbox" '.$this->buttonIcon.'  name="deleteId[]" value="" class="checkbox ischeckedaction"/>';
                }
                $recordListing[$i][1]= $recordData->title;
                $recordListing[$i][2]= $recordData->content;

                $image = !empty($recordData->image) ? $recordData->image : '';
                $actionContent .='<img src="'.base_url('uploads/static_contents/').''.$image.'" class="show_menu_img" height="40" width="40"/>'; 

                $recordListing[$i][3]= $actionContent;



                $recordListing[$i][4]= $recordData->type;
                
                $actionContent = '';
                
                 $table='Tutorial_Splash';
                $field='status';
                $urls = base_url('admin/settings/updateStatus');
                $warning_msg=$this->lang->line('do_you_want_to_change_status');
                
                if($this->TSmasterStatus==1){
                    if($recordData->status=='Active'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Inactive">Inactive</a>';
                    }
                }else{
                    if($recordData->status=='Active'){
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="Active">Active</a>';
                    }else{ 
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-red waves-effect" href="#" title="Deactive">Deactive</a>';
                    }
                }
               
                
                $recordListing[$i][5]= $actionContent;              
                

                $actionContent = '';
                $urls = base_url('admin/settings/tutorialSplashDelete');

                if($this->TSmasterDelete==1){
                    $actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteData('.$recordData->id.', \''.$urls.'\');" class="btn btn-default" title="'.$this->lang->line('delete').'"><i class="fa fa-trash"></i> </a>';
                }else{
                    $actionContent .='<a class="btn btn-danger" href="#" '.$this->buttonIcon.' class="btn btn-default" title="'.$this->lang->line('delete').'"><i class="fa fa-trash"></i> </a>';
                }

                $recordListing[$i][6]= $actionContent;              

                
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
    *  @Description: This method is used load add tutorial wallet details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  

	public function addTutorialSplash(){ 
          /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->TSmasterAddPer==1)){
            $this->breadcrumbs->push($this->lang->line('add_tutorial_splash'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */

		$data['title']=$this->lang->line('add_tutorial_splash');
        if($this->roleId==1 || ($this->TSmasterAddPer==1)){
            $this->home_template->load('home_template','admin/settings/addTutorialSplash', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }

	
    /*
    *  @access: public
    *  @Description: This method is used save tutorial wallet details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  	
	public function saveTutorialSplash(){ 
        $this->form_validation->set_rules('type','type','required|trim');
        $this->form_validation->set_rules('title','title','required|trim');
        $this->form_validation->set_rules('tutorial_content','tutorial_content','required|trim');
        
        if($this->form_validation->run() === false){   
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/settings/addTutorialSplash'));
        }else{
            $type="";
            $redirect_url="admin/settings/addTutorialSplash";
            if($this->input->post('type')==1){
                $type="Wallet";
                $redirect_url="admin/settings/tutorialSplashWallet";
            }else if($this->input->post('type')==2){
                $type="Master";
                $redirect_url="admin/settings/tutorialSplashMaster";
            }
            $data['title']   = $this->input->post('title');
            $data['content'] = $this->input->post('tutorial_content');
            $data['type']    = $type;
            $data['status']  = 'Active';
            
            if (isset($_FILES["splashImg"]["name"]) && $_FILES["splashImg"]["name"]!="") {
        
                $dirPath = 'uploads/static_contents';
                $response=$this->Common_model->uploadProfileImage("static_contents",$dirPath,"splashImg");
                    
                $data['image'] = '';
                if (!empty($response) && $response['status']=="error") {
                    redirect(base_url('admin/settings/addTutorialSplash'));
                } else if(!empty($response) && $response['status']=="success") {
                    $data['image']=$response['imageName'];
                }
            }

            $this->Common_model->addDataIntoTable("Tutorial_Splash",$data);
            $this->messages->setMessageFront($this->lang->line('added_successful'),'success');
            redirect(base_url($redirect_url));
            
        }
    }


    /*
    *  @access: public
    *  @Description: This method is used to remove splash tutorial
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function tutorialSplashDelete(){
        $id = $this->input->post('id');
        $whereCondtion  = array('id'=>$id );
        $ids=$this->Common_model->deleteRow('Tutorial_Splash',$whereCondtion);  
        if($ids){
            $response = true;
        }else{
            $response = false;
        }
        echo json_encode($response);        
        exit();
    }
    
    
  	
	
	
	  /*
    *  @access: public
    *  @Description: This method is use to change user status
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
	function updateStatus(){
		$returnData=false;
		$userId=$this->input->post('ids');
		$IdField = $this->input->post('idField') ? $this->input->post('idField') : "id";
		$userStatus=$this->input->post('status');
		$table=$this->input->post('table');
		$field=$this->input->post('field');

		if((!empty($userId)) && (!empty($table))){

			if($userStatus=='Active'){
				$status='Inactive';
			}else{
				$status='Active';
			}
			$upWhere = array($IdField =>$userId);
			$updateData = array($field=>$status);
			$this->Common_model->updateDataFromTabel($table,$updateData,$upWhere);
			$returnData = array('isSuccess'=>true);
			
		}else{
			$returnData = array('isSuccess'=>false);
		}
		echo json_encode($returnData); 
	}


    /*
    *  @access: public
    *  @Description: This method is use to change user status
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    function updateReqStatus(){
        $returnData=false;
        $userId=$this->input->post('ids');
        $IdField = $this->input->post('idField') ? $this->input->post('idField') : "id";
        $requestStatus=$this->input->post('status');
        $table=$this->input->post('table');
        $field=$this->input->post('field');

        if((!empty($userId)) && (!empty($table))){

            // if($userStatus=='Active'){
            //     $status='Inactive';
            // }else{
            //     $status='Active';
            // }
            $upWhere = array($IdField =>$userId);
            $updateData = array($field=>$requestStatus);
            $this->Common_model->updateDataFromTabel($table,$updateData,$upWhere);
            $returnData = array('isSuccess'=>true);
            
        }else{
            $returnData = array('isSuccess'=>false);
        }
        echo json_encode($returnData); 
    }


    



     /*
    *  @access: public
    *  @Description: This method is used load static templates 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function staticTemplates(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('category_list'), '/');
        /*breadcrumb code end */
        
        $data['title']='Static Templates';//$this->lang->line('category_list');
        $this->home_template->load('home_template','admin/settings/staticTemplates', $data);    
    }
    
    
  
     /*
    *  @access: public
    *  @description: This method is use to get template list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function staticTempajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        /*$order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='category_name';
            }else if($order[0]['column']==2){
                $column_name='category_type';
            }else if($order[0]['column']==3){
                $column_name='category_description';
            }else{
                $column_name='category_name';
            }
        }*/

        $totalRecord      = $this->Users_model->staticTempajaxlist(true);
        $getRecordListing = $this->Users_model->staticTempajaxlist(false,$start,$length);
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
                
                //$recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                $recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->subject;
                $recordListing[$i][2]= $recordData->content;
               
                
                $actionContent = '';
                $actionContent .='<a href="'.base_url('admin/settings/getStaticTemp/'.encode($recordData->id)).'" class="btn btn-default" title="'.$this->lang->line('edit').'"><i class="fa fa-edit"></i> '.$this->lang->line('edit').'</a> '; 
                
                
                $recordListing[$i][3]= $actionContent;              
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
    *  @Description: This method is use to get template info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
    public function getStaticTemp($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('category_list'), 'admin/category');
        $this->breadcrumbs->push($this->lang->line('edit_category'), '/');
        /*breadcrumb code end */
            
        if(!empty($id)){        
            $data['title']=$this->lang->line('edit_category');
            $staticTemp =  $this->Common_model->getDataFromTabel('static_template', '*', array( 'id'=> decode($id)));
            $data['staticTemp'] = !empty($staticTemp) ? $staticTemp[0] : "";
            $this->home_template->load('home_template','admin/settings/editStaticTemplates', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }



   /*
    *  @access: public
    *  @Description: This method is used update template 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateStaticTemp($id=''){
        if(!empty($id)){
            if($this->input->post()){
                $this->form_validation->set_rules('subject','subject','required|trim');
                $this->form_validation->set_rules('content','content','required|trim');
                if($this->form_validation->run() === false){   
                    $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                    redirect(base_url('admin/settings/getStaticTemp/'.$id));
                }else{
                    $cateId = decode($id);
                    $data['subject']  = ucwords($this->input->post('subject'));
                    $data['content']  = !empty($this->input->post('content')) ? $this->input->post('content') : "";

                    $this->Common_model->updateDataFromTabel("static_template",$data,array('id'=>$cateId));
                    $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
                    redirect(base_url('admin/settings/staticTemplates'));
                }
            }
        }else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/settings/staticTemplates'));
        }
    }
    

    /*
    *  @access: public
    *  @Description: This method is used update favicon and web logo 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function webSetting(){
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->webSettingPer==1)){
            $this->breadcrumbs->push($this->lang->line('edit_logo'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('edit_logo');


        $getLogo =  $this->Common_model->getDataFromTabel('Options', '*', array('option_name' => 'logo' ));
        $getFavicon =  $this->Common_model->getDataFromTabel('Options', '*', array('option_name' => 'favicon' ));

        $data['logo'] = !empty($getLogo) ? $getLogo[0] : "";
        $data['favicon'] = !empty($getFavicon) ? $getFavicon[0] : "";
        
        if($this->roleId==1 || ($this->webSettingPer==1)){
            $this->home_template->load('home_template','admin/settings/webSetting', $data);  
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }  
    }


     /*
    *  @access: public
    *  @Description: This method is used update template 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateLogo(){
        $logoArray= array();
        $favArray= array();
        $dirPath = 'uploads/logo_favicon';  
        //print_r($_FILES);die;
        if (isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"]!="") {
            $logoArray['option_value']='';
            $response=$this->uploadLogoImage("logo",$dirPath,"logo");
            //$response=$this->Common_model->uploadProfileImage("logo",$dirPath,"logo");
            if (!empty($response) && $response['status']=="error") {
                redirect(base_url('admin/settings/webSetting'));
            } else if(!empty($response) && $response['status']=="success") {
                $logoArray['option_value'] =$response['imageName'];
            }
        }

        if (isset($_FILES["favicon"]["name"]) && $_FILES["favicon"]["name"]!="") { 
            $favArray['option_value']="";
            $response=$this->Common_model->uploadProfileImage("favicon",$dirPath,"favicon");
                
            if (!empty($response) && $response['status']=="error") {
                redirect(base_url('admin/settings/webSetting'));
            } else if(!empty($response) && $response['status']=="success") {
                $favArray['option_value']=$response['imageName'];
            }
        }

        if(!empty($logoArray)){
            $this->Common_model->updateDataFromTabel("Options",$logoArray,array('option_name' => 'logo' ));
        } 
        if(!empty($favArray)){
            $this->Common_model->updateDataFromTabel("Options",$favArray,array('option_name' => 'favicon' ));
        }


        
        $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
        redirect(base_url('admin/settings/webSetting'));
    }


    /*
    *  @access: public
    *  @Description: This method is used load splash wallet details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function requestList(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->requestPer==1)){
            $this->breadcrumbs->push($this->lang->line('request_list'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        $data['title']=$this->lang->line('request_list');
        if($this->roleId==1 || ($this->requestPer==1)){
            $this->home_template->load('home_template','admin/settings/requestList', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    

     


    /*
    *  @access: public
    *  @Description: This method is use to filter data in agent list  
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function filterRequestlist(){
        
        $getPostData = $this->input->post();
        if(!empty($getPostData)){
            $this->session->set_userdata('postdata',$getPostData);
            redirect(base_url('admin/agent/index/search'));
        }
    }

     /*
    *  @access: public
    *  @description: This method is use to get business list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function requestajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==2){
                $column_name='firstname';
            }else if($order[0]['column']==3){
                $column_name='email';
            }else if($order[0]['column']==4){
                $column_name='mobile_no';
            }else{
                $column_name='firstname';
            }
        }

        $totalRecord      = $this->Setting_model->requestajaxlist(true);
        $getRecordListing = $this->Setting_model->requestajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
        
        $recordListing = array();
        $content='[';
        $i=0;       
        $srNumber=$start;       
        if(!empty($getRecordListing)) {
            $actionContent = '';
            foreach($getRecordListing as $recordData) {
                $actionContent = ''; // set default empty
                $content .='[';
                $recordListing[$i][0]= $srNumber+1;
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                $recordListing[$i][2]= $recordData->email;
                $recordListing[$i][3]= $recordData->phone_no;

                if($recordData->status=="Cancel"){
                    $reqCallStatus = "Canceled";
                }else if($recordData->status=="Solve"){
                    $reqCallStatus = "Solved";
                }else{
                    $reqCallStatus = $recordData->status;
                }
                
                $recordListing[$i][4]= $reqCallStatus;
                //$recordListing[$i][5]= $recordData->created_date;
                $recordListing[$i][5]= change_date_formate($recordData->created_date);
                //$recordListing[$i][6]= change_date_formate($recordData->created_date);
                
                $actionContent = '';
                if($recordData->status=='Pending'){
                    $table='Request_Call';
                    $field='status';
                    $urls = base_url('admin/settings/updateReqStatus');
                    $warning_msg=$this->lang->line('do_you_want_to_change_status');
                    $succ_msg= "Solve";//$this->lang->line('activated');
                    $status = "Solve";
                    
                    $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.',\''.$status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Complete">Solve</a> ';

                    $succ_msg1= $this->lang->line('cancel');
                    $status1 = "Cancel";
                    $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$status1.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg1.'\' );" title="Cancel">Cancel</a>';
                }else{
                    $actionContent .='<a class="btn bg-green waves-effect" disabled href="javascript:void(0);" title="Complete">Solve</a> ';
                    $actionContent .='<a class="btn bg-red waves-effect" disabled href="javascript:void(0);" title="Cancel">Cancel</a>';
                }


                
                
                // if($recordData->status=='1'){
                //     $succ_msg=$this->lang->line('activated');
                //     $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                // }else{ 
                //     $succ_msg=$this->lang->line('inactivated');
                //     $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Deactive">Deactive</a>';
                // }
                
                $recordListing[$i][6]= $actionContent;     
                
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
    *  @Description: This method is use to upload picture 
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function uploadLogoImage($name,$dirPath,$fileName) {
        $data = array();
        $response=array();
        if (isset($_FILES[$fileName]["name"]) && $_FILES[$fileName]["name"]!="") {
            $cdate= date("dmyHis");
            $imageName = str_replace(" ","-",$name).'-'.$cdate;
            //echo "<pre>"; print_r($imageName);die;
            $this->load->library('upload');
            $this->upload->initialize(set_upload_options($dirPath,'jpg|JPEG|PNG|png|jpeg',$imageName));
            $this->upload->do_upload($fileName);
            if($this->upload->display_errors()){
                $this->messages->setMessageFront($this->upload->display_errors(),'error');  
                return array("status" => 'error');
            }else{
                $data=$this->upload->data();
                // if(($data['image_width']<'180') || ($data['image_height']<'30')) {
                //     $this->messages->setMessageFront('The image you are attempting to upload should be greater than 220*70','error');   
                //     return array("status" => 'error');
                // } else {
                    $file_path=$dirPath.$data['file_name'];
                    
                    //$file_path=$restMenuFolderName.$data['file_name'];
                    $this->load->library('image_lib');
                    // clear config array
                    $config = array();
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = $file_path;
                    $config['maintain_ratio']   = TRUE;
                    $config['create_thumb']     = FALSE;
                    $response = array(
                        "status" => 'success',
                        "imageName" => $data['file_name'],
                        "width" => $data['image_width'],
                        "height" => $data['image_height']
                    );
                //}
            }
        }
        return $response;
    }


    /*
    *  @access: public
    *  @Description: This method is used load change password page 
    *  @modified by: gokul rathod
    *  @return: void
    */  
    public function changePassword(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
        if($this->roleId==1 || $this->roleId==3 || ($this->changePasswordPer==1)){
            $this->breadcrumbs->push($this->lang->line('change_password'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        $data['title']=$this->lang->line('change_password');
        if($this->roleId==1 || $this->roleId==3 || ($this->changePasswordPer==1)){
            $this->home_template->load('home_template','admin/settings/changepassword', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    


    /*
    *  @access: Public
    *  @description: This method is use to change password for a user
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
           
            $currentPassword = $this->Setting_model->getuserdata($userId);
            $currPass = $currentPassword->password;
            if($mdpass == $currPass){
                if($newPassword==$confPassword){
                    $insertId = $this->Setting_model->change_password($userId,$newmdPass);
                    if($insertId){
                        $this->messages->setMessageFront("Password Changed Successfully",'success');
                        redirect(base_url('admin/settings/changePassword'));
                    }
                }else{
                    $this->messages->setMessageFront("New password or confirm password not match",'error');
                    redirect(base_url('admin/settings/changePassword'));
                }
            }else{
                $this->messages->setMessageFront("Old Password Invalid",'error');
                redirect(base_url('admin/settings/changePassword'));
            }
        } 
        
    }


     /*
    *  @access: public
    *  @Description: This method is used load faq details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function faq(){   
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->faqPermission==1)){
            $this->breadcrumbs->push($this->lang->line('faq_list'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['faq_add']=$this->faqAddPer;
        $data['faq_delete']=$this->faq_delete;
        $data['title']=$this->lang->line('faq_list');
        
        if($this->roleId==1 || ($this->faqPermission==1)){
            $this->home_template->load('home_template','admin/settings/faqList', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    
     /*
    *  @access: public
    *  @description: This method is use to get faq list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function faqajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='category_name';
            }else if($order[0]['column']==2){
                $column_name='question';
            }else if($order[0]['column']==3){
                $column_name='answer';
            }else{
                $column_name='category_name';
            }
        }

        $totalRecord      = $this->Setting_model->faqajaxlist(true);
        $getRecordListing = $this->Setting_model->faqajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                
                //$recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';

                if($this->faq_delete==1){
                    $recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                }else{
                    $recordListing[$i][0]=  '<input type="checkbox" '.$this->buttonIcon.'  name="deleteId[]" value="" class="checkbox ischeckedaction"/>';
                }

                //$recordListing[$i][0]=  $srNumber+1;
                $recordListing[$i][1]= $recordData->category_name;
                $recordListing[$i][2]= $recordData->question;
                $recordListing[$i][3]= $recordData->answer;
                
                $actionContent = '';
                
                $table='Faq';
                $field='status';
                $urls = base_url('admin/category/updateStatus');
                $warning_msg=$this->lang->line('do_you_want_to_change_status');
                


                if($this->faq_status==1){
                   if($recordData->status=='1'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Deactive">Deactive</a>';
                    }

                }else{
                    if($recordData->status=='1'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-red waves-effect" href="#" title="Deactive">Deactive</a>';
                    }
                }
                
                $recordListing[$i][4]= $actionContent;              
                
                $actionContent = '';

                if($this->faq_edit==1){
                    $actionContent .='<a href="'.base_url('admin/settings/getFaqinfo/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                }else{
                    $actionContent .='<a href="#" '.$this->buttonIcon.' class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
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
    *  @Description: This method is used load add faq 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function addFaq(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->faqAddPer==1)){
            $this->breadcrumbs->push($this->lang->line('faq_list'), 'admin/settings/faq');
            $this->breadcrumbs->push($this->lang->line('add_faq'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */

        $data['button']=$this->lang->line('submit'); 
        $categoryDetails =  $this->Common_model->getDataFromTabel('Category', '*', array( 'status'=> 1));
        $data['categoryDetails'] = !empty($categoryDetails) ? $categoryDetails : "";
        $data['title']=$this->lang->line('add_faq');
        if($this->roleId==1 || ($this->faqAddPer==1)){
            $this->home_template->load('home_template','admin/settings/addFaq', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
        
    }
    
    
     /*
    *  @access: public
    *  @Description: This method is used save FAQ
    *  @auther: Gokul Rathod
    *  @return: void
    */  

    public function saveFaq(){
        if($this->input->post()){
            $this->form_validation->set_rules('category','category','required|trim');
            $this->form_validation->set_rules('question','question','required|trim');
            $this->form_validation->set_rules('answer','answer','required|trim');
            if($this->form_validation->run() === false){   
                $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                redirect(base_url('admin/settings/add'));
            }else{
                $datetime    = date('Y-m-d H:i:s'); 
                $data['type']  = 'Faq';
                $data['category_id']  = $this->input->post('category');
                $data['question']  = $this->input->post('question');
                $data['answer']  = $this->input->post('answer');
                $data['status']  = 1;
                $data['created_date']  = $datetime;
                
                $this->Common_model->addDataIntoTable("Faq",$data);
                $this->messages->setMessageFront($this->lang->line('added_successful'),'success');
                    redirect(base_url('admin/settings/faq'));
            }
        }
    }






     /*
    *  @access: public
    *  @Description: This method is used load virtual faq details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function virtualFaq(){  
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->virtualFaqPerm==1)){
            $this->breadcrumbs->push($this->lang->line('virtual_faq_list'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
        $data['add_virtual_faq']=$this->add_virtual_faq;
        $data['virtual_faq_delete']=$this->virtual_faq_delete;
        $data['title']=$this->lang->line('virtual_faq_list');
        if($this->roleId==1 || ($this->virtualFaqPerm==1)){
            $this->home_template->load('home_template','admin/settings/virtualFaqList', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    
      
     /*
    *  @access: public
    *  @description: This method is use to get virtual faq list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function virtualFaqajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='question';
            }else if($order[0]['column']==2){
                $column_name='answer';
            }else{
                $column_name='question';
            }
        }

        $totalRecord      = $this->Setting_model->virtualFaqajaxlist(true);
        $getRecordListing = $this->Setting_model->virtualFaqajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                
                
                if($this->virtual_faq_delete==1){
                    $recordListing[$i][0]=  '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                }else{
                    $recordListing[$i][0]=  '<input type="checkbox" '.$this->buttonIcon.'  name="deleteId[]" value="" class="checkbox ischeckedaction"/>';
                }

                $recordListing[$i][1]= $recordData->question;
                $recordListing[$i][2]= $recordData->answer;
                
                $actionContent = '';
                
                $table='Faq';
                $field='status';
                $urls = base_url('admin/category/updateStatus');
                $warning_msg=$this->lang->line('do_you_want_to_change_status');
                
                if($this->virtual_faq_status==1){
                   if($recordData->status=='1'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Deactive">Deactive</a>';
                    }

                }else{
                    if($recordData->status=='1'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="Active">Active</a>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-red waves-effect" href="#" title="Deactive">Deactive</a>';
                    }
                }
                
                $recordListing[$i][3]= $actionContent;              
                
                $actionContent = '';

                
                if($this->edit_virtual_faq==1){
                    $actionContent .='<a href="'.base_url('admin/settings/getVirtualFaqinfo/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                }else{
                    $actionContent .='<a href="#" '.$this->buttonIcon.' class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                }
                $recordListing[$i][4]= $actionContent;              
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
    *  @Description: This method is used load add faq 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function addVirtualFaq(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        if($this->roleId==1 || ($this->add_virtual_faq==1)){
            $this->breadcrumbs->push($this->lang->line('virtual_faq_list'), 'admin/settings/virtualFaq');
            $this->breadcrumbs->push($this->lang->line('add_virtual_faq'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        
        /*breadcrumb code end */
        $data['button']=$this->lang->line('submit'); 
        $data['title']=$this->lang->line('add_virtual_faq');
        if($this->roleId==1 || ($this->add_virtual_faq==1)){
            $this->home_template->load('home_template','admin/settings/addVirtualFaq', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    
    /*
    *  @access: public
    *  @Description: This method is used save virtual FAQ
    *  @auther: Gokul Rathod
    *  @return: void
    */  

    public function saveVirtualFaq(){
        if($this->input->post()){
            $this->form_validation->set_rules('faq_title','faq_title','required|trim');
            $this->form_validation->set_rules('faq_content','faq_content','required|trim');
            if($this->form_validation->run() === false){   
                $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                redirect(base_url('admin/settings/addVirtualFaq'));
            }else{
                $datetime    = date('Y-m-d H:i:s'); 
                $data['type']  = 'Virtual';
                $data['question']  = $this->input->post('faq_title');
                $data['answer']  = $this->input->post('faq_content');
                $data['status']  = 1;
                $data['created_date']  = $datetime;
                
                $this->Common_model->addDataIntoTable("Faq",$data);
                $this->messages->setMessageFront($this->lang->line('added_successful'),'success');
                redirect(base_url('admin/settings/virtualFaq'));
            }
        }
    }







/*
    *  @access: public
    *  @Description: This method is use to get faq info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
    public function getFaqinfo($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('faq_list'), 'admin/settings/faq');
        $this->breadcrumbs->push($this->lang->line('edit_faq'), '/');
        /*breadcrumb code end */
            
        if(!empty($id)){        
            $data['title']=$this->lang->line('edit_faq');
            $data['button']=$this->lang->line('update'); 
            $categoryDetails =  $this->Common_model->getDataFromTabel('Category', '*', array( 'status'=> 1));
            $data['categoryDetails'] = !empty($categoryDetails) ? $categoryDetails : "";

            $faqDetails =  $this->Common_model->getDataFromTabel('Faq', '*', array( 'id'=> decode($id)));
            $data['faqDetails'] = !empty($faqDetails) ? $faqDetails[0] : "";
            $this->home_template->load('home_template','admin/settings/addFaq', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }



   /*
    *  @access: public
    *  @Description: This method is used update faq 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateFaq($id=''){
        if(!empty($id)){
            if($this->input->post()){
                $this->form_validation->set_rules('category','category','required|trim');
                $this->form_validation->set_rules('question','question','required|trim');
                $this->form_validation->set_rules('answer','answer','required|trim');
                if($this->form_validation->run() === false){   
                    $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                    redirect(base_url('admin/settings/getFaqinfo/'.$id));
                }else{
                    $faqId = decode($id);
                    $data['category_id']  = $this->input->post('category');
                    $data['question']  = $this->input->post('question');
                    $data['answer']  = $this->input->post('answer');

                    $this->Common_model->updateDataFromTabel("Faq",$data,array('id'=>$faqId));
                    $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
                    redirect(base_url('admin/settings/faq'));
                }
            }
        }else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/settings/faq'));
        }
    }
   



/*
    *  @access: public
    *  @Description: This method is use to get Virtual Faq info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
    public function getVirtualFaqinfo($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('virtual_faq_list'), 'admin/settings/virtualFaq');
        $this->breadcrumbs->push($this->lang->line('edit_virtual_faq'), '/');
        /*breadcrumb code end */
        if(!empty($id)){    
            $data['title']=$this->lang->line('edit_virtual_faq');
            $data['button']=$this->lang->line('update'); 
            $faqDetails =  $this->Common_model->getDataFromTabel('Faq', '*', array( 'id'=> decode($id)));
            $data['faqDetails'] = !empty($faqDetails) ? $faqDetails[0] : "";
            $this->home_template->load('home_template','admin/settings/addVirtualFaq', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }



   /*
    *  @access: public
    *  @Description: This method is used update virtual faq 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateVirtualFaq($id=''){
        if(!empty($id)){
            if($this->input->post()){
                $this->form_validation->set_rules('faq_title','faq_title','required|trim');
                $this->form_validation->set_rules('faq_content','faq_content','required|trim');
                if($this->form_validation->run() === false){   
                    $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                    redirect(base_url('admin/settings/getVirtualFaqinfo/'.$id));
                }else{
                    $faqId = decode($id);
                    $data['question']  = $this->input->post('faq_title');
                    $data['answer']  = $this->input->post('faq_content');
                    
                    $this->Common_model->updateDataFromTabel("Faq",$data,array('id'=>$faqId));
                    $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
                    redirect(base_url('admin/settings/virtualFaq'));
                }
            }
        }else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/settings/virtualFaq'));
        }
    }


    /*
    *  @access: public
    *  @Description: This method is use to permanent delete faq detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */ 
    
    public function deleteFaq(){
        $postData = $this->input->post();
        $deleteIdArray  = $postData['deleteId'];
        if(!empty($deleteIdArray)){
           foreach($deleteIdArray as $deleteId){   
                // delete campaign data for restaurant
                $whereCondtion =  array('id' => $deleteId, 'type'=>'Faq');
                $this->Common_model->deleteRow('Faq',$whereCondtion);
            }
           
            $this->messages->setMessage($this->lang->line('faq_deleted_successfully'),'success');
            redirect(base_url('admin/settings/faq'));
        }else{
            $this->messages->setFrntMessage($this->lang->line('request_not_completed'), 'error');
            redirect(base_url('admin/settings/faq'));
        }
    }
    
    
    /*
    *  @access: public
    *  @Description: This method is use to permanent delete virtual faq detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */ 
    
    public function deleteVirtualFaq(){
        $postData = $this->input->post();
        $deleteIdArray  = $postData['deleteId'];
        if(!empty($deleteIdArray)){
           foreach($deleteIdArray as $deleteId){   
                // delete campaign data for virtual faq
                $whereCondtion =  array('id' => $deleteId, 'type'=>'Virtual');
                $this->Common_model->deleteRow('Faq',$whereCondtion);
            }
           
            $this->messages->setMessage($this->lang->line('virtual_faq_deleted_successfully'),'success');
            redirect(base_url('admin/settings/virtualFaq'));
        }else{
            $this->messages->setFrntMessage($this->lang->line('request_not_completed'), 'error');
            redirect(base_url('admin/settings/virtualFaq'));
        }
    }

     /*
    *  @access: public
    *  @Description: This method is used load all email 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function emailList(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
        $this->breadcrumbs->push('Email Template List', '/');
        /*breadcrumb code end */
        $data['title']='Email Template List';
        $this->home_template->load('home_template','admin/settings/emailList', $data);    
    }
    
     /*
    *  @access: public
    *  @description: This method is use to get email list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function emailajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $totalRecord      = $this->Setting_model->emailajaxlist(true);
        $getRecordListing = $this->Setting_model->emailajaxlist(false,$start,$length);
        
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
         
                $recordListing[$i][0]= $srNumber+1;
                $recordListing[$i][1]= $recordData->masterSubject;
                $recordListing[$i][2]= $recordData->masterContent;
                

                if($recordData->userType==1){
                    $recordListing[$i][3]= "Super Admin";
                }elseif($recordData->userType==2){
                    $recordListing[$i][3]= "Users";
                }elseif($recordData->userType==3){
                    $recordListing[$i][3]= "Merchant";
                }elseif($recordData->userType==4){
                    $recordListing[$i][3]= "Agent";
                }elseif($recordData->userType==5){
                    $recordListing[$i][3]= "Sub Admin";
                }elseif($recordData->userType==6){
                    $recordListing[$i][3]= "Distributor";
                }else{
                    $recordListing[$i][3]= "Users";
                }
                
                
                //blank for edit button
                $actionContent = '';
                
                $actionContent .='<a href="'.base_url('admin/settings/emailEditPage/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 

                //$url = base_url()."admin/Email/emailEditPage/".encode($recordData->id);
                //if($this->emailEdit==1){
                    //$actionContent .='<a class="btn default bg-gray btn-default" href="'.$url.'" title="Edit"><i class="fa fa-edit"></i></a>';
                // }else{
                //     $actionContent .='<a '.$this->buttonIcon.' class="btn default bg-gray btn-default" href="#" title="Edit"><i class="fa fa-edit"></i></a>';
                // }                
                
                $recordListing[$i][4]= $actionContent;
               
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


   
    public function emailEditPage($id=''){
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
        $this->breadcrumbs->push('Email Template List', '/admin/settings/emailList');
        $this->breadcrumbs->push('Edit Email Template', '/');
        /*breadcrumb code end */
        
        
        if (!empty($id)) {
            $data['title']='Edit Email Template';
            $emailId = decode($id);
            $sendData = array('id' => $emailId);
            $data['emailInfo'] = $this->Common_model->getDataFromTabel('email_template', '*', $sendData);
            $this->home_template->load('home_template','admin/settings/editEmail', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        } 
    }

   
    public function updateEmailInfo($id=''){
        $emailId = decode($id);
        $post = $this->input->post();
        if(!empty($post)){
            $this->form_validation->set_rules('subject','subject','required|trim');
            $this->form_validation->set_rules('email_template','email_template','required');
            if($this->form_validation->run() === false){
                $this->messages->setMessageFront('Invalid detail.','error');
                redirect("admin/settings/emailEditPage/".$id);
            }else{
                $updateData = array(
                                    'masterSubject' => $post['subject'],
                                    'masterContent' => $post['email_template'],
                                );
                $this->messages->setMessageFront("Update Successful",'success');
                $this->Common_model->updateDataFromTable('email_template',$updateData,'id',$emailId);
                redirect("admin/settings/emailList",'refresh');
            }
        }
    }
     
    
   /*
    *  @access: public
    *  @Description: This method is used load change fee charge page 
    *  @modified by: harish kumar
    *  @return: void
    */  
    public function changeTransactionCharge(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
       
        if($this->roleId==1){
            $this->breadcrumbs->push($this->lang->line('transaction_charge'), '/');
             $data['title']=$this->lang->line('transaction_charge');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
             $data['title']=$this->lang->line('permission_denied');
        }
        $data['charge_detail'] = $this->Common_model->get_fees_charge();
               
        if($this->roleId==1){
            $this->home_template->load('home_template','admin/settings/changeTransactionCharge', $data);    
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }
    }
    
      
    
   /*
    *  @access: public
    *  @Description: This method is used to save fee charge 
    *  @modified by: harish kumar
    *  @return: void
    */  
    public function saveFeeCharge(){ 
        $post = $this->input->post();
        
        
        if(!empty($post)){
            $this->form_validation->set_rules('charge_method','charge_method','required');
            $this->form_validation->set_rules('transaction_fee','transaction_fee','required');
            if($this->form_validation->run() === false){
                $this->messages->setMessageFront('Invalid detail.','error');
                redirect("admin/settings/changeTransactionCharge");
            }else{               
                $this->messages->setMessageFront("Update Successful",'success');
                $this->Common_model->save_fees_charge($post['charge_method'],$post['transaction_fee']);
                redirect("admin/settings/changeTransactionCharge",'refresh');
            }
        }
    }


}
