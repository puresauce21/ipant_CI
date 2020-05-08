<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_model extends CI_model{

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
	public function userajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
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


        // echo $order;echo "<br>";
        // echo $orderby_name;echo "<br>";die();

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');

        $search = $this->input->get('search');
		$this->db->select('*');
        $this->db->from($this->db->dbprefix.'Users');
        $this->db->where('Role_id',2);


            // $this->db->select('"'.$this->default_db.'".Users.*,"'.$this->master_db.'".sm_users.id as masterTblId');
            // $this->db->from('"'.$this->default_db.'".Users');
            // $this->db->join('"'.$this->master_db.'".sm_users', '"'.$this->master_db.'".sm_users.user_id = "'.$this->default_db.'".Users.id' );

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
           $this->db->where('(CONCAT(firstname," ",lastname) LIKE "%'.$search_info.'%" OR `email` LIKE "%'.$search_info.'%" OR `mobile_no` LIKE "%'.$search_info.'%" OR `current_wallet_balance` LIKE "%'.$search_info.'%")',NUll);
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
        // echo $this->db->last_query();die;
        return $returnData;
    }

    /*
    *  @access: public
    *  @Description: This method is use to get menu info 
    *  @Author: Gokul Rathod
    *  @return: void
    */
    
    //$userDetails =  $this->Common_model->getDataFromTabel('Users', '*', array('id'=> decode($id), 'role_id'=>2));

    public function getUserinfo($userId=''){
        if(!empty($userId)){
            $this->db->select('Users.*, Countries.name as country_name'); 
            $this->db->join($this->db->dbprefix.'Countries','Countries.code = Users.country_code','LEFT');
            $this->db->from($this->db->dbprefix.'Users');
            $this->db->where('Users.id',$userId);
            $this->db->where('Users.role_id',2);
            $query =$this->db->get();
            $result = $query->row();
            return $result;
        }else{
            return false;
        }
    }

    public function transAmount($userId='') {
        if(!empty($userId)){
            $this->db->select('SUM(amount) AS amount');
            $this->db->from($this->db->dbprefix.'Transactions');
            $this->db->where('to_user_id',$userId);

            $query=$this->db->get(); 
            //echo $this->db->last_query();die;
            return $query->result();
        }else{
            return false;
        }
    }

    public function tutorialSplashAjaxlist($isCount=false, $start = 0,$stop = 0) {

        $search = $this->input->get('search');
        $this->db->select('*');
        // $this->db->where('User_In_Roles.Role_Id =',3);
        $this->db->from('Tutorial_Splash');
        $this->db->order_by('id', 'DESC');

       //      // search condition
        if(!empty($search['value'])){
             $search_value = trim($search['value']);
             $this->db->where('(`Tutorial_Splash.content` LIKE "%'.$search_value.'%" )',NUll);
         }
            if($stop!=0) { 
               $this->db->limit($stop,$start);
            }
             $query=$this->db->get(); 
            if($isCount){
                 $returnData = $query->num_rows();
            }else{
                $returnData = $query->result();
            }
            //echo $this->db->last_query();
            return $returnData;
    }

    public function staticTempajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        /*if(!empty($column_name) && $column_name=='category_name' ){
            $orderby_name = 'category_name';
        }else if(!empty($column_name) && $column_name=='category_type' ){
            $orderby_name = 'category_type';
        }else if(!empty($column_name) && $column_name=='category_description' ){
            $orderby_name = 'category_description';
        }
        */

        $search = $this->input->get('search');
        $this->db->select('*');
        $this->db->from('static_template');
        //$this->db->where('Role_id',2);
        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }

        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(`category_name` LIKE "%'.$search_info.'%" OR `category_type` LIKE "%'.$search_info.'%" OR `category_description` LIKE "%'.$search_info.'%")',NUll);
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
