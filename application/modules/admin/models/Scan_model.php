<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Scan_model extends CI_model{

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
	public function scanmeterialsajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='desc') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
        }else if(!empty($column_name) && $column_name=='mobile_no' ){
            $orderby_name = 'mobile_no';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
        }else if(!empty($column_name) && $column_name=='created' ){
            $orderby_name = 'created';
        }else {
            $orderby_name = 'created';
        }

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');
        $prefix=$this->db->dbprefix;
        $search = $this->input->get('search');
		$this->db->select('Users.firstname,Users.lastname,Users.email,Users.mobile_no,Users.current_wallet_balance,payout_scanning.*');
        $this->db->from($prefix.'Users');
        //$this->db->join($prefix.'Scan_Meterials',$prefix.'Users.id='.$prefix.'Scan_Meterials.user_id');
        $this->db->join('payout_scanning','Users.id=payout_scanning.userId');
        $this->db->where('role_id',2);

        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }
      
		//--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(CONCAT(firstname," ",lastname) LIKE "%'.$search_info.'%" OR `email` LIKE "%'.$search_info.'%" OR `mobile_no` LIKE "%'.$search_info.'%" OR `amount` LIKE "%'.$search_info.'%" OR `runningDepositNumber` LIKE "%'.$search_info.'%")',NUll);
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
