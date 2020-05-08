<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function get_country(){
		$this->db->select('*');
		$this->db->from($this->db->dbprefix.'Countries');
		//$this->db->order_by('nicename',"ASC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insertdata($tbnm = null,$var = array())
	{
		$this->db->insert($tbnm, $var);
		return $this->db->insert_id(); 
	}

	function deletedata($tbnm=null,$where = array())
	{
	   $this->db->where($where);
	   $this->db->delete($tbnm);
	   return $tbnm; 
    }

	public function updatedata($tbnm = null,$var = array(), $postid)
	{
		$this->db->where('id', $postid);
		$this->db->update($tbnm, $var);
		return $this->db->insert_id(); 
	}

	function updateRowWhere($table, $where = array(), $data = array())
	{
	    $this->db->where($where);
	    $this->db->update($table, $data);
	    $updated_status = $this->db->affected_rows();
 		return $updated_status;
	}

	

	public function add_user_meta($usid = 0,$key = null,$val = null)
	{
		$arg = array(
		    'user_id' => $usid,
		    'meta_key' => $key,
		    'meta_value' => $val
		);
		$this->db->insert('user_meta', $arg);
	}

	public function fileupload($filenm, $foldername){
		if(!empty($_FILES[$filenm]['name'])){
			$new_image_name = time().str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES[$filenm]['name']);
		 	$config['upload_path'] = './'.$foldername.'/';
            $config['allowed_types'] = 'mp4|3gp|mpeg|jpg|jpeg|png|gif';
            $config['file_name'] = $new_image_name;
		    $config['overwrite'] = TRUE;
		    $config['max_width']  = '0';
		    $config['max_height']  = '0';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload($filenm)){
                $uploadData = $this->upload->data();
                $config['image_library'] = 'gd2'; 
                $config['source_image'] = $uploadData['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 300;
				$config['height']       = 300;
                $this->load->library('image_lib', $config);
                if (!$this->image_lib->resize()) {
                }
                $picture = $uploadData['file_name'];
            } else {
            	//$picture = $this->upload->display_errors();
                $picture = '';
                //$picture = $new_image_name;
            }
		} else {
		}
		return $picture;
	}

	public function multiple_fileupload($filenm, $foldername)
	{
    	$number_of_files = sizeof($_FILES["$filenm"]['tmp_name']);
    	$files = $_FILES["$filenm"];
    	$errors = array();
    	$upload_result = array();
 
	    for($i=0;$i<$number_of_files;$i++) {
	      if($_FILES["$filenm"]['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES["$filenm"]['name'][$i];
	    }
	    if(sizeof($errors)== 0) {
	      $this->load->library('upload');

	      $config['upload_path'] = './'.$foldername.'/';
	      $config['allowed_types'] = 'mp4|3gp|mpeg|jpg|jpeg|png|gif';
	      for ($i = 0; $i < $number_of_files; $i++) {
	        $_FILES['uploadedimage']['name'] = time().str_replace(str_split(' ()\\/,:*?"<>|'), '', 

    		$_FILES[$filenm]['name'])[$i];
	        $_FILES['uploadedimage']['type'] = $files['type'][$i];
	        $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
	        $_FILES['uploadedimage']['error'] = $files['error'][$i];
	        $_FILES['uploadedimage']['size'] = $files['size'][$i];
	        $this->upload->initialize($config);
	        if ($this->upload->do_upload('uploadedimage'))  {
	          $data = $this->upload->data();
	          $upload_result[$i] = $data['file_name'];
	        } else {
	          $data['upload_errors'][$i] = $this->upload->display_errors();
	        }
	      }
	    } else {
	      $upload_result['error'] = $errors;
	    }
	    return $upload_result;
	}

	public function checkEmail($key)
	{
		$arg = array(
		    'Email' => $key
		);
		$query = $this->db->get_where($this->db->dbprefix."Users", $arg);
		if($query->num_rows() != 0){
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function checkMobile($key)
	{
		$arg = array(
		    'Mobile_No' => $key
		);
		$query = $this->db->get_where($this->db->dbprefix."Users", $arg);
		if($query->num_rows() != 0){
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_user_by_id($usid = 0)
	{
		$key = array(
			'Id' => $usid
		);
		$query = $this->db->get_where($this->db->dbprefix.'Users', $key);
		return $query->row_array();
	}

	public function get_user($usid)
	{
		$data = $this->get_user_by_id($usid);
		return $data;
	}

	/*************** Get Table Data *******************/

	public function getdatafromtable($tbnm, $condition = array(), $data = "*", $limit="", $offset="", $orderby ='')
	{
		$this->db->select($data);
		$this->db->from($tbnm);
		if(!empty($condition)){
			$this->db->where($condition);
		}
        $this->db->order_by("$orderby", "DESC");
		If($limit != '')
		{
			$this->db->limit($limit, $offset);
		}

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getdatafromtable2($tbnm, $condition = array(), $data = "*", $limit="", $offset="",$groupBy="")
	{
		$this->db->select($data);
		$this->db->from($tbnm);
		$this->db->where($condition);
		If($limit != ''){
			$this->db->limit($limit, $offset);
		}
		If($groupBy != ''){
			$this->db->group_by($groupBy);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	/*************** Count *******************/	

	public function countdata($tablename,$condition)
	{
		$this->db->select('COUNT(*) as counting');
		$query=$this->db->from($tablename);
		$query=$this->db->where($condition);
		$query=$this->db->get();
		return $query->result_array();
	}

	/*************** Option Table data *******************/	

	public function getoptions($condition)
	{
		$this->db->select('option_value');
		$query=$this->db->from($this->db->dbprefix.'Options');
		$query=$this->db->where($condition);
		$query=$this->db->get();
		return $query->result_array();
	}

	/*************** update options *******************/	

	public function updateoptions($condition, $data)
	{
		$this->db->where($condition);
		$this->db->update($this->db->dbprefix.'Options', $data);
		return $this->db->insert_id(); 
	}

	/* GET THREE TABLE DATA  */

	/****************************************/

	public function getTwoTableData($data,$table1,$table2,$on,$condition = '')
	{
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        if(!empty($condition))
        {
            $this->db->where($condition);
        }
	    $query=$this->db->get();
        return $query->result_array();
	}

	public function getJoinWithPaging($data,$table1,$table2,$on,$condition = '',$limit="", $offset="",$orderby='')
	{
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        if(!empty($condition))
        {
            $this->db->where($condition);
        }
        if($orderby !=''){
           $this->db->order_by($orderby, "DESC");
        }
        if($limit != ''){
		  $this->db->limit($limit, $offset);
	    }
        $query=$this->db->get();
        return $query->result_array();
	}

	public function getThreeTableData($data,$table1,$table2,$table3,$on,$on2,$condition)
	{
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        $this->db->join($table3,$on2);        
         $this->db->where($condition);
        $query=$this->db->get();
        return $query->result_array();
	}

	public function getFourTableData($data,$table1,$table2,$table3,$table4,$on,$on2,$on3,$condition = '', $limit="", $offset="") {
        $this->db->select($data);
        $this->db->from($table1);
        $this->db->join($table2,$on);
        $this->db->join($table3,$on2);
        $this->db->join($table4,$on3);
        if(!empty($condition)) {
            $this->db->where($condition);
        }
        if($limit != ''){
		  $this->db->limit($limit, $offset);
	    }
        $query=$this->db->get();
        return $query->result_array();
	}

	/* Get search Query */

	function get_search($tbnm, $match) 
	{
		$this->db->like('company_nm','jain');
		$this->db->or_like('author','test');
		/*
		$this->db->or_like('author',$match);
		$this->db->or_like('characters',$match);
		$this->db->or_like('synopsis',$match);
		*/
		$query = $this->db->get($tbnm);
		return $query->result();
	}

	/* Get search Query */

	function filter($tbnm, $match, $column)
	{
		$this->db->like($column,$match);
		//$this->db->or_like('author','test');
		/*
		$this->db->or_like('author',$match);
		$this->db->or_like('characters',$match);
		$this->db->or_like('synopsis',$match);
		*/
		$query = $this->db->get($tbnm);
		return $query->result_array();
	}

	/**
	* Function for get row array from table
	* Parameters : 
	*	@table :
	*	@where :
	*	@select : Optional
	*/
	function get_row($table, $where, $select='')
	{
		if($select == '')
			$this->db->select('*');
		else
			$this->db->select($select);

		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	* Function for get result array from table
	* Parameters : 
	*	@table :
	*	@where :
	*	@select : Optional
	*/
	function get_rows($table, $where, $select='', $order_by='', $order='')
	{
		if($select == '')
			$this->db->select('*');
		else
			$this->db->select($select);

		$this->db->from($table);
		$this->db->where($where);

		if($order_by != '' && $order != '')
			$this->db->order_by($order_by, $order);

		$query = $this->db->get();
		return $query->result_array();
	}
    public function remove_zero_number($number=''){
		// Remove the spaces.
		$number = str_replace(' ', '', $number);
		// Grab the first number. 
		$first_number = substr($number, 0, 1); 
		if ($first_number == 0) {
		  // Check if the first number is 0.
		  // Get rid of the first number.
		  $number = substr($number, 1, 999); 
		}
		// Remove the + sign.
		//$number = str_replace('+', '', $number);
		return $number;
    }
	//function for check Phone or Email credentials
	function check_userdetails($email)
	{
			$finalData=array();
			if(strlen($email)==9){
				$Mob='0'.$email;
			}else{
               $Mob=$email;
			}
			$this->db->select('*');
			$this->db->from($this->db->dbprefix.'Users');
			$this->db->where('email', $Mob);
			$this->db->or_where('mobile_no',$Mob);
			$query =$this->db->get(); 
			$userdata1=$query->row_array();
		    if(!empty($userdata1)){
		     $finalData= $userdata1;
		 }else if(empty($userdata2)){ 
		 	$mobile =$this->remove_zero_number($email);
		 	$this->db->select('*');
			$this->db->from($this->db->dbprefix.'Users');
			$this->db->where('email',$mobile);
			$this->db->or_where('mobile_no',$mobile);
			$query2=$this->db->get(); 
			$userdata3 =$query2->row_array();
           $finalData= $userdata3;
		 }else if(empty($userdata1)){
		 	$this->db->select('*');
			$this->db->from($this->db->dbprefix.'Users');
			$this->db->where('email', $email);
			$this->db->or_where('mobile_no', $email);
			$query3=$this->db->get(); 
			$userdata4 =$query3->row_array();
			$finalData= $userdata4;
		 }	
		 return $finalData;	
	}

	//function for check payment request history 
	function check_request_history($id,$type)
	{
		$this->db->select('*');
		$this->db->from('Request_Share');
		$this->db->where('from_user_id', $id);
		$this->db->or_where('to_user_id', $id);
		$this->db->where('type', $type);
		$this->db->order_by("id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	}

	//function for check card details 
	function check_card_details($id)
	{
		$this->db->select('*');
		$this->db->from($this->db->dbprefix.'User_Payment_Methods');
		$this->db->where("(is_debit_card = '1' OR is_credit_card = '1')", NULL, FALSE);
		//$this->db->where('Is_Debit_Card', 1);
		//$this->db->or_where('Is_Credit_Card', 1);
		$this->db->where('user_id',$id);
		$this->db->where('is_deleted',0);
		$this->db->order_by("id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	}

	//function for check payment request type
	function check_request_type($id,$status_id)
	{
		$this->db->select('*');
		$this->db->from('Request_Share');
		$this->db->where("(type = 'Req_money' OR type = 'Sharebill_req')", NULL, FALSE);
		$this->db->where('to_user_id', $id);
		$this->db->where('tran_status_id', $status_id);
		$this->db->order_by("id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	} 


    //function for check Transaction Pin
	function checkTransactionPin($userid='',$pin=''){
	 	$this->db->select('id');
	    $this->db->from($this->db->dbprefix.'Users');    
	    $this->db->where('id',$userid);
	    $this->db->where('transaction_password',encrypt_password($pin));
	    $query= $this->db->get();
	     
	    if($query->num_rows()> 0){
			return true;
		}else{
			return false;
		}
	}
        
        //changes done by harish
        public  function get_fees_charge(){           
           
                $charge_detail =array(); 
                $data = []; 
                $this->db->select('option_value');

                $this->db->from('Options');
                $this->db->where('option_name','charge_method');
                $query = $this->db->get();
              
                if ( $query->num_rows() > 0 )
                   {   
                        $row = $query->row_array(); 
                        $charge_detail['charge_method'] = $row['option_value'];   
                    }
                
                $this->db->select('option_value');
                $this->db->from('Options');
                $this->db->where('option_name','charge_fee');
                $query = $this->db->get();
              
                  if ( $query->num_rows() > 0 )
                    {   
                        $row = $query->row_array(); 
                        $charge_detail['charge_fee'] = $row['option_value'];   
                    }
                
                return $charge_detail;
       	}

}