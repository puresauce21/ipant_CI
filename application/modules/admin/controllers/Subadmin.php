<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    /*
    *  @Description: This controller is use to manage Sub-admin Module of Backend
    *  @auther: Gokul Rathod
    */ 
    class Subadmin extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Subadmin_model');
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
        $this->breadcrumbs->push($this->lang->line('staffs_list'), '/');
        /*breadcrumb code end */
        
		$data['title']=$this->lang->line('staffs_list');
        $this->home_template->load('home_template','admin/subadmin/subadminList', $data);    
    }  
     /*
    *  @access: public
    *  @description: This method is use to get business list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function subadminajaxlist(){
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

        $totalRecord      = $this->Subadmin_model->subadminajaxlist(true);
        $getRecordListing = $this->Subadmin_model->subadminajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                $recordListing[$i][2]= $recordData->email;
                $recordListing[$i][3]= $recordData->mobile_no;
                $recordListing[$i][4]= $recordData->role_name;

                $image = !empty($recordData->profile_pic) ? $recordData->profile_pic : '';
                
                $actionContent .='<img src="'.getImage($image,"admin_profile").'" class="show_menu_img" height="40" width="40"/>'; 


                $recordListing[$i][5]= $actionContent;

                $actionContent = '';
                
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
                
				$recordListing[$i][6]= $actionContent;              

				$actionContent = '';
				//$actionContent .='<a href="'.base_url('admin/subadmin/getsubadminDetail/'.encode($recordData->id)).'" class="btn btn-default" title="'.$this->lang->line('edit').'"><i class="fa fa-edit"></i> </a> '; 
				
                $actionContent .='<a href="'.base_url('admin/subadmin/getsubadminDetail/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 

                $url = base_url('admin/subadmin/subadminDelete');
                $actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteSubAdmin('.$recordData->id.', \''.$url.'\');" class="btn btn-default" title="Delete"><i class="fa fa-trash"></i> </a>';

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
    *  @Description: This method is use to load add business 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
	public function add(){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('staffs_list'), 'admin/subadmin');
        $this->breadcrumbs->push($this->lang->line('add_staff'), '/');
        /*breadcrumb code end */
        
        $data['roleDetails'] =  $this->Common_model->getDataFromTabel('ipant_Roles', '*',array('id' =>3));
        
        $data['title']=$this->lang->line('add_staff');
        $data['button']=$this->lang->line('submit'); 
		$this->home_template->load('home_template','admin/subadmin/addSubadmin', $data);    
    }


    /*
    *  @access: public
    *  @Description: This method is used add sub-admin 
    *  @auther: Gokul Rathod
    *  @return: void
    */  

    public function save(){
		if($this->input->post()){
			$this->form_validation->set_rules('firstname','firstname','required|trim');
			$this->form_validation->set_rules('lastname','lastname','required|trim');	
			$this->form_validation->set_rules('email','email','required|trim|valid_email|is_unique[Users.email]');
			//$this->form_validation->set_rules('password','password','required|trim');	
			$this->form_validation->set_rules('mobile','mobile','required|trim|is_unique[Users.mobile_no]');
            $this->form_validation->set_rules('role_id','role_id','required|trim');
            
			
			if($this->form_validation->run() === false){   
				$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
				redirect(base_url('admin/subadmin'));
			}else{
				$data['firstname']  = $this->input->post('firstname');
				$data['lastname']   = $this->input->post('lastname');
				$data['email'] = $this->input->post('email');
				$password=$this->input->post('password');
				//$data['password'] = encrypt_password($password);
				$data['mobile_no'] = $this->input->post('mobile');
				$data['role_id']   = $this->input->post('role_id');
				$data['status']    = '1';
            	$data['creation_date_time'] = date('Y-m-d H:i:s');
				$oldImageName = !empty($this->input->post('oldImageName')) ? $this->input->post('oldImageName') : '';
				$dirPath = 'uploads/admin_profile';
                 
				if (isset($_FILES["adminProfile"]["name"]) && $_FILES["adminProfile"]["name"]!="") {
					$response=$this->Common_model->uploadProfileImage("admin",$dirPath,"adminProfile");
					
					if (!empty($response) && $response['status']=="error") {
						redirect(base_url('admin/subadmin')); 
					} else if(!empty($response) && $response['status']=="success") {
						$data['profile_pic']=$response['imageName'];
					}
				}else{
                    $data['profile_pic'] = 'default.png';
                }
				$user_id=$this->Common_model->addDataIntoTable("Users",$data);

                //--------------get template data----------------------
                    $whereCondtion = array('templateKey'=>'staff_register', 'userType'=>3);
                    $templateresponse =  $this->Common_model->getDataFromTabel('email_template','*',$whereCondtion);
                    $templateresponse = (!empty($templateresponse))?$templateresponse[0]:'';
                    
                     $imagePath  = base_url("uploads/logo_favicon/ipant-Logo-white.png");
                    
                    $image_logo  = '<img src='.$imagePath.' alt="Image Logo" height="50px;" >';
                    $userEmail      =  $this->input->post('email');
                    $fullName       =  $this->input->post('firstname').' '.$this->input->post('lastname');
                    $newPassword    =   randomnumber('6');
                    $clickLink      =   base_url('login');
                    $regards        =   'ipant';
                    
                    //update password into database
                    $this->Common_model->updateDataFromTabel("Users",array('password'=>encrypt_password($newPassword)),array('id'=>$user_id)); 

                    // if template exist 
                    if(!empty($templateresponse)){
                        $templdateSub      = (!empty($templateresponse->masterSubject))?$templateresponse->masterSubject:'';
                        $templdateBody     = (!empty($templateresponse->masterContent))?$templateresponse->masterContent:'';
                        $parseArray        = array("{image_logo}" , "{fullName}" , "{Password}" ,"{Email}", "{clickLink}" , "{regards}");
                        $replaceArray      = array($image_logo,$fullName,$newPassword,$userEmail,$clickLink,$regards);
                        $templateBodyReady = str_replace($parseArray, $replaceArray, $templdateBody);
                    }
                    
                    //--------------load email template----------------
                    $this->sendmail->sendmailto($userEmail,'Successfull Register for ipant Staff',$templateBodyReady);

				$this->messages->setMessageFront($this->lang->line('added_successful'),'success');
				redirect(base_url('admin/subadmin'));
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
   
    public function getsubadminDetail($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('brf_list'), 'admin/subadmin');
        $this->breadcrumbs->push($this->lang->line('edit_brf'), '/');
        /*breadcrumb code end */
        if(!empty($id)){
            $data['roleDetails'] =  $this->Common_model->getDataFromTabel('Roles', '*',array('id' => 3));
            $data['title']=$this->lang->line('edit_brf');
            $data['button']=$this->lang->line('update'); 
            $subadminDetails =  $this->Common_model->getDataFromTabel('Users', '*', array( 'id'=> decode($id), 'role_id' => 3));
            $data['subadminDetails'] = !empty($subadminDetails) ? $subadminDetails[0] : "";
           //echo "<pre>";print_r($data['subadminDetails']);die;

            $this->home_template->load('home_template','admin/subadmin/addSubadmin', $data);    
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
    
    public function updateSubadmin($id=''){
        if(!empty($id)){
			if($this->input->post()){
				$this->form_validation->set_rules('firstname','firstname','required|trim');
                $this->form_validation->set_rules('lastname','lastname','required|trim');   
               // $this->form_validation->set_rules('mobile','mobile','required|trim');
                $this->form_validation->set_rules('role_id','role_id','required|trim');

				if($this->form_validation->run() === false){   
					$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
					redirect(base_url('admin/subadmin/getsubadminDetail/'. $id));
				}else{
                    $data['firstname']  = $this->input->post('firstname');
                    $data['lastname']   = $this->input->post('lastname');
                    //$data['mobile_no'] = $this->input->post('mobile');
                    $data['role_id']   = $this->input->post('role_id');
                    $oldImageName = !empty($this->input->post('oldImageName')) ? $this->input->post('oldImageName') : '';
                    $dirPath = 'uploads/admin_profile';

                    if (isset($_FILES["adminProfile"]["name"]) && $_FILES["adminProfile"]["name"]!="") {
                        $response=$this->Common_model->uploadProfileImage("admin",$dirPath,"adminProfile");
                        $data['profile_pic'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/subadmin')); 
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['profile_pic']=$response['imageName'];
                        }
                    }

					$this->Common_model->updateDataFromTabel("Users",$data,array('id'=>decode($id)));
					$this->messages->setMessageFront($this->lang->line('update_successful'),'success');
					redirect(base_url('admin/subadmin'));
				}
			}
		}else{
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
            redirect(base_url('admin/subadmin'));
        }
	}


    /*
    *  @access: public
    *  @Description: This method is used to remove sub-admin
    *  @auther: Gokul Rathod
    *  @return: void
    */  
    public function subadminDelete(){
        $id = $this->input->post('id');
        $whereCondtion  = array('id'=>$id, 'role_id'=>3 );
        $ids=$this->Common_model->deleteRow('Users',$whereCondtion);  
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
    
    public function deleteSubAdmin(){
        $postData = $this->input->post();
        $deleteIdArray  = $postData['deleteId'];
        if(!empty($deleteIdArray)){
           foreach($deleteIdArray as $deleteId){   
                // delete all user data
                $whereCondtion  = array('id'=>$deleteId, 'role_id'=>3 );
                $this->Common_model->deleteRow('Users',$whereCondtion);  
            }
           
            $this->messages->setMessage($this->lang->line('staff_deleted_successfully'),'success');
            redirect(base_url('admin/subadmin'));
        }else{
            $this->messages->setFrntMessage($this->lang->line('request_not_completed'), 'error');
            redirect(base_url('admin/subadmin'));
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
        if($this->Subadmin_model->emailExists($email)){
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
    public function machine_list($filter=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard'); 
        $this->breadcrumbs->push('Machine List', '/');
        if(empty($filter)){
           $this->session->unset_userdata('postdata');
        } 
        $data['title']=$this->lang->line('machine_list');
        $this->home_template->load('home_template','admin/subadmin/machine_list', $data); 
        
    }
    
     /*
    *  @access: public
    *  @description: This method is use to get machine list
    *  @auther: arpit
    *  @return: json_obj
    */ 
    public function machinejaxlist(){
        $start         =  $this->input->get('start'); // get promo code Id
        $length        =  $this->input->get('length'); // get promo code Id
        $draw          =  $this->input->get('draw'); // get promo code Id
        
        $order   =  $this->input->get('order');
        if(!empty($order)){ 
            if($order[0]['column']==1){
                $column_name='person_name';
            }else if($order[0]['column']==2){
                $column_name='email';
            }else if($order[0]['column']==3){
                $column_name='contact_number';
            }else if($order[0]['column']==5){
                $column_name='machine_number';
            }else if($order[0]['column']==6){
                $column_name='complex_name';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Subadmin_model->machinejaxlist(true);
        $getRecordListing = $this->Subadmin_model->machinejaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                $recordListing[$i][1]= ucwords(strtolower($recordData->person_name));
                $recordListing[$i][2]= $recordData->email;
                $recordListing[$i][3]=  $recordData->contact_number;

                $image = !empty($recordData->machine_image) ? $recordData->machine_image : '';
                //$actionContent .='<img src="'.base_url('uploads/user/').''.$image.'" class="show_menu_img" height="40" width="40"/>'; 
                $actionContent .='<img src="'.getImage($image,"machine_pic").'" class="show_menu_img" height="40" width="40"/>'; 
                $recordListing[$i][4]= $actionContent;
                $recordListing[$i][5]= $recordData->machine_number;
                $recordListing[$i][6]= $recordData->complex_name;
                $recordListing[$i][7]= $recordData->address;
                $recordListing[$i][8]= change_date_formate($recordData->creation_date_time);
                $actionContent = '';
               
                $actionContent .='<a href="'.base_url('admin/subadmin/getMachineDetail/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
               
                $actionContent .='<a href="'.base_url('admin/subadmin/viewMachineDetail/'.encode($recordData->id)).'" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> '; 
                

                //$actionContent .='<a href="'.base_url('subadmin/machineDelete/'.encode($recordData->id)).'" class="btn btn-default" title="Delete"><i class="fa fa-remove"></i></a>';
                 $url = base_url('admin/subadmin/machineDelete');
                $actionContent .='<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteMachine('.$recordData->id.', \''.$url.'\');" class="btn btn-default" title="Delete"><i class="fa fa-trash"></i> </a>';
                $recordListing[$i][9]= $actionContent;              
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
    *  @Description: This method is use to machine info 
    *  @auther: arpit
    *  @return: void
    */
   
    public function getMachineDetail($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('machine_list'), 'admin/subadmin/machine_list');
        $this->breadcrumbs->push($this->lang->line('edit_machine'), '/');
        /*breadcrumb code end */
        if(!empty($id)){
            $data['countries'] = $this->Common_model->getDataFromTabel($this->db->dbprefix.'Countries', '*');
            $data['title']=$this->lang->line('edit_machine');
            $userDetails =  $this->Common_model->getDataFromTabel($this->db->dbprefix.'Machine_Detail', '*', array( 'id'=> decode($id)));
            $data['machineInfo'] = !empty($userDetails) ? $userDetails[0] : "";
             //print_r($data['machineInfo']);die;
            $this->home_template->load('home_template','admin/subadmin/editMachine', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }
        /*
    *  @access: public
    *  @Description: This method is used update user machine detail 
    *  @auther: Arpit
    *  @return: void
    */  
    
    public function machineUpdate($id=''){
        if(!empty($id)){
           if($this->input->post()){
                $this->form_validation->set_rules('person_name','Person name','required|trim');
               // $this->form_validation->set_rules('country_code','country_code','required|trim');
                //$this->form_validation->set_rules('passport','passport','required|trim');
                //$this->form_validation->set_rules('id_proof','ID Proof','required|trim');

                if($this->form_validation->run() === false){   
                    $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
                    redirect(base_url('admin/subadmin/machine_list'));
                }else{
                    $userId = decode($id);
                    $data['person_name']   = $this->input->post('person_name');
                    $data['machine_number']= $this->input->post('machine_number');
                    $data['complex_name']  = $this->input->post('complex_name');
                    $data['comment']       = $this->input->post('comment');
                    $data['address']       = $this->input->post('address');
                    //user profile code start

                    $oldImageName  = $this->input->post('oldImageName');
                    $profilePic="";
                    $response['imageName']="";
                    $dirPath = 'uploads/machine_pic';
                    if (isset($_FILES["machine_image"]["name"]) && $_FILES["machine_image"]["name"]!="") {
                        //$dirPath = USER_IMAGE;
                        $response=$this->Common_model->uploadProfileImage("admin",$dirPath,"machine_image");
                            
                        $data['machine_image'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/subadmin/machine_list'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['machine_image']=$response['imageName'];
                            $profilePic=$response['imageName'];
                        }
                    }

                    $this->Common_model->updateDataFromTabel("Machine_Detail",$data,array('id'=>$userId));
                    
                    $this->messages->setMessageFront($this->lang->line('update_successful'),'success');
                    redirect(base_url('admin/subadmin/machine_list'));    
                }
            }
        }else{
            $this->messages->setMessageFront($this->lang->line('update_successful'),'error');
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
        }
    }
    /*
    *  @access: public
    *  @Description: This method is use to load machine info 
    *  @auther: Arpit 
    *  @return: void
    */
   
    public function viewMachineDetail($id=''){ 
        /* breadcrumb code start */
        $this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
         $this->breadcrumbs->push($this->lang->line('machine_list'), 'admin/subadmin/machine_list');
        $this->breadcrumbs->push($this->lang->line('view_details'), '/');

        /*breadcrumb code end */
        if(!empty($id)){

            $data['title']=$this->lang->line('view_details');
            $machineDetails =  $this->Common_model->getDataFromTabel($this->db->dbprefix.'Machine_Detail', '*', array( 'id'=> decode($id)));
            
            $data['machineInfo'] = !empty($machineDetails) ? $machineDetails[0] : "";

            $this->home_template->load('home_template','admin/subadmin/machineDetails', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
    }
       /*
    *  @access: public
    *  @Description: This method is used to remove machine
    *  @auther: arpit
    *  @return: void
    */  
    public function machineDelete(){
         $id = $this->input->post('id');
        $whereCondtion  = array('id'=>$id);
        $ids=$this->Common_model->deleteRow('Machine_Detail',$whereCondtion);  
        if($ids){
            $response = true;
        }else{
            $response = false;
        }
        echo json_encode($response);        
        exit();
    }


}



