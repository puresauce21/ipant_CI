<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/*
====================================================================================================
	* 
	* @description: This is coomon model for admin and all user type
	* 
	* 
====================================================================================================*/

class Common_model extends CI_Model{
   
    function __construct(){
        parent::__construct();    
         //$this->load->library('image_lib');
    }
    
	/*
	 * @description: This function is used countResult
	 * 
	 */ 
	
	function countResult($table='',$field='',$value='', $limit=0,$groupBy = ''){
	
		if(is_array($field)){
				$this->db->where($field);
		}
		elseif($field!='' && $value!=''){
			$this->db->where($field, $value);
		}	
		$this->db->from($table);
		if(!empty($groupBy)){
			$this->db->group_by($groupBy);
		}
		
		if($limit >0){
			$this->db->limit($limit);
		}
		
		 $res= $this->db->count_all_results();
		// echo $this->db->last_query();
		 return $res;
		 
	}

	
	/*
	 * @description: This function is used getDataFromTabelWhereIn
	 * 
	 */ 
	
	function getDataFromTableWhereIn($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $whereNotIn=0){
		
		$table=$table;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if($whereNotIn > 0){
			$this->db->where_not_in($whereField, $whereValue);
		}else{
			$this->db->where_in($whereField, $whereValue);
		}
		
		if(is_array($orderBy) && count($orderBy)){
			/* $orderBy treat as where condition if $orderBy is array  */
			$this->db->where($orderBy);
		}
		elseif(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		
		$query = $this->db->get();
		
		$result = $query->result_array();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	
	/*
	 * @description: This function is used getDataFromTabel
	 * 
	 */
	
	function getObjectDataFromTable($table='', $field='*',  $whereField='',$whereInField='',$whereNotIn=''){
		
		$table=$table;
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where($whereField);
		if($whereInField!=''){
			$this->db->where_not_in($whereInField, $whereNotIn);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->row();
		
		return 	$result;
	}

	/*
	 * @description: This function is used getDataFromTabelWhereWhereIn
	 * 
	 */
	
	function getDataFromTableWhereWhereIn($table='', $field='*',  $where='',  $whereinField='', $whereinValue='', $orderBy='', $whereNotIn=0){
	
		$table=$table;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereinValue);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	
	/*
	 * @description: This function is used getDataFromTabel
	 * 
	 */
	
	function getDataFromTable($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0, $offset=0, $resultInArray=false  ){
		
		$table=$table;
		 $this->db->select($field);
		 $this->db->from($table);
		
		if(is_array($whereField)){
			$this->db->where($whereField);
		}elseif(!empty($whereField) && $whereValue != ''){
			$this->db->where($whereField, $whereValue);
		}

		if(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		
		//echo $this->db->last_query(); die;
		if($resultInArray){
			$result = $query->result_array();
		}else{
			$result = $query->result();
		}
		
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	 * @description: This function is used addDataIntoTabel
	 * 
	 */
	
	function addDataIntoTable($table='', $data=array()){
		$table=$table;
		if($table=='' || !count($data)){
			return false;
		}
		$inserted = $this->db->insert($table , $data);
		$this->db->last_query();
		$ID = $this->db->insert_id();
		return $ID;
	}
	
	/*
	 * @description: This function is used updateDataFromTabel
	 * 
	 */
	 
	function updateDataFromTable($table='', $data=array(), $field='', $ID=0){
		$table=$table;
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			if(is_array($field)){
				
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
			}
			return $this->db->update($table , $data);
		}
	}
	/*
	 * @description: This function is used updateDataFromTabelWhereIn
	 * 
	 */
	
	function updateDataFromTabelWhereIn($table='', $data=array(), $where=array(), $whereInField='', $whereIn=array(), $whereNotIn=false){
		$table=$table;
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			if(is_array($where) && count($where) > 0){
				
				$this->db->where($where);
			}
			
			if(is_array($whereIn) && count($whereIn) > 0 && $whereInField != ''){
				if($whereNotIn){
					$this->db->where_not_in($whereInField,$whereIn);
				}else{
					$this->db->where_in($whereInField,$whereIn);
				}
			}
			return $this->db->update($table , $data);
		}
	}
	
	
	/*
	 * @description: This function is used deleteRowFromTabel
	 * 
	 */
	 
	function deleteRowFromTable($table='', $field='', $ID=0, $limit=0){
		$table=$table;
		$Flag=false;
		if($table!='' && $field!=''){
			if(is_array($ID) && count($ID)){
				$this->db->where_in($field ,$ID);
			}elseif(is_array($field) && count($field) > 0){
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
			}
			if($limit >0){
				$this->db->limit($limit);
			}
			if($this->db->delete($table)){
				$Flag=true;
			}
		}
		//echo $this->db->last_query();
		return $Flag;
	}
	
	/*
	 * @description: This function is used deletelWhereWhereIn
	 * 
	 */
	 
	 
	function deletelWhereWhereIn($table='', $where='',  $whereinField='', $whereinValue='', $whereNotIn=0){
		$table=$table;
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereNotIn);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if($this->db->delete($table)){
				return true;
		}else{
			return false;
		}
	}
	
	
	/*
	 * @description: This function is used deleteRow
	 * 
	 */

	function deleteRow($table,$where)
	{
		$table=$table;
		$this->db->delete($table, $where);
		//echo $sql = $this->db->last_query(); die;
		return $this->db->affected_rows();
	}
	
	
     /**
     *  function for get Data From Table
     *  param $table, $field, $whereField, $whereValue, $orderBy, $order, $limit, $offset, $resultInArray
     *  return result row
     **/
	function getDataFromTabel($table, $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0, $offset=0, $resultInArray=false, $join = '' , $extracondition = ''){
        
        $this->db->select($field);
        $this->db->from($table);

        if(is_array($whereField)){
            $this->db->where($whereField);
        }elseif(!empty($whereField) && $whereValue != ''){
            $this->db->where($whereField, $whereValue);
        }

        if(!empty($orderBy)){  
            $this->db->order_by($orderBy, $order);
        }
        if($limit > 0){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get();
        if($resultInArray){
            $result = $query->result_array();
        }else{
            $result = $query->result();
        }
		if(!empty($result)){
            return $result;
        }
        else{
            return FALSE;
        }
	}
    
    
     /**
     *  function for update data of table
     *  param $table, $data, $field, $id
     *  return result
     **/
    function updateDataFromTabel($table='', $data=array(), $field='', $id=0){
        if(empty($table) || !count($data)){
            return false;
        }
        else{
            if(is_array($field)){                 
                $this->db->where($field);
            }else{
                $this->db->where($field, $id);
                
            }
            return $this->db->update($table , $data);
        }
    }

    /*
    *
    *
    *
    */
	public function insertDataFromTable($tableName, $insertData)
	{
		$query = $this->db->insert($tableName, $insertData); 
		$id = $this->db->insert_id();
		return $id;
	}
    
    
     /*
    *  @access: public
    *  @Description: This method is use to upload picture 
    *  @auther: Gokul Rathod
    *  @return: void
    */
    
    public function uploadProfileImage($name,$dirPath,$fileName) {
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
    //         	if(($data['image_width']<'300') || ($data['image_height']<'40')) {
				//   	$this->messages->setMessageFront('The image you are attempting to upload should be greater than 350*70','error');	
				//   	return array("status" => 'error');
				// } else {
					$file_path=$dirPath.$data['file_name'];
                    
					//$file_path=$restMenuFolderName.$data['file_name'];
					$this->load->library('image_lib');
					// clear config array
					$config = array();
					$config['image_library'] 	= 'gd2';
					$config['source_image'] 	= $file_path;
					$config['maintain_ratio'] 	= TRUE;
					$config['create_thumb'] 	= FALSE;
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
    *  @access: Public
    *  @description: This method is use to change transaction fee charge
    *  @auther: harish kumar
    *  @return: void
    */
        public  function save_fees_charge($fee_type,$fees){ 
        if(!empty($fee_type) && !empty($fees)) {
          
            $this->db->where('option_name', 'charge_method');
            $this->db->update('Options' ,array('option_value'=>$fee_type));
            $this->db->where('option_name', 'charge_fee');
            $this->db->update('Options' ,array('option_value'=>$fees));
        }else{
            return false;
        }
	}
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

