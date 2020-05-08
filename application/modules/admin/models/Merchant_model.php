<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Merchant_model extends CI_model{

	function __construct(){
		parent::__construct();	
		
	}
	
	
	public function marchantajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
        }else if(!empty($column_name) && $column_name=='email' ){
            $orderby_name = 'email';
        }else if(!empty($column_name) && $column_name=='mobile_no' ){
            $orderby_name = 'mobile_no';
        }else if(!empty($column_name) && $column_name=='current_wallet_balance' ){
            $orderby_name = 'current_wallet_balance';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
        }else {
            $order='desc';
            $orderby_name = 'id';
        }
        
        //------post data for search filter
        $postdata = $this->session->userdata('postdata');
        
        $search = $this->input->get('search');
		$this->db->select('*');
        $this->db->from('Users');
        //$this->db->where('role_id',3);

        $where = '(role_id="3" or is_merchant = "1")';
        $this->db->where($where);

        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }
         //--------search filter drop-down and calander condition  start
        if(!empty($postdata['user_status'])){
            if($postdata['user_status']==2){
                $postdata['user_status']=0;
            }else if($postdata['user_status']==3){
                $postdata['user_status']=2;
            }
            $this->db->where('status',$postdata['user_status']);
        }
        
        if(!empty($postdata['search_date'])){
            $search_date = $postdata['search_date']; 
            $from_arr = explode('/', $search_date);
            $to_arr = explode(' - ', $from_arr[2]);
            $start_date = $to_arr[0].'-'.$from_arr[0].'-'.$from_arr[1];
            $end_date = $from_arr[4].'-'.$to_arr[1].'-'.$from_arr[3];
            $this->db->where('creation_date_time BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        }
		//--------search filter drop-down and calander condition end
        
		//--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(CONCAT(firstname," ",lastname) LIKE "%'.$search_info.'%" OR `email` LIKE "%'.$search_info.'%" OR `mobile_no` LIKE "%'.$search_info.'%")',NUll);
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

}
?>
