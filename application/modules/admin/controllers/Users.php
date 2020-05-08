<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    /*
    *  @Description: This controller is use to manage Users Module of Backend
    *  @auther: Gokul Rathod
    */ 
    class Users extends CI_Controller  {
     
    
    var $data = array(); 

    /** All users login there **/
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        loginCheck();
        $this->load->library(array('session_check','messages'));
        $this->load->model('Users_model');
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
            $this->breadcrumbs->push($this->lang->line('users_list'), '/');
        }else{
            $this->breadcrumbs->push($this->lang->line('permission_denied'), '/');
        }
        /*breadcrumb code end */
        
		// if empty filter then not data show
        if(empty($filter)){
           $this->session->unset_userdata('postdata');
        }
    
        $data['title']=$this->lang->line('users_list');
        
        if($this->roleId==1 || ($this->userListPer==1)){
            $this->home_template->load('home_template','admin/users/userList', $data); 
        }else{
            $this->home_template->load('home_template','admin/permissionError', $data);    
        }   
    }
    
    
    
    /*
    *  @access: public
    *  @Description: This method is use to filter data in user list  
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function filterUserlist(){
        
        $getPostData = $this->input->post();
        if(!empty($getPostData)){
            $this->session->set_userdata('postdata',$getPostData);
            redirect(base_url('admin/users/index/search'));
        }
    }
   
    
     
     /*
    *  @access: public
    *  @description: This method is use to get user list
    *  @auther: Gokul Rathod
    *  @return: json_obj
    */ 
    public function userajaxlist(){
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
                $column_name='current_wallet_balance';
            }else if($order[0]['column']==7){
                $column_name='creation_date_time';
            }else{
                $column_name='id';
            }
        }

        $totalRecord      = $this->Users_model->userajaxlist(true);
        $getRecordListing = $this->Users_model->userajaxlist(false,$start,$length, $column_name, $order[0]['dir']);
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
                $recordListing[$i][1]= $recordData->firstname." ".$recordData->lastname;
                $recordListing[$i][2]= $recordData->email;
				$recordListing[$i][3]=  $recordData->country_id."".$recordData->mobile_no;

                $money_sign =$this->lang->line('money_sign');      
                $recordListing[$i][4]= $money_sign."".number_format($recordData->current_wallet_balance,2);
                


                $image = !empty($recordData->profile_pic) ? $recordData->profile_pic : '';
                //$actionContent .='<img src="'.base_url('uploads/user/').''.$image.'" class="show_menu_img" height="40" width="40"/>'; 
                $actionContent .='<img src="'.getImage($image,"user").'" class="show_menu_img" height="40" width="40"/>'; 


                $recordListing[$i][5]= $actionContent;

                $actionContent = '';
                
                $table='Users';
				$field='status';
                $urls = base_url('admin/users/updateStatus');
				$warning_msg=$this->lang->line('do_you_want_to_change_status');
                if($this->userStatus==1){
                    if($recordData->status=='1'){
                        $succ_msg=$this->lang->line('activated');
                        $actionContent .='<a class="btn bg-green waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\' , \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\' );" title="'.$this->lang->line('active').'">'.$this->lang->line('active').'</a>';
                    } else if($recordData->status=='2'){
                        $actionContent .='<h3 type="button" class="btn btn-warning status-btn">Suspended</h3>';
                    }else{ 
                        $succ_msg=$this->lang->line('inactivated');
                        $actionContent .='<a class="btn bg-red waves-effect" href="javascript:void(0);" onclick="sweetalert('.$recordData->id.', \''.$recordData->status.'\', \''.$urls.'\', \''.$table.'\', \''.$field.'\',\''.$warning_msg.'\', \''.$succ_msg.'\');" title="'.$this->lang->line('inactive').'">'.$this->lang->line('inactive').'</a>';
                    }
                }else{
                    if($recordData->status=='1'){
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="'.$this->lang->line('active').'">'.$this->lang->line('active').'</a>';
                    }else if($recordData->status=='2'){
                        $actionContent .='<h3 type="button" class="btn btn-warning status-btn">Suspended</h3>';
                    }else{ 
                        $actionContent .='<a '.$this->buttonIcon.' class="btn bg-red waves-effect" href="#" title="'.$this->lang->line('inactive').'">'.$this->lang->line('inactive').'</a>';
                    }
                }
                
                $recordListing[$i][6]= $actionContent;              
                $recordListing[$i][7]= (!empty($recordData->gift_card_number)) ? $recordData->gift_card_number : "-" ;              
				$actionCont = '';
               // $actionCont.='<a '.$this->buttonIcon.' class="btn bg-green waves-effect" href="#" title="'.$this->lang->line('active').'">'.$this->lang->line('assign_card').'</a>';
               $gift_card_number=(!empty($recordData->gift_card_number)) ? $recordData->gift_card_number : '';
                $actioCont='<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal'.$recordData->id.'">'.$this->lang->line('assign_card').'</button><div class="modal fade" id="exampleModal'.$recordData->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">'.$this->lang->line('gift_card').'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <div class="alert alert-success" role="alert" style="display:none;"></div>
                      <div class="alert alert-danger" role="alert" style="display:none;"></div>
                  <div class="box-body">
                     <form role="form"  data-parsley-validate>
                     <div class="row no-margin">
                        <div class="col-md-10"> 
                            <div class="form-group">
                              <label for="exampleInputEmail1">'.$this->lang->line('card_number').'</label>
                              <input type="text" class="form-control" id="cardno'.$recordData->id.'" placeholder="'.$this->lang->line('card_number').'" name="card_number" value="'.$gift_card_number.'" data-parsley-required-message="<?php '. $this->lang->line('card_number_required').'"  required="">
                            </div>  
                        </div>
                       </div>
                   </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_card" onclick="gift_card_submit('.$recordData->id.' );" title="'.$this->lang->line('active').'">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>';
                $recordListing[$i][8]= $actioCont;              
				
				
				$recordListing[$i][9]= change_date_formate($recordData->creation_date_time);
				
				$actionContent = '';
                if($this->userEdit==1){
				    $actionContent .='<a href="'.base_url('admin/users/getUserDetail/'.encode($recordData->id)).'" class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                }else{
                    $actionContent .='<a href="#" '.$this->buttonIcon.' class="btn btn-default edit-btn action-btn" title="'.$this->lang->line('edit').'"><i class="fa fa-pencil"></i></a> '; 
                }
                if($this->userView==1){
				    $actionContent .='<a href="'.base_url('admin/users/viewUserDetail/'.encode($recordData->id)).'" class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> '; 
				}else{
                    $actionContent .='<a href="#" '.$this->buttonIcon.' class="btn btn-default view-btn action-btn" title="'.$this->lang->line('view_details').'"><i class="fa fa-eye"></i></a> '; 
                }
                //$actionContent .='<a href="'.base_url('users/userDelete/'.encode($recordData->id)).'" class="btn btn-default" title="Delete"><i class="fa fa-remove"></i></a>';
				$recordListing[$i][10]= $actionContent;              
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
    *  @Description: This method is use to user info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
	public function getUserDetail($id=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
		$this->breadcrumbs->push($this->lang->line('users_list'), 'admin/users');
        $this->breadcrumbs->push($this->lang->line('edit_user'), '/');
        /*breadcrumb code end */
        if(!empty($id)){
            $data['countries'] = $this->Common_model->getDataFromTabel($this->db->dbprefix.'Countries', '*');
            $data['title']=$this->lang->line('edit_user');
            $userDetails =  $this->Common_model->getDataFromTabel($this->db->dbprefix.'Users', '*', array( 'id'=> decode($id)));
            $data['userInfo'] = !empty($userDetails) ? $userDetails[0] : "";

            $this->home_template->load('home_template','admin/users/editUser', $data);    
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
    
    public function userUpdate($id=''){
        if(!empty($id)){
           if($this->input->post()){
				$this->form_validation->set_rules('first_name','first_name','required|trim');
                $this->form_validation->set_rules('last_name','last_name','required|trim');
               // $this->form_validation->set_rules('country_code','country_code','required|trim');
                //$this->form_validation->set_rules('passport','passport','required|trim');
                //$this->form_validation->set_rules('id_proof','ID Proof','required|trim');

				if($this->form_validation->run() === false){   
					$this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
					redirect(base_url('admin/users'));
				}else{
					$userId = decode($id);
					$data['firstname']  = $this->input->post('first_name');
                    $data['lastname']  = $this->input->post('last_name');
                    // $data['country_code'] = $this->input->post('country_code');
                    $data['familyname']  = $this->input->post('family_name');
                    $data['address']  = $this->input->post('address');
                    
                    //user profile code start

                    $oldImageName  = $this->input->post('oldImageName');
					$profilePic="";
					$response['imageName']="";
					$dirPath = 'uploads/user';
                    if (isset($_FILES["userProfile"]["name"]) && $_FILES["userProfile"]["name"]!="") {
                		
                        //$dirPath = USER_IMAGE;
                        $response=$this->Common_model->uploadProfileImage("user",$dirPath,"userProfile");
                            
                        $data['profile_pic'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/users'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['profile_pic']=$response['imageName'];
                            $profilePic=$response['imageName'];
                        }
                    }

                    // user profile code end

                    // user document code start

                    $oldFrontDoc  = $this->input->post('oldFrontDoc');
                    $frontDoc="";
                    $response['imageName']="";
                    $dirDocPath = 'uploads/identification';
                    if (isset($_FILES["doc_front"]["name"]) && $_FILES["doc_front"]["name"]!="") {
                        
                        //$dirPath = USER_IMAGE;
                        $response=$this->Common_model->uploadProfileImage("varification",$dirDocPath,"doc_front");
                            
                        //$data['varification_front_image'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/users'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['varification_front_image']=$response['imageName'];
                            $frontDoc=$response['imageName'];
                        }
                    }


                    $oldBackDoc  = $this->input->post('oldBackDoc');
                    $response['imageName']="";
                    
                    if (isset($_FILES["doc_back"]["name"]) && $_FILES["doc_back"]["name"]!="") {
                        
                        //$dirPath = USER_IMAGE;
                        $response=$this->Common_model->uploadProfileImage("varification",$dirDocPath,"doc_back");
                            
                       // $data['profile_pic'] = '';
                        if (!empty($response) && $response['status']=="error") {
                            redirect(base_url('admin/users'));
                        } else if(!empty($response) && $response['status']=="success") {
                            $data['varification_end_image']=$response['imageName'];
                            $backDoc=$response['imageName'];
                        }
                    }


                    // user document code end

					$this->Common_model->updateDataFromTabel("Users",$data,array('id'=>$userId));
                    // $this->Master_model->updatedata('sm_users',array('user_id'=>$userId),array('user_status'=>$userSuspended));
					if(!empty($profilePic)){
                        //remove old profile picture
						$dirPath = $dirPath."/".$oldImageName;
						unlink($dirPath);		
					}
                    if(!empty($frontDoc)){
                        //remove old front document
                        $dirfrntPath = $dirDocPath."/".$oldFrontDoc;
                        unlink($dirfrntPath);       
                    }
                    if(!empty($backDoc)){
                        //remove old back document
                        $dirbkPath = $dirDocPath."/".$oldBackDoc;
                        unlink($dirbkPath);       
                    }

					$this->messages->setMessageFront($this->lang->line('update_successful'),'success');
					redirect(base_url('admin/users'));
					
				}
			}
		}else{
            $this->messages->setMessageFront($this->lang->line('update_successful'),'error');
            $this->messages->setMessageFront($this->lang->line('Invalid_detail'),'error');
        }
	}
	
    public function userSuspend(){
        $returnData=false;
        $userId=$this->input->post('id');
        $userStatus=$this->input->post('status');
        
        if(!empty($userId)){

            if($userStatus=='1'){
                $status='0';
            }else{
                $status='2';
            }
        
            $upWhere = array('id' =>$userId);
            $updateData = array('status'=>$status);
            $this->Common_model->updateDataFromTabel('Users',$updateData,$upWhere);
            $this->Master_model->updatedata('sm_users',array('user_id'=>$userId),array('user_status'=>$status));
            $returnData = array('isSuccess'=>true);
            
        }else{
            $returnData = array('isSuccess'=>false);
        }
        echo json_encode($returnData); 
    }


	
	/*
    *  @access: public
    *  @Description: This method is use to load user info 
    *  @auther: Gokul Rathod
    *  @return: void
    */
   
	public function viewUserDetail($id=''){ 
		/* breadcrumb code start */
		$this->breadcrumbs->push('<i class="fa fa-dashboard"></i> '.$this->lang->line('dashboard') , 'admin/dashboard');
        $this->breadcrumbs->push($this->lang->line('users_list'), 'admin/users');
        $this->breadcrumbs->push($this->lang->line('view_details'), '/');
        /*breadcrumb code end */
        
        if(!empty($id)){
            $data['total_trans'] = $this->Common_model->countResult($this->db->dbprefix.'Transactions',array('to_user_id'=> decode($id)));
            $data['total_deposite'] = $this->Common_model->countResult($this->db->dbprefix.'Transactions',array('to_user_id'=> decode($id), 'tran_type_id'=> 2));
            $data['total_withdraw'] = $this->Common_model->countResult($this->db->dbprefix.'Transactions',array('to_user_id'=> decode($id), 'tran_type_id'=> 1));

            $data['transListPer']=$this->transListPer;
            $data['withdrListPer']=$this->withdrListPer;
            $data['depoListPer']=$this->depoListPer;

            $data['title']=$this->lang->line('view_details');

            $data['userInfo'] = $this->Users_model->getUserinfo(decode($id));
            $this->home_template->load('home_template','admin/users/userDetails', $data);    
        }else{
            $this->home_template->load('home_template','admin/error');    
        }
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
    public function updateCardnumberOfUser(){
    
            $this->form_validation->set_error_delimiters("<p class='inputerror text text-danger error'>", "</p>");
             $this->form_validation->set_rules('card_number', 'Gift Card Number', 'required|is_numeric' , array('required' => $this->lang->line('card_number_required'),'is_numeric' => $this->lang->line('gift_card_only_number')
            ));

        if ($this->form_validation->run() == FALSE)
        {
            $error=array(
                          'card_number' =>form_error('card_number')
                        );
            $returnData = array('status'=>false,'message'=>'','data'=>$error);
        }
        else
        {
          $user_id = $this->input->post('user_id');
          $card_number=$this->input->post('card_number');
          
          $where = array('gift_card_number'=>$card_number);
          $userdata = $this->Common_model->getDataFromTabel($this->db->dbprefix.'Users', 'id,gift_card_number',$where);
            $id= (!empty($userdata[0]->id)) ? $userdata[0]->id  : '';
           if(empty($userdata) || $id ==$user_id){
           
             //$gift_card_number= (!empty($userdata[0]->gift_card_number)) ? $userdata[0]->gift_card_number  : ''; 
                $upWhere = array('id' =>$user_id);
                $updateData = array('gift_card_number'=>$card_number);
                $this->Common_model->updateDataFromTabel($this->db->dbprefix.'Users',$updateData,$upWhere);
               
                $returnData = array('status '=>true,'message'=>(empty($id)) ? 'Card added succsfully' : 'Card updated succsfully' );
                
            }else{
                $returnData = array('status'=>false,'message'=>'Gift Card Number is Already in Our Record');
            }   
        }
        echo json_encode($returnData); 

  }
  
}
