<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function get_country(){
		$this->db->select('*');
		$this->db->from('Countries');
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
		$query = $this->db->get_where("Users", $arg);
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
		$query = $this->db->get_where("Users", $arg);
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
		$query = $this->db->get_where('Users', $key);
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
		$query=$this->db->from('Options');
		$query=$this->db->where($condition);
		$query=$this->db->get();
		return $query->result_array();
	}

	/*************** update options *******************/	

	public function updateoptions($condition, $data)
	{
		$this->db->where($condition);
		$this->db->update('options', $data);
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

	//function for check Phone or Email credentials
	function check_userdetails($email)
	{
		$this->db->select('*');
		$this->db->from('Users');
		$this->db->where('Email', $email);
		$this->db->or_where('Mobile_No', $email);
		$query=$this->db->get(); 
		return $query->row_array();
	}

	//function for check payment request history 
	function check_request_history($id,$type)
	{
		$this->db->select('*');
		$this->db->from('Request_Share');
		$this->db->where('From_User_Id', $id);
		$this->db->or_where('To_User_Id', $id);
		$this->db->where('Type', $type);
		$this->db->order_by("Id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	}

	//function for check card details 
	function check_card_details($id)
	{
		$this->db->select('*');
		$this->db->from('User_Payment_Methods');
		$this->db->where("(Is_Debit_Card = '1' OR Is_Credit_Card = '1')", NULL, FALSE);
		//$this->db->where('Is_Debit_Card', 1);
		//$this->db->or_where('Is_Credit_Card', 1);
		$this->db->where('User_Id',$id);
		$this->db->where('Is_Deleted',0);
		$this->db->order_by("Id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	}

	//function for check payment request type
	function check_request_type($id,$status_id)
	{
		$this->db->select('*');
		$this->db->from('Request_Share');
		$this->db->where("(Type = 'Req_money' OR Type = 'Sharebill_req')", NULL, FALSE);
		$this->db->where('To_User_Id', $id);
		$this->db->where('Tran_Status_Id', $status_id);
		$this->db->order_by("Id", "DESC");
		$query=$this->db->get(); 
		return $query->result_array();
	}
}