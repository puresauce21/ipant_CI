<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    /*
    *  @Description: This controller is use to manage Machine Module of Backend
    *  @auther: Gokul Rathod
    */ 
    class Machine extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Machine_model');
        $this->userId = $this->session->userdata('userId');// encode form
    } 
     
     
     /*
    *  @access: public
    *  @Description: This method is used load sub admin details 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function index(){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('machine_list'), '/');
        /*breadcrumb code end */
        
		$data['title']=$this->lang->line('machine_list');
        $this->home_template->load('home_template','admin/machine/machineList', $data);    
    }
    
    


     /*
    *  @access: public
    *  @description: This method is use to get business list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function machineajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='firstname';
            }else if($order[0]['column']==2){
                $column_name='email';
            }else if($order[0]['column']==3){
                $column_name='mobile_no';
            }else if($order[0]['column']==4){
                $column_name='role_name';
            }else{
                $column_name='id';
            }
        }
        $id= decode($this->userId);
        $totalRecord      = $this->Machine_model->machineajaxlist(true,$id);
        $getRecordListing = $this->Machine_model->machineajaxlist(false,$id,$start,$length, $column_name, $order[0]['dir']);
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
                
				$recordListing[$i][0]= '<input type="checkbox"  name="deleteId[]" value="'.$recordData->id.'" class="checkbox ischeckedaction"/>';
                $recordListing[$i][1]= $recordData->machine_number;
                $recordListing[$i][2]= $recordData->person_name;
                $recordListing[$i][3]= $recordData->email;
                $recordListing[$i][4]= $recordData->contact_number;
                $recordListing[$i][5]= $recordData->complex_name;

                $image = !empty($recordData->machine_image) ? $recordData->machine_image : '';
                
                $actionContent .='<img src="'.getImage($image,"machine_pic").'" class="show_menu_img" height="40" width="40"/>'; 


                $recordListing[$i][6]= $actionContent;
              
				$recordListing[$i][7]= $recordData->address;

				$actionContent = '';
				
                $actionContent .='<a href="'.base_url('admin/machine/getmachineDetail/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 

                $url = base_url('admin/machine/machineDelete');
                $actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteMachine('.$recordData->id.', \''.$url.'\');" class="btn btn-default" title="Delete"><i class="fa fa-trash"></i> </a>';

				$recordListing[$i][8]= $actionContent;   

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
    *  @Description: This method is use to load add business 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
	public function add(){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('machine_list'), 'admin/machine');
        $this->breadcrumbs->push($this->lang->line('add_machine'), '/');
        /*breadcrumb code end */
        
        $data['roleDetails'] =  $this->Common_model->getDataFromTabel('Roles', '*');
        $data['title']=$this->lang->line('add_machine');
        $data['button']=$this->lang->line('submit'); 
		$this->home_template->load('home_template','admin/machine/addMachine', $data);    
    }


    /*
    *  @access: public
    *  @Description: This method is used add sub-admin 
    *  @auther: Gokul Rathod
    *  @return: void
    */  

    
    public function save(){
		if($this->input->post()){
			$this->form_validation->set_rules('machine_number','machine_number','required|trim');
            $this->form_validation->set_rules('person_name','person_name','required|trim'); 
			$this->form_validation->set_rules('complex_name','complex_name','required|trim');	
			$this->form_validation->set_rules('email','email','required|trim');
            $this->form_validation->set_rules('mobile','mobile','required|trim');
            $this->form_validation->set_rules('address','address','required|trim');
			$this->form_validation->set_rules('comment','comment','required|trim');
            
			
			if($this->form_validation->run() === false){   
				$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
				redirect(base_url('admin/machine'));
			}else{
                $data['user_id']        = decode($this->userId);
				$data['machine_number'] = $this->input->post('machine_number');
                $data['person_name']    = $this->input->post('person_name');
				$data['complex_name']   = $this->input->post('complex_name');
				$data['email']          = $this->input->post('email');
                $data['contact_number'] = $this->input->post('mobile');
                $data['address']        = $this->input->post('address');
				$data['comment']        = $this->input->post('comment');
            	$data['creation_date_time'] = date('Y-m-d H:i:s');
				$oldImageName = !empty($this->input->post('oldImageName')) ? $this->input->post('oldImageName') : '';
				$dirPath = 'uploads/machine_pic';

				if (isset($_FILES["machineProfile"]["name"]) && $_FILES["machineProfile"]["name"]!="") {
					$response=$this->Common_model->uploadProfileImage("admin",$dirPath,"machineProfile");
					$data['machine_image'] = '';
					if (!empty($response) && $response['status']=="error") {
						redirect(base_url('admin/machine')); 
					} else if(!empty($response) && $response['status']=="success") {
						$data['machine_image']=$response['imageName'];
					}
				}

				$this->Common_model->addDataIntoTable($this->db->dbprefix."Machine_Detail",$data);
				$this->messages->setMessageFront($this->lang->line('added_successful'),'success');
				redirect(base_url('admin/machine'));
			}
		}
	}
		



    public function role(){
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('staffs_list'), 'admin/subadmin/roleList');
        $this->breadcrumbs->push($this->lang->line('add_role'), '/');
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('add_role');
        $data['button']=$this->lang->line('submit'); 
        $this->home_template->load('home_template','admin/subadmin/addRole', $data);    
    }


     public function addRole(){
        if($this->input->post()){
            $this->form_validation->set_rules('role','role','required|trim');
            
            if($this->form_validation->run() === false){   
                $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                redirect(base_url('admin/subadmin/role'));
            }else{
                $data['role_name']  = $this->input->post('role');
                $data['is_login_admin']  = 1;
                $data['created_by']   = decode($this->userId);
                $data['last_updated_date_time']    = date('Y-m-d H:i:s');
                $data['creation_date_time'] = date('Y-m-d H:i:s');
                
                $returnId=$this->Common_model->addDataIntoTable("Roles",$data);
                if(!empty($returnId)){                  
                    $this->Common_model->addDataIntoTable("admin_roles_permission",array('roleid'=>$returnId));
                }
                $this->messages->setMessageFront($this->lang->line('added_successful'),'success');
                redirect(base_url('admin/subadmin/roleList'));
            }
        }
    }




    public function roleList(){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('role_list'), '/');
        /*breadcrumb code end */
        
        $data['title']=$this->lang->line('role_list');
        $this->home_template->load('home_template','admin/subadmin/roleList', $data);    
    }
    
    


     /*
    *  @access: public
    *  @description: This method is use to get business list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function roleajaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='role_name';
            }else if($order[0]['column']==2){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }
        

        $totalRecord      = $this->Subadmin_model->roleajaxlist(true);
        $getRecordListing = $this->Subadmin_model->roleajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                $recordListing[$i][1]= $recordData->role_name;
                $recordListing[$i][2]= change_date_formate($recordData->creation_date_time);
                //$recordListing[$i][3]= $recordData->creation_date_time;
                
                /*$actionContent = '';
                
                $table='Users';
                $field='status';
                $urls = base_url('admin/subadmin/updateStatus');
                $warning_msg=$this->lang->line('do_you_want_to_change_status');
                if($recordData->status=='1'){
                    $succ_msg=$this->lang->line('activated');
                    $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="Active">Active</a>';
                }else{ 
                    $succ_msg=$this->lang->line('inactivated');
                    $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="Deactive">Deactive</a>';
                }
            
                $recordListing[$i][5]= $actionContent;              
*/
                $actionContent = '';
                
                $actionContent .='<a href="'.base_url('admin/subadmin/getRoleDetail/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                
                $actionContent .='<a href="'.base_url('admin/subadmin/permission/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"></i>set permission</a> '; 

               // $url = base_url('admin/subadmin/subadminDelete');
               //$actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteSubAdmin('.$recordData->id.', \''.$url.'\');" class="btn btn-default" title="Delete"><i class="fa fa-trash"></i> </a>';

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
    *  @Description: This method is use to get business info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
    public function getRoleDetail($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('role_list'), 'admin/subadmin');
        $this->breadcrumbs->push($this->lang->line('edit_role'), '/');
        /*breadcrumb code end */
        if(!empty($id)){
            $data['title']=$this->lang->line('edit_role');
            $data['button']=$this->lang->line('update'); 
            $roleDetails =  $this->Common_model->getDataFromTabel('Roles', '*', array( 'id'=> decode($id), 'is_login_admin' => 1));
            $data['roleDetails'] = !empty($roleDetails) ? $roleDetails[0] : "";
            $this->home_template->load('home_template','admin/subadmin/addRole', $data);       
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }


    /*
    *  @access: public
    *  @Description: This method is used update user profile detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateRole($id=''){
        if(!empty($id)){
            if($this->input->post()){
                $this->form_validation->set_rules('role','role','required|trim');
                
                if($this->form_validation->run() === false){   
                    $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                    redirect(base_url('admin/subadmin/getRoleDetail/'. $id));
                }else{
                    $data['role_name']  = $this->input->post('role');
                    $data['last_updated_date_time']  = date('Y-m-d H:i:s');
                    
                    $this->Common_model->updateDataFromTabel("Roles",$data,array('id'=>decode($id)));
                    $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
                    redirect(base_url('admin/subadmin/roleList'));
                }
            }
        }else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/subadmin/roleList'));
        }
    }
	



   /*
    *  @access: public
    *  @Description: This method is use to get business info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
    public function getmachineDetail($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('machine_list'), 'admin/machine');
        $this->breadcrumbs->push($this->lang->line('edit_machine'), '/');
        /*breadcrumb code end */
        if(!empty($id)){
            $data['roleDetails'] =  $this->Common_model->getDataFromTabel('Roles', '*');
            $data['title']=$this->lang->line('edit_machine');
            $data['button']=$this->lang->line('update'); 
            $machineDetails =  $this->Common_model->getDataFromTabel('Machine_Detail', '*', array( 'id'=> decode($id)));
            $data['machineDetails'] = !empty($machineDetails) ? $machineDetails[0] : "";
            $this->home_template->load('home_template','admin/machine/addMachine', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }


    /*
    *  @access: public
    *  @Description: This method is used update user profile detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    
    public function updateMachine($id=''){
        if(!empty($id)){
			if($this->input->post()){
                $this->form_validation->set_rules('machine_number','machine_number','required|trim');
                $this->form_validation->set_rules('person_name','person_name','required|trim'); 
                $this->form_validation->set_rules('complex_name','complex_name','required|trim');   
                $this->form_validation->set_rules('mobile','mobile','required|trim');
                $this->form_validation->set_rules('address','address','required|trim');
                $this->form_validation->set_rules('comment','comment','required|trim');

				if($this->form_validation->run() === false){   
					$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
					redirect(base_url('admin/machine/getmachineDetail/'. $id));
				}else{
                    $data['machine_number']  = $this->input->post('machine_number');
                    $data['person_name']   = $this->input->post('person_name');
                    $data['complex_name']   = $this->input->post('complex_name');
                    $data['contact_number'] = $this->input->post('mobile');
                    $data['address'] = $this->input->post('address');
                    $data['comment'] = $this->input->post('comment');
                    $oldImageName = !empty($this->input->post('oldImageName')) ? $this->input->post('oldImageName') : '';
                    $dirPath = 'uploads/machine_pic';

                    if (isset($_FILES["machineProfile"]["name"]) && $_FILES["machineProfile"]["name"]!="") {
                        $response=$this->Common_model->uploadProfileImage("admin",$dirPath,"machineProfile");
                        $data['machine_image'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/machine')); 
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['machine_image']=$response['imageName'];
                        }
                    }

					$this->Common_model->updateDataFromTabel($this->db->dbprefix."Machine_Detail",$data,array('id'=>decode($id)));
					$this->messages->setMessageFront($this->lang->line('update_successful'),'success');
					redirect(base_url('admin/machine'));
				}
			}
		}else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/machine'));
        }
	}


    /*
    *  @access: public
    *  @Description: This method is used to remove sub-admin
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function machineDelete(){
        $id = $this->input->post('id');
        $whereCondtion  = array('id'=>$id);
        $ids=$this->Common_model->deleteRow($this->db->dbprefix.'Machine_Detail',$whereCondtion);  
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
    *  @Description: This method is use to permanent delete user detail 
    *  @auther: Gokul Rathod
    *  @return: void
    */ 
    
    public function deleteMachine(){
        $postData = $this->input->post();
        $deleteIdArray  = $postData['deleteId'];
        if(!empty($deleteIdArray)){
           foreach($deleteIdArray as $deleteId){   
                // delete all user data
                $whereCondtion  = array('id'=>$deleteId);
                $this->Common_model->deleteRow($this->db->dbprefix.'Machine_Detail',$whereCondtion);
            }
           
            $this->messages->setMessage($this->lang->line('machine_deleted_successfully'),'success');
            redirect(base_url('admin/machine'));
        }else{
            $this->messages->setFrntMessage($this->lang->line('request_not_completed'), 'error');
            redirect(base_url('admin/machine'));
        }
    }
    

	  /*
    *  @access: public
    *  @Description: This method is use to change status
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

			if($userStatus=='1'){
				$status='0';
			}else{
				$status='1';
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
    *  @Description: This method is email exit
    *  @auther: Gokul Rathod
    *  @return: void
    */ 
    
    function getemail(){
        $email=$this->input->post('emailId');
        if($this->Machine_model->emailExists($email)){
            $returnData = array('isSuccess'=>true);
        }else{
            $returnData = array('isSuccess'=>false);
        }
        echo json_encode($returnData); 
    }

      /*
    *  @access: public
    *  @Description: This method is use to get all permission details
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function permission($id=""){
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('staffs_list'), 'admin/subadmin/roleList');
        $this->breadcrumbs->push($this->lang->line('set_permission'), '/');
        /*breadcrumb code end */
        $data['title']=$this->lang->line('set_permission_for');
        
        $role_name =  $this->Common_model->getDataFromTabel('Roles', 'role_name', array('id'=>decode($id)));
        $role_name =!empty($role_name) ? $role_name[0] : "";
             //echo "<pre>"; print_r($role_name);die();
        $data['role_name']= $role_name->role_name;
        $data['permission']     =  $this->Common_model->getDataFromTabel('admin_roles_permission', '*', array('roleid'=>decode($id)));
        $this->home_template->load('home_template','admin/subadmin/permission', $data);    
    }



     /*
    *  @access: public
    *  @Description: This method is use to set permission
    *  @modified by: Gokul Rathod
    *  @return: void
    */
    
    public function setPermission(){

        if($this->input->post('dashboard')=="0" || $this->input->post('dashboard')=="1"){
            $data['dashboard']=1;
        }else{
            $data['dashboard']=0;
        }
        if($this->input->post('user_list')=="0" || $this->input->post('user_list')=="1"){
            $data['user_list']=1;
        }else{
            $data['user_list']=0;
        }
        if($this->input->post('user_edit')=="0" || $this->input->post('user_edit')=="1"){
            $data['user_edit']=1;
        }else{
            $data['user_edit']=0;
        }
        if($this->input->post('user_status')=="0" || $this->input->post('user_status')=="1"){
            $data['user_status']=1;
        }else{
            $data['user_status']=0;
        }
        if($this->input->post('user_view')=="0" || $this->input->post('user_view')=="1"){
            $data['user_view']=1;
        }else{
            $data['user_view']=0;
        }

        if($this->input->post('user_delete')=="0" || $this->input->post('user_delete')=="1"){
            $data['user_delete']=1;
        }else{
            $data['user_delete']=0;
        }
        if($this->input->post('merchant_list')=="0" || $this->input->post('merchant_list')=="1"){
            $data['merchant_list']=1;
        }else{
            $data['merchant_list']=0;
        }
        if($this->input->post('add_merchant')=="0" || $this->input->post('add_merchant')=="1"){
            $data['add_merchant']=1;
        }else{
            $data['add_merchant']=0;
        }
        if($this->input->post('edit_merchant')=="0" || $this->input->post('edit_merchant')=="1"){
            $data['edit_merchant']=1;
        }else{
            $data['edit_merchant']=0;
        }
        if($this->input->post('merchant_status')=="0" || $this->input->post('merchant_status')=="1"){
            $data['merchant_status']=1;
        }else{
            $data['merchant_status']=0;
        }
        if($this->input->post('merchant_view')=="0" || $this->input->post('merchant_view')=="1"){
            $data['merchant_view']=1;
        }else{
            $data['merchant_view']=0;
        }
        
        if($this->input->post('agent_list')=="0" || $this->input->post('agent_list')=="1"){
            $data['agent_list']=1;
        }else{
            $data['agent_list']=0;
        }
        if($this->input->post('add_agent')=="0" || $this->input->post('add_agent')=="1"){
            $data['add_agent']=1;
        }else{
            $data['add_agent']=0;
        }
        if($this->input->post('edit_agent')=="0" || $this->input->post('edit_agent')=="1"){
            $data['edit_agent']=1;
        }else{
            $data['edit_agent']=0;
        }
        if($this->input->post('agent_status')=="0" || $this->input->post('agent_status')=="1"){
            $data['agent_status']=1;
        }else{
            $data['agent_status']=0;
        }
        if($this->input->post('distributor_list')=="0" || $this->input->post('distributor_list')=="1"){
            $data['distributor_list']=1;
        }else{
            $data['distributor_list']=0;
        }
        if($this->input->post('add_distributor')=="0" || $this->input->post('add_distributor')=="1"){
            $data['add_distributor']=1;
        }else{
            $data['add_distributor']=0;
        }
        
        if($this->input->post('edit_distributor')=="0" || $this->input->post('edit_distributor')=="1"){
            $data['edit_distributor']=1;
        }else{
            $data['edit_distributor']=0;
        }

        if($this->input->post('distributor_status')=="0" || $this->input->post('distributor_status')=="1"){
            $data['distributor_status']=1;
        }else{
            $data['distributor_status']=0;
        }

        if($this->input->post('transactions_list')=="0" || $this->input->post('transactions_list')=="1"){
            $data['transactions_list']=1;
        }else{
            $data['transactions_list']=0;
        }
        if($this->input->post('Withdrawal_list')=="0" || $this->input->post('Withdrawal_list')=="1"){
            $data['Withdrawal_list']=1;
        }else{
            $data['Withdrawal_list']=0;
        }
        if($this->input->post('deposit_list')=="0" || $this->input->post('deposit_list')=="1"){
            $data['deposit_list']=1;
        }else{
            $data['deposit_list']=0;
        }
        if($this->input->post('sendmoney_list')=="0" || $this->input->post('sendmoney_list')=="1"){
            $data['sendmoney_list']=1;
        }else{
            $data['sendmoney_list']=0;
        }
        
        if($this->input->post('requestmoney_list')=="0" || $this->input->post('requestmoney_list')=="1"){
            $data['requestmoney_list']=1;
        }else{
            $data['requestmoney_list']=0;
        }

        if($this->input->post('sharebill_list')=="0" || $this->input->post('sharebill_list')=="1"){
            $data['sharebill_list']=1;
        }else{
            $data['sharebill_list']=0;
        }
        if($this->input->post('sharebill_detail')=="0" || $this->input->post('sharebill_detail')=="1"){
            $data['sharebill_detail']=1;
        }else{
            $data['sharebill_detail']=0;
        }
        if($this->input->post('qrcodes_list')=="0" || $this->input->post('qrcodes_list')=="1"){
            $data['qrcodes_list']=1;
        }else{
            $data['qrcodes_list']=0;
        }
        if($this->input->post('business_list')=="0" || $this->input->post('business_list')=="1"){
            $data['business_list']=1;
        }else{
            $data['business_list']=0;
        }
        if($this->input->post('add_business')=="0" || $this->input->post('add_business')=="1"){
            $data['add_business']=1;
        }else{
            $data['add_business']=0;
        }
        if($this->input->post('edit_business')=="0" || $this->input->post('edit_business')=="1"){
            $data['edit_business']=1;
        }else{
            $data['edit_business']=0;
        }
        if($this->input->post('business_status')=="0" || $this->input->post('business_status')=="1"){
            $data['business_status']=1;
        }else{
            $data['business_status']=0;
        }
        if($this->input->post('category_list')=="0" || $this->input->post('category_list')=="1"){
            $data['category_list']=1;
        }else{
            $data['category_list']=0;
        }
        if($this->input->post('add_category')=="0" || $this->input->post('add_category')=="1"){
            $data['add_category']=1;
        }else{
            $data['add_category']=0;
        } 
        if($this->input->post('edit_category')=="0" || $this->input->post('edit_category')=="1"){
            $data['edit_category']=1;
        }else{
            $data['edit_category']=0;
        }
        if($this->input->post('category_status')=="0" || $this->input->post('category_status')=="1"){
            $data['category_status']=1;
        }else{
            $data['category_status']=0;
        }
        if($this->input->post('feedback_list')=="0" || $this->input->post('feedback_list')=="1"){
            $data['feedback_list']=1;
        }else{
            $data['feedback_list']=0;
        }
        if($this->input->post('request_list')=="0" || $this->input->post('request_list')=="1"){
            $data['request_list']=1;
        }else{
            $data['request_list']=0;
        }
        if($this->input->post('viewTrsLimit')=="0" || $this->input->post('viewTrsLimit')=="1"){
            $data['viewTrsLimit']=1;
        }else{
            $data['viewTrsLimit']=0;
        }
        if($this->input->post('add_money')=="0" || $this->input->post('add_money')=="1"){
            $data['add_money']=1;
        }else{
            $data['add_money']=0;
        }
        if($this->input->post('send_money')=="0" || $this->input->post('send_money')=="1"){
            $data['send_money']=1;
        }else{
            $data['send_money']=0;
        }
        if($this->input->post('withdrawal_money')=="0" || $this->input->post('withdrawal_money')=="1"){
            $data['withdrawal_money']=1;
        }else{
            $data['withdrawal_money']=0;
        }
        
        if($this->input->post('cashout')=="0" || $this->input->post('cashout')=="1"){
            $data['cashout']=1;
        }else{
            $data['cashout']=0;
        }
        if($this->input->post('faq_list')=="0" || $this->input->post('faq_list')=="1"){
            $data['faq_list']=1;
        }else{
            $data['faq_list']=0;
        }
        if($this->input->post('faq_add')=="0" || $this->input->post('faq_add')=="1"){
            $data['faq_add']=1;
        }else{
            $data['faq_add']=0;
        }
        if($this->input->post('faq_edit')=="0" || $this->input->post('faq_edit')=="1"){
            $data['faq_edit']=1;
        }else{
            $data['faq_edit']=0;
        }
        if($this->input->post('faq_status')=="0" || $this->input->post('faq_status')=="1"){
            $data['faq_status']=1;
        }else{
            $data['faq_status']=0;
        }
        if($this->input->post('faq_delete')=="0" || $this->input->post('faq_delete')=="1"){
            $data['faq_delete']=1;
        }else{
            $data['faq_delete']=0;
        }
        if($this->input->post('virtual_faq_list')=="0" || $this->input->post('virtual_faq_list')=="1"){
            $data['virtual_faq_list']=1;
        }else{
            $data['virtual_faq_list']=0;
        }
        if($this->input->post('add_virtual_faq')=="0" || $this->input->post('add_virtual_faq')=="1"){
            $data['add_virtual_faq']=1;
        }else{
            $data['add_virtual_faq']=0;
        }
        if($this->input->post('edit_virtual_faq')=="0" || $this->input->post('edit_virtual_faq')=="1"){
            $data['edit_virtual_faq']=1;
        }else{
            $data['edit_virtual_faq']=0;
        }
        if($this->input->post('virtual_faq_status')=="0" || $this->input->post('virtual_faq_status')=="1"){
            $data['virtual_faq_status']=1;
        }else{
            $data['virtual_faq_status']=0;
        }
        if($this->input->post('virtual_faq_delete')=="0" || $this->input->post('virtual_faq_delete')=="1"){
            $data['virtual_faq_delete']=1;
        }else{
            $data['virtual_faq_delete']=0;
        }
        if($this->input->post('tutorialSplashWallet')=="0" || $this->input->post('tutorialSplashWallet')=="1"){
            $data['tutorialSplashWallet']=1;
        }else{
            $data['tutorialSplashWallet']=0;
        }

        if($this->input->post('tutorialSplashWalletStatus')=="0" || $this->input->post('tutorialSplashWalletStatus')=="1"){
            $data['tutorialSplashWalletStatus']=1;
        }else{
            $data['tutorialSplashWalletStatus']=0;
        }
        if($this->input->post('tutorialSplashWalletDelete')=="0" || $this->input->post('tutorialSplashWalletDelete')=="1"){
            $data['tutorialSplashWalletDelete']=1;
        }else{
            $data['tutorialSplashWalletDelete']=0;
        }
        if($this->input->post('tutorialSplashWalletMulDelete')=="0" || $this->input->post('tutorialSplashWalletMulDelete')=="1"){
            $data['tutorialSplashWalletMulDelete']=1;
        }else{
            $data['tutorialSplashWalletMulDelete']=0;
        }
        if($this->input->post('tutorialSplashMaster')=="0" || $this->input->post('tutorialSplashMaster')=="1"){
            $data['tutorialSplashMaster']=1;
        }else{
            $data['tutorialSplashMaster']=0;
        }
        if($this->input->post('tutorialSplashMasterStatus')=="0" || $this->input->post('tutorialSplashMasterStatus')=="1"){
            $data['tutorialSplashMasterStatus']=1;
        }else{
            $data['tutorialSplashMasterStatus']=0;
        }
        if($this->input->post('tutorialSplashMasterDelete')=="0" || $this->input->post('tutorialSplashMasterDelete')=="1"){
            $data['tutorialSplashMasterDelete']=1;
        }else{
            $data['tutorialSplashMasterDelete']=0;
        }
        if($this->input->post('tutorialSplashMasterMulDelete')=="0" || $this->input->post('tutorialSplashMasterMulDelete')=="1"){
            $data['tutorialSplashMasterMulDelete']=1;
        }else{
            $data['tutorialSplashMasterMulDelete']=0;
        }
       



        if($this->input->post('addTutSpwalletMaster')=="0" || $this->input->post('addTutSpwalletMaster')=="1"){
            $data['addTutSpwalletMaster']=1;
        }else{
            $data['addTutSpwalletMaster']=0;
        }
        if($this->input->post('web_setting')=="0" || $this->input->post('web_setting')=="1"){
            $data['web_setting']=1;
        }else{
            $data['web_setting']=0;
        }
       
        if($this->input->post('change_password')=="0" || $this->input->post('change_password')=="1"){
            $data['change_password']=1;
        }else{
            $data['change_password']=0;
        }
        
        $permissionArray=serialize($data);
        $per_id =$this->input->post('per_id');
        $per_role_id = $this->input->post('per_role_id');
        
        $upWhere = array('id'=>$per_id,'roleid'=>$per_role_id);
        $adminRole = array('permission'=>$permissionArray);        

        // $upWhere = array('roleid'=>'5');
        // $adminRole = array('permission'=>$permissionArray);
        $this->Common_model->updateDataFromTabel("admin_roles_permission",$adminRole,$upWhere);
        
        $this->messages->setMessageFront("Updated Successful",'success');
        redirect(base_url('admin/subadmin/permission'));
    }

}



