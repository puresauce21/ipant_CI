<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* * ********Encrypt******* */
/*function hash_password($password){
	return password_hash($password, PASSWORD_BCRYPT);
}
/* * *******Compare******** */
/*function verify_password_hash($password, $hash){ 
	return password_verify($password, $hash) ? "verified" : "invalid";
}*/


/*require FCPATH .'/paysafe/source/Paysafe/PaysafeApiClient.php';
require FCPATH .'/paysafe/source/Paysafe/Environment.php';
require FCPATH .'/paysafe/source/Paysafe/CardPayments/Authorization.php';*/
//require FCPATH . '/libraries/REST_Controller.php';
use Paysafe\PaysafeApiClient;
use Paysafe\Environment;
use Paysafe\CardPayments\Authorization;
use Paysafe\CardPayments\Settlement;



////////////////////////// Check Login for authenticaion ///admin helper start  //////////////////////
	
	

	if(!function_exists('loginCheck')){
		function loginCheck(){
            
            $CI = get_instance();	
            if(loggedId()){
				return TRUE;
			}else{	
                //this code is user for clear cache
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
                header("Cache-Control: no-store, no-cache, must-revalidate"); 
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                $CI->messages->setMessage('Please login first.','pageerror');
				redirect('login');					
			}
		}
	}
	
	/*
	 * @descript: This function is used to check is user login
	 * @return userid or flase
	 */ 


	if(!function_exists('logedId')){
		 function loggedId(){
			$CI = get_instance();	
			$userId  = $CI->session->userdata('userId');

			if(decode($userId)>0){
				if(decode($userId)==2){
					redirect('web/dashboard');					
				}
				return $userId;
			}else{			
				return FALSE;
			}
		 }
	}


	// if(!function_exists('adminLoginCheck')){	 
	// 	 function adminLoginCheck(){
	// 		$CI = get_instance();	
	// 		$admin_role  = $CI->session->userdata('userRoleId');			
	// 		if($admin_role==1){  // 1 : super-admin
	// 			return true;
	// 		}else if($admin_role==5){ // 5 : sub-admin
	// 			return true;
	// 		}else if($admin_role==2){ // 2 : customer
	// 			return true;
	// 		}else{
	// 			return false;
	// 		}
	// 	}
	// }

	if(!function_exists('adminLoginCheck')){	 
		 function adminLoginCheck(){
			$CI = get_instance();	
			$admin_role  = $CI->session->userdata('userRoleId');			
			if($admin_role==1 || $admin_role==3){  // 1 : super-admin
				return true;
			}else if(!empty($admin_role) && $admin_role!=1 && $admin_role!=3 && $admin_role!=4 && $admin_role!=6){ // 5 : sub-admin
				return true;
			}else{
				return false;
			}
		}
	}



	
	/*if(!function_exists('getSubAdminpermission')){	 
		 function getSubAdminpermission(){
			$CI = get_instance();	
			$permissionArray  =  $CI->Common_model->getDataFromTabel('admin_roles_permission', 'permission', array('roleid'=>'5'));
			$adminRole  = $CI->session->userdata('userRoleId');			
			$permissionArray = !empty($permissionArray) ? $permissionArray : "";
			$permission = unserialize($permissionArray[0]->permission);
			if($adminRole==1){
				return false;
			}else if($adminRole==5){
				return $permission;
			}else{
				return false;
			}
		}
	}
	*/


	if(!function_exists('getSubAdminpermission')){	 
		 function getSubAdminpermission(){
			$CI = get_instance();	
			$userRoleId  = $CI->session->userdata('userRoleId');
			$permissionArray  =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'admin_roles_permission', 'permission', array('roleid'=>$userRoleId));
			$adminRole  = $CI->session->userdata('userRoleId');			
			$permissionArray = !empty($permissionArray) ? $permissionArray : "";
			$permission = unserialize($permissionArray[0]->permission);
			if($adminRole==1){
				return false;
			}else if(!empty($permissionArray) && $adminRole!=1){
				return $permission;
			}else{
				return false;
			}
		}
	}


	if(!function_exists('getOtherUser')){	 
		 function getOtherUser(){
			$CI = get_instance();	
			$permissionArray  =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'admin_roles_permission', '*');
			$permissionArray = !empty($permissionArray) ? $permissionArray : "";
			if(!empty($permissionArray)){
				return $permissionArray;
			}else{
				return false;
			}
		}
	}
	


	if(!function_exists('headerTitle')){	 
		 function headerTitle(){
			$CI = get_instance();	
			$userRoleId  = $CI->session->userdata('userRoleId');
			$role_name  =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'Roles', 'role_name', array('id'=>$userRoleId));
			$role_name = !empty($role_name) ? $role_name[0] : "";
			if(!empty($role_name)){
				return $role_name->role_name;
			}else{
				return false;
			}
		}
	}


	if(!function_exists('getActiveRole')){	 
		 function getActiveRole(){
			$CI = get_instance();	
			$roleDetails =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'Roles', 'id', array('is_login_admin'=> 1));
			$roleArray=array();
        	if(!empty($roleDetails)){
        		
        		foreach($roleDetails as $role){
        			// if($userRoleId==1){
        			// 	$roleArray[]= $role->id;
        			// }else{
        				if($role->id!=1){
	        				$roleArray[]= $role->id;	
	        			}
        			// }
        		}
        	}
			if(!empty($roleArray)){
				return $roleArray;
			}else{
				return false;
			}
		}
	}



	



	if( ! function_exists('getImage')){
		function getImage($imageName='',$pathFolder='') {
			$CI =& get_instance();
			
			//------image exist path--------------
			$basePath  = 'uploads/'.$pathFolder.'/'.$imageName;
			if(!empty($imageName) && file_exists($basePath)){
				$displayImage = base_url($basePath);
			}else{
				//------------default image path----------
				$displayImage = base_url('uploads/'.$pathFolder.'/').'default.png';
			}
			
			return $displayImage;
		}
	}


	if( ! function_exists('get_image')){
		function get_image($imagePath=''){
	        if(!empty($imagePath)){
	            if(file_exists($imagePath)){
	                return BASEURL.$imagePath;   
	            }else{
	                return BASEURL.'media/images/no_image.png';    
	            }
	        }
	    }	
	}



	
	

	if( ! function_exists('getLogo')){
		function getLogo() {
			$CI =& get_instance();
			
			$getLogo =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'Options', '*', array('option_name' => 'logo' ));
        	
        	if(!empty($getLogo)){
				$getLogo = !empty($getLogo) ? $getLogo[0] : "";
			}else{
				$getLogo="";
			}
			return $getLogo;
		}
	}
	

	if( ! function_exists('getFavicon')){
		function getFavicon() {
			$CI =& get_instance();
			$getFavicon =  $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'Options', '*', array('option_name' => 'favicon' ));
			
        	if(!empty($getFavicon)){
				$getFavicon = !empty($getFavicon) ? $getFavicon[0] : "";
			}else{
				$getFavicon="";
			}
			return $getFavicon;
		}
	}
	

	/*
	 * @description: This function is used to genrate random number  by passing digit
	 * @param1: $digits (number) 
	 * return number 
	 * 
	 */ 
	
	if(! function_exists('randomnumber')){ 
		function randomnumber($digits='3'){
			return rand(pow(10, $digits-1), pow(10, $digits)-1);
		}
	}



	 /*
	 * @descript: This function is used to set header title for user admin
	 * @return: header title
	 * @author: Gokul Rathod	
	 */
	if( ! function_exists('getHeaderTitle')){
		function getHeaderTitle() {
			$ci = & get_instance();  
		 	$slug1 = !empty($ci->uri->segment(1)) ? $ci->uri->segment(1) : "";
		 	$slug2 = !empty($ci->uri->segment(2)) ? $ci->uri->segment(2) : "";
			$slug3 = !empty($ci->uri->segment(3)) ? $ci->uri->segment(3) : "";
			$admin_role  = $ci->session->userdata('userRoleId');
			$admin_role = !empty($admin_role) ? $admin_role : "";
			$header_title="";
			if($admin_role==2){
				if($slug1=="web" && $slug2=="account" && empty($slug3)){
					$header_title = "Welcome Back of Stac (LTD.)";
				}else if($slug3=="sendmoney" || $slug3=="sendmoneylist"){
					$header_title = "Manage Send Money";
				}else if($slug3=="requestmoney" || $slug3=="requestmoneylist"){
					$header_title = "Manage Request Money";
				}else if($slug3=="withdrawmoney" || $slug3=="withdrawmoneylist"){
					$header_title = "Manage Withdraw Money";
				}else if($slug3=="cashout" || $slug3=="cashoutlist"){
					$header_title = "Manage Cashout";
				}else if($slug3=="addmoney"){
					$header_title = "Manage Add Money";
				}else if($slug3=="sharebill" || $slug3=="ShareBillToMe"){
					$header_title = "Manage Share Bill";
				}else if($slug3=="managebanks"){
					$header_title = "Manage Banks";
				}else if($slug3=="managecards"){
					$header_title = "Manage Cards";
				}else if($slug3=="changepassword"){
					$header_title = "Change Password of Stac (LTD.) Account";
				}else if($slug3=="setpin"){
					$header_title = "Change Pin of Stac (LTD.) Account";
				}else if($slug3=="profile"){
					$header_title = "Your Stac (LTD.) Profile";
				}
			}
			return $header_title;
		}
	}
 
	if(!function_exists('guestUsercheck')){	 
		 function guestUsercheck(){
		 	$CI = get_instance();	
			$userId  = $CI->session->userdata('userId');			
			//decode
			if(!empty($userId)){
				return true;
			}else{
				$slug1 = !empty($CI->uri->segment(1)) ? $CI->uri->segment(1) : "";
				
			 	$slug2 = !empty($CI->uri->segment(2)) ? $CI->uri->segment(2) : "";
			 	
				$slug3 = !empty($CI->uri->segment(3)) ? $CI->uri->segment(3) : "";
				
				if($slug1=="web" && $slug2=="account" && $slug3==""){
					return true;
				}else{
					redirect('account');	
				}
			}
		}
	}


	 /*
	 * @descript: This function is used to Upload an image
	 * @return config setting
	 */
	
	function set_upload_options($dirPath,$allowedTypes,$fileName="") {   
	   //  upload an image and document options
		$config = array();
		$config['upload_path'] = $dirPath;
		$config['allowed_types'] = $allowedTypes;
		$config['overwrite'] = FALSE;
		
		if($fileName!=""){
			 $config['file_name'] = $fileName;
		}
		
		return $config;
	}



	/*
	*	@functionality  : method used for change date formate
	*/
	function change_date_formate($date="",$format = 'd/m/Y'){
		if(!empty($date)){
			if(is_int($date)){
				$int_date = $date;
			}else{
				$int_date = strtotime($date);
			}

			return date($format,$int_date);	
		}else{
			return "N/A";
		}
		
	}

	/*
	*	@functionality  : method used for change date formate
	*/
	function changeDateTimeFormate($date="",$format = 'm/d/Y H:i:s'){
		if(!empty($date)){
			if(is_int($date)){
				$int_date = $date;
			}else{
				$int_date = strtotime($date);
			}

			return date($format,$int_date);	
		}else{
			return "N/A";
		}
		
	}

	//*****************  get all state list  *********************//
	function stateList($stateId,$countryId='all'){
		$CI = & get_instance();	
		$countryId=($countryId=="") ? 'all' : $countryId;
		
		if($countryId == 'all'){
			$whereClause = "1";
		}else{
			$whereClause = array('country_id' => $countryId );
		}
		$arrayState = $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'St_state', '*', $whereClause,'','state_name');
		$dropDownCity = '<option value="">Select State</option>';
		if(count($arrayState) > 0){			
			foreach($arrayState as $arrayKey=>$arrayValue ){
				
				$selected = '';
				if($stateId == $arrayValue->state_id){	
					$selected = "selected";					
					$selectedState = $arrayValue->state_id;
				}
				$dropDownCity.= "<option value='".$arrayValue->state_id."' ".$selected." >".$arrayValue->state_name."</option> ";
			}			
		}
		
		return $dropDownCity;
	}

	//*****************  get all city list  *********************//
	function cityList($cityId,$stateId='all'){
		
		$CI = & get_instance();	
		$stateId=($stateId=='') ? 'all' : $stateId;
		if($stateId == 'all'){
			$whereClause = "1";
		}else{
			$whereClause = array('state_id' => $stateId );
		}
		
		$arrayCity = $CI->Common_model->getDataFromTabel($CI->db->dbprefix.'St_city', '*', $whereClause,'','city_name');
		$dropDownCity = '';
		if(count($arrayCity) > 0){			
			foreach($arrayCity as $arrayKey=>$arrayValue ){
				
				$selected = '';
				if($cityId == $arrayValue->city_id 	)
				{	
					$selected = "selected";					
					$selectedCity = $arrayValue->city_id;
				}
				$dropDownCity.= "<option value='".$arrayValue->city_id."' ".$selected." >".$arrayValue->city_name."</option> ";
			}			
		}
		
		return $dropDownCity;
	}
	

////////////////////////// admin helper end  //////////////////////




function update_data($table = null, $data = array(), $where = array()) {
	$ci = & get_instance();
	$ci->db->update($table, $data, $where);
	if ($ci->db->affected_rows() > 0)
	return true;
	else
	return false;
}
///** * create a encoded id for sequrity pupose  */
if (!function_exists('encode_id')) {
	function encode_id($id, $salt){
		$ci = &get_instance();
		$id = $ci->encrypt->encode($id . $salt);
		$id = str_replace("=", "~", $id);
		$id = str_replace("+", "_", $id);
		$id = str_replace("/", "-", $id);
		return $id;
	}
}
/** * decode the id which made by encode_id() */
if (!function_exists('decode_id')) {
	function decode_id($id, $salt) {
		$ci = &get_instance();
		$id = str_replace("_", "+", $id);
		$id = str_replace("~", "=", $id);
		$id = str_replace("-", "/", $id);
		$id = $ci->encrypt->decode($id);
		if ($id && strpos($id, $salt) !== false) {
		return str_replace($salt, "", $id);
		}
	}
}

// Get Session User details
function getuserdetails(){
	$CI = get_instance();
	$userId  = $CI->session->userdata('userId');
	//echo $id = $CI->session->userdata['logged_in']['session_userid'];die();
	$CI->load->model('dynamic_model');
	$return = $CI->dynamic_model->get_user(decode($userId));
	return $return;
}

function makeslug($slugdata){
	$title = $slugdata;
	$title = trim(preg_replace('/\s+/', ' ', preg_replace('/[^a-zA-Z0-9_.]/', ' ', $title)));
	return strtolower(str_replace(' ', '_', $title));
}

// Get table data 
function getdatafromtable($tbnm, $condition = array(), $data = '*', $limit = '', $offset = '',$orderBy = ''){
	$CI = get_instance();
	$CI->load->model('dynamic_model');
	$result = $CI->dynamic_model->getdatafromtable($tbnm, $condition, $data, $limit, $offset, $orderBy);
	return $result;

}
function get_options($value){
	$CI = get_instance();
	$CI->load->model('dynamic_model');
	$condition = array( 'option_name' => $value );
	$result = $CI->dynamic_model->getoptions($condition);
	return $result[0]['option_value'];

}
// Get Table record count
function getdatacount($tbnm, $condition = array()){
	$CI = get_instance();
	$CI->load->model('dynamic_model');
	$result = $CI->dynamic_model->countdata($tbnm, $condition);
	return $result[0]['counting'];
}
/* * ********** Email Function  ************* */
if (!function_exists('email_function')) {
	function email_function($to, $subject, $msg, $cc = '', $attachemt = ''){
		$CI = get_instance();
		$CI->load->library('email');
		$CI->email->from('prathak.godawat@consagous.com', 'Kohdy');
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($msg);
		$CI->email->set_mailtype('html');
		if($attachemt != ''){
			$CI->email->attach($attachemt);
		}
		if($CI->email->send()) {
			$result = "1";
		} else {
			$result = "0";
		}
		return $result;
	}
}

// Get user role id using user ID
if (!function_exists('get_user_role')) {
	function get_user_role($id){
		$CI = get_instance();
		$CI->load->model('dynamic_model');
		$condition = array('User_Id' => $id);
		$result = $CI->dynamic_model->getdatafromtable($CI->db->dbprefix.'User_In_Roles', $condition, 'Role_Id');
		return $result[0]['Role_Id'];
	}
}

// Get user role Name using Role ID
if (!function_exists('get_role_name')) {
	function get_role_name($roleid){
		$CI = get_instance();
		$CI->load->model('dynamic_model');
		$condition = array('id' => $roleid);
		$result = $CI->dynamic_model->getdatafromtable($CI->db->dbprefix.'roles', $condition, 'name');
		return $result[0]['name'];
	}
}

// // Get Mall Name using Role ID
// if (!function_exists('get_mall_name')) {
// 	function get_mall_name($mallid){
// 		$CI = get_instance();
// 		$CI->load->model('dynamic_model');
// 		$condition = array('mall_id' => $mallid);
// 		$result = $CI->dynamic_model->getdatafromtable('shopping_mall', $condition, 'mall_name');
// 		return $result[0]['mall_name'];
// 	}
// }

// // Get category Name using Category ID
// if (!function_exists('get_category_name')) {
// 	function get_category_name($catid){
// 		$CI = get_instance();
// 		$CI->load->model('dynamic_model');
// 		$condition = array('id' => $catid);
// 		$result = $CI->dynamic_model->getdatafromtable('category', $condition, 'cat_name');
// 		return $result[0]['cat_name'];
// 	}
// }

// Get Limited Words
if (!function_exists('limit_words')) {
	function limit_words($string, $word_limit) {
	    $words = explode(" ",$string);
	    return implode(" ", array_splice($words, 0, $word_limit));
	}
}

// Get Date with right format
if (!function_exists('get_formated_date')) {
	function get_formated_date($timestramdate) {
	    $formated_date = date("d M Y",strtotime($timestramdate));
	    return $formated_date ;
	}
}


// Version Check API

 function version_check_helper() {
 	$arg = array();
 	$CI = get_instance();
	$version_code =  $CI->input->get_request_header('version', true);
	
	if(!empty($version_code)){
		$api_version =  config_item('api_version'); 
		$api_forcefully =  config_item('api_forcefully'); 
		if($version_code >= $api_version) {
			$arg['status'] = 1;
			$arg['code'] = '465';
			$arg['message'] = 'App is Up to date';
		} else{
			if($api_forcefully){
				$arg['status'] = 0;
				$arg['code'] = '467';
				$arg['message'] = 'Major Update Available';
			} else {
				$arg['status'] = 0;
				$arg['code'] = '466';
				$arg['message'] = 'Minor Update Available';
			}
		}
	} else {
		$arg['status'] = 0;
		$arg['message'] = 'Please Send App Version';
	}
	return $arg;
 }


 function version_check_helper1() {
 	$arg = array();
 	$CI = get_instance();
	$version_code =  $CI->input->get_request_header('version', true);
	
	if(!empty($version_code)){
		$api_version =  config_item('api_version'); 
		$api_forcefully =  config_item('api_forcefully'); 
		if($version_code >= $api_version) {
			$arg['status'] = 1;
			$arg['errorcode'] = '465';
			$arg['message'] = 'App is Up to date';
			$arg['data']  = array();
		} else{
			if($api_forcefully){
				$arg['status'] = 0;
				$arg['errorcode'] = '467';
				$arg['message'] = 'Major Update Available';
				$arg['data']  = array();
			} else {
				$arg['status'] = 0;
				$arg['errorcode'] = '466';
				$arg['message'] = 'Minor Update Available';
				$arg['data']  = array();
			}
		}
	} else {
		$arg['status'] = 0;
		$arg['errorcode'] = REST_Controller::HTTP_NOT_FOUND;
		$arg['message'] = 'Please Send App Version';
		$arg['data']  = array();
	}
	return $arg;
 }



// Get single Validation Error for API
function get_form_error($error){
	if(count($error) > 0){
		foreach($error as $key=>$value){
			return $value;
			break;
		}	
	}
}

// Function for get miles
if (!function_exists('get_miles')) {
	function get_miles($latitude1,$longitude1,$latitude2,$longitude2) {
    	$theta = $longitude1 - $longitude2;
		$dist  = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) +  cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));
		$dist  = acos($dist);
		$dist  = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		//$miles = $miles * 0.8684;
		$km = $miles * 1.609344;
		return round($km, 2);
    }
}

if (!function_exists('generateRandomString')) {
  function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
}

if (!function_exists('generateQrcode')) {
	function generateQrcode($mobile) {
		//return $qr_number = substr($mobile, 0, 2).genrateRandom(8,'alphanum');
	    //$mobile = '20 Persantage offer in Product test';
		$qr_number = substr($mobile, 0, 2).generateRandomString(10);
		$new_array = array(
			'qr_code' => $qr_number.'.png',
	        'qr_number' => $qr_number
	    );
	                
		$qr_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$qr_number&choe=UTF-8";
		$img = file_get_contents($qr_url);  // get image data from $url

		$save_to = 'uploads/coupon_qr/'. $qr_number.'.png';  // add image with the same name in 'imgs/' folder
		if(file_put_contents($save_to, $img)) {
			return $qr_number;
		} else {
			return false;
		}
	}
}


// if (!function_exists('getrating')) {
// 	function getrating($shopid){
// 		if($shopid != ''){
// 			$CI = get_instance();
// 			$CI->load->model('dynamic_model');

// 			$where_rating = array(
// 				'rate_shop_id' => $shopid ,
// 				'rate_status' => "1",
// 			);
// 			$ratinginfo =  $CI->dynamic_model->getdatafromtable('reviews', $where_rating, "count(*) as total, sum(rate_rating) as rate_rating");
// 			$total = $ratinginfo[0]['total'];
// 			$totalcount = $ratinginfo[0]['rate_rating'];
// 			if($totalcount > "0")  {
// 		        $rating = round($totalcount/$total);
// 		        $totalrating = (string)number_format((float)$rating, 1, '.', '');
// 		    } else {
// 		        $totalrating = "0";        	
// 		    }
// 		    return $totalrating;
// 		}
// 	}
// }

/**
 * This function used to get user question aswered by userid
 * @param number $userId : This is user id
 * @return array $count : This is count of records
 */
if(!function_exists('getStatusText'))
{
    function getStatusText($status)
    {   
        $CI = &get_instance();
        if($status == 1 ){
            $payment_status = '<span class="label label-warning">Pending</span>';
        }
        if($status == 2 ){
            $payment_status = '<span class="label label-info">Processed</span>';
        }
        if($status == 3 ){
            $payment_status = '<span class="label label-warning">Hold</span>';
        }
        if($status == 4 ){
            $payment_status = '<span class="label label-danger">Reject</span>';
        }
        if($status == 5 ){
            $payment_status = '<span class="label label-primary">Refund</span>';
        }
        if($status == 6 ){
            $payment_status = '<span class="label label-success">Success</span>';
        }
        
        return $payment_status;
    }
}


	// Get ip_info
	if(! function_exists('ip_info'))
	{
		function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
		{
		    $output = NULL;
		    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
		        $ip = $_SERVER["REMOTE_ADDR"];
		        $ip = $_SERVER["HTTP_HOST"];
		        if ($deep_detect) {
		            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
		                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
		                $ip = $_SERVER['HTTP_CLIENT_IP'];
		        }
		    }
		    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		    $continents = array(
		        "AF" => "Africa",
		        "AN" => "Antarctica",
		        "AS" => "Asia",
		        "EU" => "Europe",
		        "OC" => "Australia (Oceania)",
		        "NA" => "North America",
		        "SA" => "South America"
		    );
		    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
		        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
		        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
		            switch ($purpose) {
		                case "location":
		                    $output = array(
		                        "city"           => @$ipdat->geoplugin_city,
		                        "state"          => @$ipdat->geoplugin_regionName,
		                        "country"        => @$ipdat->geoplugin_countryName,
		                        "country_code"   => @$ipdat->geoplugin_countryCode,
		                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
		                        "continent_code" => @$ipdat->geoplugin_continentCode
		                    );
		                    break;
		                case "address":
		                    $address = array($ipdat->geoplugin_countryName);
		                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
		                        $address[] = $ipdat->geoplugin_regionName;
		                    if (@strlen($ipdat->geoplugin_city) >= 1)
		                        $address[] = $ipdat->geoplugin_city;
		                    $output = implode(", ", array_reverse($address));
		                    break;
		                case "city":
		                    $output = @$ipdat->geoplugin_city;
		                    break;
		                case "state":
		                    $output = @$ipdat->geoplugin_regionName;
		                    break;
		                case "region":
		                    $output = @$ipdat->geoplugin_regionName;
		                    break;
		                case "country":
		                    $output = @$ipdat->geoplugin_countryName;
		                    break;
		                case "countrycode":
		                    $output = @$ipdat->geoplugin_countryCode;
		                    break;
		            }
		        }
		    }
		    return $output;
		}
	}

	// Get OS
	if(! function_exists('getOS'))
	{
		function getOS()
		{
		    global $user_agent;
		    $os_platform = "Unknown OS Platform";

		    $os_array    = array(
	                            '/windows nt 10/i'     =>  'Windows 10',
	                            '/windows nt 6.3/i'     =>  'Windows 8.1',
	                            '/windows nt 6.2/i'     =>  'Windows 8',
	                            '/windows nt 6.1/i'     =>  'Windows 7',
	                            '/windows nt 6.0/i'     =>  'Windows Vista',
	                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                            '/windows nt 5.1/i'     =>  'Windows XP',
	                            '/windows xp/i'         =>  'Windows XP',
	                            '/windows nt 5.0/i'     =>  'Windows 2000',
	                            '/windows me/i'         =>  'Windows ME',
	                            '/win98/i'              =>  'Windows 98',
	                            '/win95/i'              =>  'Windows 95',
	                            '/win16/i'              =>  'Windows 3.11',
	                            '/macintosh|mac os x/i' =>  'Mac OS X',
	                            '/mac_powerpc/i'        =>  'Mac OS 9',
	                            '/linux/i'              =>  'Linux',
	                            '/ubuntu/i'             =>  'Ubuntu',
	                            '/iphone/i'             =>  'iPhone',
	                            '/ipod/i'               =>  'iPod',
	                            '/ipad/i'               =>  'iPad',
	                            '/android/i'            =>  'Android',
	                            '/blackberry/i'         =>  'BlackBerry',
	                            '/webos/i'              =>  'Mobile'
		                    );

		    foreach ($os_array as $regex => $value)
		    { 
		        if (preg_match($regex, $user_agent))
		        {
		            $os_platform = $value;
		        }
		    }
		    return $os_platform;
		}
	}

	if(! function_exists('getBrowser'))
	{
		function getBrowser()
		{
		    $user_agent     = $_SERVER['HTTP_USER_AGENT'];
		    $browser        = "Unknown Browser";
		    $browser_array  = array(
		                            '/msie/i'       =>  'Internet Explorer',
		                            '/firefox/i'    =>  'Firefox',
		                            '/safari/i'     =>  'Safari',
		                            '/chrome/i'     =>  'Chrome',
		                            '/edge/i'       =>  'Edge',
		                            '/opera/i'      =>  'Opera',
		                            '/netscape/i'   =>  'Netscape',
		                            '/maxthon/i'    =>  'Maxthon',
		                            '/konqueror/i'  =>  'Konqueror',
		                            '/mobile/i'     =>  'Handheld Browser'
		                        );

		    foreach($browser_array as $regex => $value)
		    { 
		        if(preg_match($regex, $user_agent))
		        {
		            $browser = $value;
		        }
		    }
		    return $browser;
		}
	}

	/* function used for encrypt password with sha512  */
	if (!function_exists('encrypt_password'))
	{
		function encrypt_password($password)
		{
			$ci     = &get_instance();
			$key    = $ci->config->item('encryption_key');
			$salt1  = hash('sha512', $key . $password);
		    $salt2  = hash('sha512', $password . $key);
			$hashed_password = hash('sha512', $salt1 . $password . $salt2);
			return $hashed_password;
		}
	}

	if(! function_exists('getuniquenumber'))
	{
		function getuniquenumber()
		{
			//////////////////GENERATE TRX #
			$a1 = date("ymd", time());
			$a2 = rand(100,999);
			$u = substr(uniqid(), 7);
			$c = chr(rand(97,122));
			$c2 = chr(rand(97,122));
			$c3 = chr(rand(97,122));
			$ok = "$c$u$c2$a2$c3";
			$txn_id = strtoupper($ok);
			return $txn_id;
			//////////////////GENERATE TRX #
		}
	}

	//Push Android
	if(!function_exists('sendPushAndroid'))
	{
		function sendPushAndroid($to, $title, $type , $message = '')
		{ 
		    $ci     = & get_instance();
		    $apiKey = $ci->config->item('android_server_key');

		    $msg = array('body'  => $message,
		                 'title' => $title,
		                 'type' => $type,
		                 'message'=>  $title,
		                 "sound" => "default",
		                 //"click_action" => "com.shikha365.activities.SplashActivity",
		            );
		    $fields = array(
		                'to' 	=> $to,
		                'data' => array('title' => 'egPay', 'message' => $title, 'type' => $type,  'sound' => 'default'  ),
		                'content_available' => true,
		                'priority'          =>'high'
		            );

		    $headers = array(
		            'Authorization: key=' . $apiKey,
		            'Content-Type: application/json'
		        );

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		    $response = curl_exec($ch);
		    curl_close($ch);
		    //print_r($response);
		}
	}

	//Push Ios
	if(!function_exists('sendPushIos'))
	{
		function sendPushIos($to, $title, $type , $message = '')
		{
            $message              = $message;
		    $token                = $to;
		    $title                = $title;
		    $notification_setting = '';

		    $ci = &get_instance();

		    $apiKey = $ci->config->item('android_server_key');
		    $icon   = 'https://static.pexels.com/photos/4825/red-love-romantic-flowers.jpg';
		    $msg    = array('body' => $title,
					        'title' => $title,
					        'notification_setting' => $notification_setting,
					        'icon' => 'icon',
					        "sound" => "default",
					        "click_action" => "FCM_PLUGIN_ACTIVITY"
					    );

		    $fields = array(
					        'to' => $token,
					        'notification' => $msg,
					        'data' => $msg,
					        'content_available' => true,
					        'priority' => 'high',
					    );

		    $headers = array(
					        'Authorization: key=' . $apiKey,
					        'Content-Type: application/json',
					    );

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$response = curl_exec($ch);
			curl_close($ch);
		}
	}

	function create_ref($tblm,$param)
	{
        $ci = &get_instance();
	    $a1 = date("ymd", time());
		$a2 = rand(100,999);
		$u = substr(uniqid(), 7);
		$c = chr(rand(97,122));
		$c2 = chr(rand(97,122));
		$c3 = chr(rand(97,122));
		$ok = "$c$u$c2$a2$c3";
		$ok1="$c2$u$c$a2$c3";
		$txn_id = strtoupper($ok1);
	    $ref_id= strtoupper($ok);
        $condition = array($param => $ref_id);
	    $result    = getdatafromtable($tblm,$condition,$param);  
        if(!empty($result)){         
            return $txn_id;
        } else {
            return $ref_id;
        }        
    }

    //JSON data encryption/decryption function 
    function encrypt_decrypt($action, $string)
    {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    // hash
	    $key = hash('sha256', ENCRYPTION_KEY);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', ENCRYPTION_IV), 0, 16);
	    if ($action == 'encrypt') 
	    {
	        $output = openssl_encrypt($string, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
	        $output = base64_encode($output);
	    }
	    else if($action == 'decrypt')
	    {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
	    }
	    return $output;
	}

	if(! function_exists('check_expiry_year'))
	{
		function check_expiry_year($expiry_year)
		{
			$cur_year = date('Y');
            if($expiry_year>=$cur_year)
		    { 
				return true; 
			}
			else
			{ 
				return false;
			}
		}
	}

	if(! function_exists('check_expiry_month_year'))
	{
		function check_expiry_month_year($expiry_month,$expiry_year)
		{
			$cur_year  = date('Y');
			$cur_month = date('m');
            if($expiry_year>=$cur_year)
		    { 
		    	if($expiry_year == $cur_year)
		    	{
			    	if($expiry_month>=$cur_month)
						return true; 
					else
						return false;
				}
				else
				{
					return true;
				}
			}
			else
			{ 
				return false;
			}
		}
	}

	if(! function_exists('check_authorization')) {
	//Check Auth for customer or merchant 
	function check_authorization($logout = NULL) {
		$ci = & get_instance();
		$ci->load->model('dynamic_model');
		//$ci->lang->load("message","english");
		$language = $ci->input->get_request_header('language');
		// if($language == "en")
		// {
		// 	$ci->lang->load("message","english");
		// }
		if($language == "sw")
		{
			$ci->lang->load("message","swedish");
		}
		else
		{
			$ci->lang->load("message","swedish");
		}

	    $auth_token = $ci->input->get_request_header('Authorization');
	    $user_token = json_decode(base64_decode($auth_token));
	    if(!empty($user_token)){
	    	$usid     =  $user_token->userid;
			$auth_key =  $user_token->token;
			if($usid != '' && $auth_key != '') {
				$condition = array(
					'id' => $usid,
					'token' => $auth_key
				);
				$loguser = $ci->dynamic_model->getdatafromtable($ci->db->dbprefix.'Users', $condition);
				if($loguser) {
					//if($usid == $loguser[0]['id'] && $auth_key == $loguser[0]['token']) {
					if($usid == $loguser[0]['id'] && $auth_key == $loguser[0]['token'] && $loguser[0]['status'] == 1) {

						if(!empty($logout)) {
							$data2 = array(
								'token' => '',
								'device_id'   => '',
								'device_type' => ''
								//'Is_LoggedIn' => '0'
							);
			                $wheres = array("id" => $usid);
			                $result = $ci->dynamic_model->updateRowWhere($ci->db->dbprefix."Users", $wheres, $data2);

							return $ci->lang->line('logout_success');
						} else {
							return true;
						}

					} else {
						return $ci->lang->line('session_expire');
					}


				} else {
					return $ci->lang->line('varify_token_userid');
				}
			} else {
				return $ci->lang->line('header_required');
			}
	    } else {
	    	return $ci->lang->line('header_required');
	    }

	}
	}

	// Get user id
	if (!function_exists('getuserid')) {
		function getuserid(){
			$ci = & get_instance();
			$ci->load->model('dynamic_model');
			//$ci->lang->load("message","english");
            $language = $ci->input->get_request_header('language');
			// if($language == "en")
			// {
			// 	$ci->lang->load("message","english");
			// }
			if($language == "sw")
			{
				$ci->lang->load("message","swedish");	
			}
			else
			{
				$ci->lang->load("message","swedish");
			}
		    $auth_token = $ci->input->get_request_header('Authorization');
		    $user_token = json_decode(base64_decode($auth_token));

			$where = array("id" => $user_token->userid);
			$users = $ci->dynamic_model->getdatafromtable($ci->db->dbprefix."Users", $where);
			if(!empty($users))
			{
				return $users[0]['id'];
			}
			else
			{
				return false;
			}
		}
	}

	// Check Limit
	if (!function_exists('check_limit'))
	{
		function check_limit($amount,$userid,$limit_type,$tran_type_id)
		{
			$ci = & get_instance();
			//$ci->load->model('master_model');
			$ci->load->model('dynamic_model');
			$ci->lang->load("message","english");
			$arg  = array();
			$arg1 = array();
			if($limit_type == "daily")
			{
				$condt = "to_user_id = ".$userid. " And cast(FROM_UNIXTIME(created_on) as DATE) ='".date('Y-m-d')."' AND tran_type_id = '".$tran_type_id."' GROUP BY tran_type_id DESC";

				$get_transition = getdatafromtable($ci->db->dbprefix.'Transactions', $condt, "tran_type_id, count(id) as total, SUM(`amount`) as totalamount" );
				
				$condition2 = array("tran_type_id" => $tran_type_id);
				$getlimit   = getdatafromtable($ci->db->dbprefix.'Transactions_Limit', $condition2);

				$user_left_amount_limit = $getlimit[0]['daily_limit']- $get_transition[0]['totalamount'];
				if($amount <= $user_left_amount_limit && $get_transition[0]['total'] <= $getlimit[0]['count_limit'])
				{
					// if(!empty($getlimit))
					// {
					// 	$arg = array("user_left_amount_limit"=>$user_left_amount_limit,"total"=>$get_transition[0]['total'],"count_limit"=>$getlimit[0]['count_limit']);
					// 	return $arg;
					return true;
				}
				else
				{
					return false;
					//return $arg;
				}
			}

			if($limit_type == "monthly")
			{
				$end   = date('Y-m-d');
				$start = date("Y-m-01", strtotime($end));
				$condt = "to_user_id = ".$userid. " And cast(FROM_UNIXTIME(created_on) as DATE) BETWEEN '".$start."' AND '".$end."' AND tran_type_id = '".$tran_type_id."' GROUP BY tran_type_id DESC";

				$get_transition = getdatafromtable($ci->db->dbprefix.'Transactions', $condt, "tran_type_id, count(id) as total, SUM(`amount`) as totalamount" );
				
				$condition2 = array("tran_type_id" => $tran_type_id);
				$getlimit   = getdatafromtable($ci->db->dbprefix.'Transactions_Limit', $condition2);

				$user_left_amount_limit = $getlimit[0]['monthly_limit']- $get_transition[0]['totalamount'];
				if($amount <= $user_left_amount_limit && $get_transition[0]['total'] <= $getlimit[0]['monthly_trans_limit'])
				//if(!empty($getlimit))
				{
					// $arg1 = array("user_left_amount_limit"=>$user_left_amount_limit,"total"=>$get_transition[0]['total'],"count_limit"=>$getlimit[0]['monthly_trans_limit']);
					// return $arg1;
					return true;
				}
				else
				{
					return false;
					//return $arg1;
				}
			}			
		}
	}

	function sendSms($phone, $message)
	{
	   $CI = &get_instance();
	   if (!empty($phone) && !empty($message)) {

	       $send_otp = $CI->config->item('send_otp');
	       if ($send_otp == '0') {
	           return true;
	       }
	       //$msg91_authkey = $CI->config->item('msg91_authkey');
	       $site_name = 'Ipant';
	       //Your authentication key
	       $authKey = $CI->config->item('msg91_authkey');
	       $mobileNumber = $phone;
	       $senderId = ucfirst($site_name);

	       $message = str_replace('\\r\\n', '', $message);
	       $message = str_replace('\r\n', '', $message);
	       $message = str_replace('\r', '', $message);
	       $message = str_replace('\n', '', $message);

	       //$message = urlencode($message);
	       $route = "4";
	       $postData = array(
	           'authkey' => $authKey,
	           'mobiles' => $mobileNumber,
	           'message' => $message,
	           'sender' => $senderId,
	           'route' => $route,
	           'country' => '91',
	       );

	       //API URL
	       $url = "https://control.msg91.com/api/sendhttp.php";
	       $ch = curl_init();
	       curl_setopt_array($ch, array(
	           CURLOPT_URL => $url,
	           CURLOPT_RETURNTRANSFER => true,
	           CURLOPT_POST => true,
	           CURLOPT_POSTFIELDS => $postData,
	       ));
	       //Ignore SSL certificate verification
	       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	       $output = curl_exec($ch);
	       if (curl_errno($ch)) {
	           //echo 'error:' . curl_error($ch);
	       }
	       curl_close($ch);
	       return true;
	   } else {
	       return false;
	   }
	}
	if (!function_exists('pilvo_sms')){
	function pilvo_sms($country_code, $mobile_no, $otpmsg){
		require_once './plivo/plivo.php';
		$auth_id = PILVO_AUTH_ID;
		$auth_token = PILVO_AUTH_TOKEN;

		$p = new RestAPI($auth_id, $auth_token);
		if (!empty($mobile_no)) {
			$dst = $mobile_no;
			$country_code = (!empty($country_code)) ? $country_code : '46';
			$message = $otpmsg;
			//$message="Thank you. We will notify you with any important updates, including the link to download Dapple Pay when we launch";
			// Send a message
				$params = array(
					'src' => '46701941010', // Sender's phone number with country code
					'dst' => $country_code.$dst, // Receiver's phone number with country code
					'text' => $message, // Your SMS text message
					// To send Unicode text
					'url' => 'http://admin.ipant.se/', // The URL to which with the status of the message is sent
					'method' => 'POST', // The method used to call the url
				);
			

			// Send message
			$response = $p->send_message($params);
			 //print_r( $response['response']);die;
			if (@$response['response']['error'] == '') {
				if (@$response['status'] == 200 || 202) {
					//$return = array('status'=>true,'message'=>'Mesage send successfully to your mobile number please check');
					return true;
				} else {
					// $return = array('status'=>false,'message'=>'message send fail');
					return false;
				}
			} else {
				$error_msg = @$response['response']['error'];
				// $return = array('status'=>false,'message'=>'Mobile number is invalid '.$error_msg);
				return false;
			}
		} else {
			//$return = array('status'=>false,'message'=>'Mobile number Cannot be left blank');
			return false;
		}
		//echo json_encode($return);
	}
}



	function generatePIN($digits = 4){
    $i = 0; //counter
    
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
	}
	function generate_Pin(){
 
    $pin= substr(str_shuffle("1234567809"),0,6);
    return $pin;
}


	function getPaymentStatusText($status)
    {   
        if($status == 1 ){
            $payment_status = '<span class="text text-warning">Pending</span>';
        }
        if($status == 2 ){
            $payment_status = '<span class="text text-primary">Processed</span>';
        }
        if($status == 3 ){
            $payment_status = '<span class="text text-warning">Hold</span>';
        }
        if($status == 4 ){
            $payment_status = '<span class="text text-danger">Reject</span>';
        }
        if($status == 5 ){
            $payment_status = '<span class="text text-primary">Refund</span>';
        }
        if($status == 6 ){
            $payment_status = '<span class="text text-success">Success</span>';
        }
        if($status == 7 ){
            $payment_status = '<span class="text text-danger">Cancel</span>';
        }
        return $payment_status;
    }

//     function paySafe($merchantRefNum='')
// 	{
// 	   $CI = &get_instance();
// 	       //API URL
// 	       $url = "https://api.test.netbanx.com/cardpayments/v1/accounts/1001363210/auths/b16a3ca5-a9b7-4bf3-bd3d-539e7e7c2dca/settlements";
// 	       $postData= array('merchantRefNum'=>$merchantRefNum);
// 	       $data_json=json_encode($postData);
// 	       $ch = curl_init();
// 	       curl_setopt_array($ch, array(
// 	           CURLOPT_URL => $url,
// 	           CURLOPT_RETURNTRANSFER => true,
// 	           CURLOPT_POST => true,
// 	           CURLOPT_POSTFIELDS => $data_json,
// 	       ));
// 	       //Ignore SSL certificate verification
// 	       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// 	       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// 	       $output = curl_exec($ch);
// 	       if (curl_errno($ch)) {
// 	           //echo 'error:' . curl_error($ch);
// 	       }
// 	       print_r( $output);exit;
// 	       curl_close($ch);
// 	       return true;
	   
// 	}

function add_money_using_card($postData=''){
require_once('./paysafe/sample/config.php');
	$client = new PaysafeApiClient(PAYSAFEAPIKEYID, PAYSAFEAPIKEYSECRET, Environment::TEST,PAYSAFEACCOUNTNUMBER);
	 try {       
		$auth = $client->cardPaymentService()->authorize(new Authorization($postData));       
		
		$response= json_encode(array('status'=>true,'auth_id'=>$auth->id,'message'=>'Successful!'));
		    // print_r($response);exit;
		return $response;
	
	} catch (Paysafe\PaysafeException $e) {
		//echo $e->getMessage();
		$response= json_encode(array('status'=>false,'message'=>$e->getMessage()));
		return $response;
		
		
	} catch (Paysafe\PaysafeException $e) {
		//for debug only, these errors should be properly handled before production
		//var_dump($e->getMessage());
		return false;
	}
}
function callback_card_status($auth_id){
require_once('./paysafe/sample/config.php');

$client = new PaysafeApiClient(PAYSAFEAPIKEYID, PAYSAFEAPIKEYSECRET, Environment::TEST,PAYSAFEACCOUNTNUMBER);
	 try {        
        
        $postdatas= array('id'=>$auth_id);
		//$auth = $client->cardPaymentService()->settlement(new Settlement($postdatas));
            $auth = $client->cardPaymentService()->getSettlement(new Settlement($postdatas));  
            $response= json_encode(array('status'=>$auth->status,'amount'=>$auth->amount));
		    // print_r($response);exit;
		     return $response;
		
	} catch (Paysafe\PaysafeException $e) {
		return $response= json_encode(array('error_message'=>$e->getMessage()));
		// if ($e->fieldErrors) {
		// 	print_r($e->fieldErrors);

		// }
		// if ($e->links) {
		// 	print_r($e->links);
		// }
	} catch (Paysafe\PaysafeException $e) {
		//for debug only, these errors should be properly handled before production
		print_r($e->getMessage());
	}
}
function get_gift_card_balance11($card_number=""){

if(!empty($card_number)){
    $soapUrl = "https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService"; // asmx URL of WSDL
    $soapUser = USERNAME_GIFT_CARD;  //  username
    $soapPassword = PASSWORD_GIFT_CARD; // password

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:giftcard=\"http://butiksservice.resurs.com/msg/giftcard\">\n   <soapenv:Header/>\n   <soapenv:Body>\n      <giftcard:getBalance>\n         <cardNumber>9752257840738501</cardNumber>\n </giftcard:getBalance>\n   </soapenv:Body>\n</soapenv:Envelope>\n",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Basic dGVzdGdpZnRjYXJkaXBhbnQjMTA3I1NFOjEwNw==",
	    "Content-Type: text/xml",
	    "Postman-Token: 54a40e53-1318-4922-8dfd-5b5806430c34",
	    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
}else{
	return false;
}
}

 function get_gift_card_balance($card_number='')
 {
	  if(!empty($card_number)){
	    //Data, connection, auth
        $soapUrl = "https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService"; // asmx URL of WSDL
        $soapUser = USERNAME_GIFT_CARD;  //  username
        $soapPassword = PASSWORD_GIFT_CARD; // password

        // xml post structure
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:giftcard="http://butiksservice.resurs.com/msg/giftcard">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <giftcard:getBalance>
		         <cardNumber>'.$card_number.'</cardNumber>
		      </giftcard:getBalance>
		   </soapenv:Body>
		</soapenv:Envelope>';   // data from the form, e.g. some ID number';

       $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService", 
                    "Content-length: ".strlen($xml_post_string),
                ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 


            curl_close($ch);
            // convertingc to XML
           // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
            $response3 = str_replace('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">',"",$response2);
            $response4 = str_replace("</soap:Envelope>","",$response3);
			$parser = @simplexml_load_string($response4);
			$result = json_encode($parser);
			 //echo "<pre>";print_r($result);die;

            return $result;
       }else{
       	return false;           
	  } 
}
function load_card_balance($card_number='',$amount='')
 {
	  if(!empty($card_number)){
	    //Data, connection, auth
        $soapUrl = "https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService"; // asmx URL of WSDL
        $soapUser = USERNAME_GIFT_CARD;  //  username
        $soapPassword = PASSWORD_GIFT_CARD; // password

        // xml post structure
		  $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:giftcard="http://butiksservice.resurs.com/msg/giftcard">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <giftcard:load>
		         <cardNumber>'.$card_number.'</cardNumber>
		         <amount>'.$amount.'</amount>
		      </giftcard:load>
		   </soapenv:Body>
		</soapenv:Envelope>';   // data from the form, e.g. some ID number';
       $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://ws.butiksservice.resurs.com/ws-22/giftcard/GiftCardService", 
                    "Content-length: ".strlen($xml_post_string),
                ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
            curl_close($ch);
            // convertingc to XML
           // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
            $response3 = str_replace('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">',"",$response2);
            $response4 = str_replace("</soap:Envelope>","",$response3);
			$parser = simplexml_load_string($response4);
			$result = json_encode($parser);

            return $result;
       }else{
       	return false;           
	  } 
}
