<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine_model extends CI_model{

	function __construct(){
		parent::__construct();	
	}
	
	
	public function machineajaxlist($isCount=false,$id,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='machine_number' ){
            $orderby_name = 'machine_number';
            $table_name=$this->db->dbprefix.'Machine_Detail';
        }else if(!empty($column_name) && $column_name=='email' ){
            $orderby_name = 'email';
            $table_name = $this->db->dbprefix.'Machine_Detail';
        }else if(!empty($column_name) && $column_name=='contact_number' ){
            $orderby_name = 'contact_number';
            $table_name = $this->db->dbprefix.'Machine_Detail';
        // }else if(!empty($column_name) && $column_name=='role_name' ){
        //     $orderby_name = 'role_name';
        //     $table_name = 'Roles';
        }else {
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Machine_Detail';
        }
        
        $roles=getActiveRole();
        //echo "<pre>"; print_r($roles);die;
        $search = $this->input->get('search');
		$this->db->select('*');
        $this->db->from($this->db->dbprefix.'Machine_Detail');
        $this->db->where('user_id',$id);
       // $this->db->join('Roles', 'Roles.id = Users.role_id');
        //$this->db->where_in('Users.role_id',$roles);
        
        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }

		//--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(person_name LIKE "%'.$search_info.'%" OR  `machine_number` LIKE "%'.$search_info.'%" OR `email` LIKE "%'.$search_info.'%" OR `contact_number` LIKE "%'.$search_info.'%")',NUll);

        }
        //--------search text-box value end
        if($stop!=0) { 
           $this->db->limit($stop,$start);
        }
        
         $query=$this->db->get(); 
        
        if($isCount){
             $returnData = $query->num_rows();
        }else{
            $returnData = $query->result();
        }
        //echo $this->db->last_query();die;
        return $returnData;
        
    }



    public function roleajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='role_name' ){
            $orderby_name = 'role_name';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            
        }

        

        
        $roles=getActiveRole();
        $search = $this->input->get('search');
        $this->db->select('*');
        $this->db->from('Roles');
        $this->db->where_in('id',$roles);

        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }
        
        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(CONCAT(firstname," ",lastname) LIKE "%'.$search_info.'%" OR `role_name` LIKE "%'.$search_info.'%" OR `mobile_no` LIKE "%'.$search_info.'%")',NUll);
        }
        //--------search text-box value end
        if($stop!=0) { 
           $this->db->limit($stop,$start);
        }
        
         $query=$this->db->get(); 
        
        if($isCount){
             $returnData = $query->num_rows();
        }else{
            $returnData = $query->result();
        }
        //echo $this->db->last_query();die;
        return $returnData;
        
    }

    public function emailExists($email){
        $this->db->select('*');
		$this->db->where('email',$email);
		//$this->db->where('role_id',5);
		$query =$this->db->get($this->db->dbprefix.'Machine_Detail');
        if($query->num_rows() > 0){
            return true;
		}else {
            return false;
		}
	}
    
}
?>
