<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Trustly_model extends CI_model{

	function __construct(){
		parent::__construct();
  //       $this->default_db = $this->load->database('default', TRUE);
		// $this->master_db = $this->load->database('master', TRUE);
	}

	/*
    *  @access: public
    *  @Description: This method is use to get users record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
	public function trxsajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='desc') {
        if(!empty($column_name) && $column_name=='method' ){
            $orderby_name = 'method';
        }else if(!empty($column_name) && $column_name=='order_id' ){
            $orderby_name = 'order_id';
        }else if(!empty($column_name) && $column_name=='messageid' ){
            $orderby_name = 'messageid';
        }else if(!empty($column_name) && $column_name=='created_date' ){
            $orderby_name = 'created_date';
        }else {
            $orderby_name = 'created_date';
        }

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');
        $prefix=$this->db->dbprefix;
        $search = $this->input->get('search');
        $this->db->select('*');
         $this->db->group_by('order_id'); 
        $this->db->from($prefix.'Trustly_Payment_Response');
        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }  
		//--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(`method` LIKE "%'.$search_info.'%" OR `order_id` LIKE "%'.$search_info.'%" OR `messageid` LIKE "%'.$search_info.'%")',NUll);
        }
        //--------search text-box value end
        if($stop!=0) { 
           $this->db->limit($stop,$start);
        }

        $query=$this->db->get(); 
         //echo $this->db->last_query();die;
        if($isCount){
             $returnData = $query->num_rows();
        }else{
           
                $returnData = $query->result();
            
        }
        return $returnData;
    }

 
}
?>
