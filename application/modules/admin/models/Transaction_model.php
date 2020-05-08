<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Transaction_model extends CI_model{

	function __construct(){
		parent::__construct();	
	}
	
	
    /*
    *  @access: public
    *  @Description: This method is use to get transaction record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
	public function transactionajaxlist($isCount=false,$userId='',$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name=$this->db->dbprefix.'Users';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='charge' ){
            $orderby_name = 'charge';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='tran_name' ){
            $orderby_name = 'tran_name';
            $table_name = $this->db->dbprefix.'Tran_Types';
        }else if(!empty($column_name) && $column_name=='msg' ){
            $orderby_name = 'msg';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='third_party_tran_id' ){
            $orderby_name = 'third_party_tran_id';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='role_name'){
            $orderby_name = 'role_name';
            $table_name = $this->db->dbprefix.'Roles';
        }else {
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Transactions';
        }

        // echo $column_name;echo "<br>";die();
        // echo $orderby_name;echo "<br>";
        // echo $table_name;die();

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');
        
        $search = $this->input->get('search');
		$this->db->select(
                $this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,u2.firstname as from_firstname,u2.lastname as from_lastname,
                '.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, 
                '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,
                '.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card,
                UPM.user_id as sender_uId, UPM.is_bank as sender_bank,UPM.is_debit_card as sender_d_card,UPM.is_credit_card as sender_c_dard');

        //u2.firstname as to_firstname,u2.lastname as to_lastname
        //$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        //$this->db->join('Users', 'Users.id = Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'Users as u2', 'u2.id = '.$this->db->dbprefix.'Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods as UPM', 'UPM.id = '.$this->db->dbprefix.'Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = '.$this->db->dbprefix.'Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        //$this->db->where('Transactions.tran_type_id',2); 



        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        */
        if(!empty($userId)){
           $this->db->where($this->db->dbprefix.'Users.id',$userId);
        }
        

        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        // else{
        //     $this->db->order_by('Transactions.id', 'desc');
        // }

        if(!empty($postdata['search_date'])){
            $search_date = $postdata['search_date']; 
            $from_arr = explode('/', $search_date);
            $to_arr = explode(' - ', $from_arr[2]);
            $start_date = $to_arr[0].'-'.$from_arr[0].'-'.$from_arr[1];
            $end_date = $from_arr[4].'-'.$to_arr[1].'-'.$from_arr[3];
            $this->db->where('cast('.$this->db->dbprefix.'Transactions.creation_date_time AS DATE) BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        }
        
		//--------search text-box value start
        if(!empty($search['value'])){
            $search_info = trim($search['value']);

             $this->db->where('(CONCAT('.$this->db->dbprefix.'Users.firstname," ",'.$this->db->dbprefix.'Users.lastname) LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.amount LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.charge LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Tran_Types.tran_name LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.msg LIKE "%'.$search_info.'%" )',NUll);
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

        /*
    *  @access: public
    *  @Description: This method is use to get transaction record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
    public function donationajaxlist($isCount=false,$userId='',$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name=$this->db->dbprefix.'Users';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='tran_name' ){
            $orderby_name = 'tran_name';
            $table_name = $this->db->dbprefix.'Tran_Types';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='third_party_tran_id' ){
            $orderby_name = 'third_party_tran_id';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='tran_name'){
            $orderby_name = 'tran_name';
            $table_name = $this->db->dbprefix.'Transactions';
        }else{
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Transactions';
        }

        // echo $column_name;echo "<br>";die();
        // echo $orderby_name;echo "<br>";
        // echo $table_name;die();

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');
        
        $search = $this->input->get('search');
        $this->db->select(
                $this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,u2.firstname as from_firstname,u2.lastname as from_lastname,
                '.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, 
                '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,
                '.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card,
                UPM.user_id as sender_uId, UPM.is_bank as sender_bank,UPM.is_debit_card as sender_d_card,UPM.is_credit_card as sender_c_dard');

        //u2.firstname as to_firstname,u2.lastname as to_lastname
        //$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        //$this->db->join('Users', 'Users.id = Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'Users as u2', 'u2.id = '.$this->db->dbprefix.'Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods as UPM', 'UPM.id = '.$this->db->dbprefix.'Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = '.$this->db->dbprefix.'Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        //$this->db->where('Transactions.tran_type_id',2); 



        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        */
        if(!empty($userId)){
           $this->db->where($this->db->dbprefix.'Users.id',$userId);
        }
        
        $this->db->where($this->db->dbprefix.'Transactions.tran_type_id',5);
        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        // else{
        //     $this->db->order_by('Transactions.id', 'desc');
        // }

        if(!empty($postdata['search_date'])){
            $search_date = $postdata['search_date']; 
            $from_arr = explode('/', $search_date);
            $to_arr = explode(' - ', $from_arr[2]);
            $start_date = $to_arr[0].'-'.$from_arr[0].'-'.$from_arr[1];
            $end_date = $from_arr[4].'-'.$to_arr[1].'-'.$from_arr[3];
            $this->db->where('cast('.$this->db->dbprefix.'Transactions.creation_date_time AS DATE) BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        }
        
        //--------search text-box value start
        if(!empty($search['value'])){
            $search_info = trim($search['value']);

             $this->db->where('(CONCAT('.$this->db->dbprefix.'Users.firstname," ",'.$this->db->dbprefix.'Users.lastname) LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.amount LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.charge LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Tran_Types.tran_name LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.msg LIKE "%'.$search_info.'%" )',NUll);
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
    public function transactionCsvlist($userId=''){

        $order='desc';
        $orderby_name = 'id';
        $table_name = $this->db->dbprefix.'Transactions';

        // echo $column_name;echo "<br>";die();
        // echo $orderby_name;echo "<br>";
        // echo $table_name;die();

        //------post data for search filter
        $postdata = $this->session->userdata('postdata');

        $this->db->select(
                $this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,u2.firstname as from_firstname,u2.lastname as from_lastname,
                '.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, 
                '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,
                '.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card,
                UPM.user_id as sender_uId, UPM.is_bank as sender_bank,UPM.is_debit_card as sender_d_card,UPM.is_credit_card as sender_c_dard');

        //u2.firstname as to_firstname,u2.lastname as to_lastname
        //$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        //$this->db->join('Users', 'Users.id = Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'Users as u2', 'u2.id = '.$this->db->dbprefix.'Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods as UPM', 'UPM.id = '.$this->db->dbprefix.'Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = '.$this->db->dbprefix.'Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        //$this->db->where('Transactions.tran_type_id',2); 

        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        */
        if(!empty($userId)){
           $this->db->where($this->db->dbprefix.'Users.id',$userId);
        }

        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        // else{
        //     $this->db->order_by('Transactions.id', 'desc');
        // }

        //--------search text-box value end
        // if($stop!=0) { 
        //    $this->db->limit($stop,$start);
        // }

        if(!empty($postdata['search_date'])){
            $search_date = $postdata['search_date']; 
            $from_arr = explode('/', $search_date);
            $to_arr = explode(' - ', $from_arr[2]);
            $start_date = $to_arr[0].'-'.$from_arr[0].'-'.$from_arr[1];
            $end_date = $from_arr[4].'-'.$to_arr[1].'-'.$from_arr[3];
            $this->db->where('cast('.$this->db->dbprefix.'Transactions.creation_date_time AS DATE) BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
        }

        $query=$this->db->get();
        $returnData = $query->result();
        //echo $this->db->last_query();die;
        return $returnData;
    }



    /*
    *  @access: public
    *  @Description: This method is use to get withdraw record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
    public function withdrawajaxlist($isCount=false,$userId='',$start=0,$stop=0, $column_name='',$order='desc') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name=$this->db->dbprefix.'Users';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='charge' ){
            $orderby_name = 'charge';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='tran_name' ){
            $orderby_name = 'tran_name';
            $table_name = $this->db->dbprefix.'Tran_Types';
        }else if(!empty($column_name) && $column_name=='msg' ){
            $orderby_name = 'msg';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            $table_name = $this->db->dbprefix.'Transactions';
        }else {
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Transactions';
        }
        
        $search = $this->input->get('search');
        

        $this->db->select($this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,'.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,'.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        //$this->db->join('User_Payment_Methods as UPM', 'UPM.id = Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = '.$this->db->dbprefix.'Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        $this->db->where($this->db->dbprefix.'Transactions.tran_type_id',1); 

        if(!empty($userId)){
           $this->db->where($this->db->dbprefix.'Transactions.to_user_id',$userId);
        }


        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Roles', 'Roles.id = Users.role_id');
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        $this->db->where('Transactions.tran_type_id',1); 

*/

        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        
        //--------search text-box value start
        // if(!empty($search['value'])){
        //     $search_info = trim($search['value']);
        //      //$this->db->where('(CONCAT(Users.firstname,' ',Users.lastname) LIKE "%'.$search_info.'%")',NUll);

        //      $this->db->where('(CONCAT(Users.firstname," ",Users.lastname) LIKE "%'.$search_info.'%" OR  `Transactions.amount` LIKE "%'.$search_info.'%" OR `Transactions.charge` LIKE "%'.$search_info.'%" OR `Tran_Types.tran_name` LIKE "%'.$search_info.'%" OR `Transactions.msg` LIKE "%'.$search_info.'%" )',NUll);
        //         //$fcondition.= "AND CONCAT(admin.firstname,'',admin.lastname) LIKE '%".$name."%'";

        //     //$this->db->where('(`Users.firstname` LIKE "%'.$search_info.'%" OR `Users.lastname` LIKE "%'.$search_info.'%" OR  `Transactions.amount` LIKE "%'.$search_info.'%" OR `Transactions.charge` LIKE "%'.$search_info.'%" OR `Tran_Types.tran_name` LIKE "%'.$search_info.'%" OR `Transactions.msg` LIKE "%'.$search_info.'%" )',NUll);
        // }

        if(!empty($search['value'])){
            $search_info = trim($search['value']);

             $this->db->where('(CONCAT('.$this->db->dbprefix.'Users.firstname," ",'.$this->db->dbprefix.'Users.lastname) LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.amount LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.charge LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Tran_Types.tran_name LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.msg LIKE "%'.$search_info.'%" )',NUll);
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



    /*
    *  @access: public
    *  @Description: This method is use to get deposite money record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
    public function depositHistoryajaxlist($isCount=false,$userId='',$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name=$this->db->dbprefix.'Users';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='charge' ){
            $orderby_name = 'charge';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='third_party_tran_id' ){
            $orderby_name = 'third_party_tran_id';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='msg' ){
            $orderby_name = 'msg';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            $table_name = $this->db->dbprefix.'Transactions';
        }else {
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Transactions';
        }

        $search = $this->input->get('search');
        
        $this->db->select($this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,u2.firstname as from_firstname,u2.lastname as from_lastname,'.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,'.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card,UPM.user_id as sender_uId, UPM.is_bank as sender_bank,UPM.is_debit_card as sender_d_card,UPM.is_credit_card as sender_c_dard');

        //u2.firstname as to_firstname,u2.lastname as to_lastname
        //$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        //$this->db->join('Users', 'Users.id = Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'Users as u2', 'u2.id = '.$this->db->dbprefix.'Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods as UPM', 'UPM.id = '.$this->db->dbprefix.'Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        $this->db->where($this->db->dbprefix.'Transactions.tran_type_id',2); 
        if(!empty($userId)){
           $this->db->where($this->db->dbprefix.'Transactions.to_user_id',$userId);
        }
        


        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        $this->db->where('Transactions.tran_type_id',2); */
        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        
        //--------search text-box value start
        // if(!empty($search['value'])){
        //     $search_info = trim($search['value']);
        //     $this->db->where('(CONCAT(Users.firstname," ",Users.lastname) LIKE "%'.$search_info.'%"  OR  `Transactions.amount` LIKE "%'.$search_info.'%" OR `Transactions.charge` LIKE "%'.$search_info.'%" OR `Tran_Types.tran_name` LIKE "%'.$search_info.'%" OR `Transactions.msg` LIKE "%'.$search_info.'%" )',NUll);
        // }
        if(!empty($search['value'])){
            $search_info = trim($search['value']);

             $this->db->where('(CONCAT('.$this->db->dbprefix.'Users.firstname," ",'.$this->db->dbprefix.'Users.lastname) LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.amount LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.charge LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Tran_Types.tran_name LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.msg LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.third_party_tran_id LIKE "%'.$search_info.'%" )',NUll);
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


    /*
    *  @access: public
    *  @Description: This method is use to get send money record 
    *  @auther: Gokul Rathod
    *  @return: json
    */
    public function sendMoneyajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='desc') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name=$this->db->dbprefix.'Users';
        }else if(!empty($column_name) && $column_name=='amount' ){
            $orderby_name = 'amount';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='charge' ){
            $orderby_name = 'charge';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='tran_name' ){
            $orderby_name = 'tran_name';
            $table_name = $this->db->dbprefix.'Tran_Types';
        }else if(!empty($column_name) && $column_name=='msg' ){
            $orderby_name = 'msg';
            $table_name = $this->db->dbprefix.'Transactions';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
            $table_name = $this->db->dbprefix.'Transactions';
        }else {
            $order='desc';
            $orderby_name = 'id';
            $table_name = $this->db->dbprefix.'Transactions';
        }
        
        $search = $this->input->get('search');
        
        $this->db->select($this->db->dbprefix.'Transactions.*, '.$this->db->dbprefix.'Users.firstname,'.$this->db->dbprefix.'Users.lastname,u2.firstname as from_firstname,u2.lastname as from_lastname,'.$this->db->dbprefix.'Tran_Types.tran_name, '.$this->db->dbprefix.'Roles.role_name, '.$this->db->dbprefix.'User_Payment_Methods.user_id,'.$this->db->dbprefix.'User_Payment_Methods.is_bank,'.$this->db->dbprefix.'User_Payment_Methods.is_debit_card,'.$this->db->dbprefix.'User_Payment_Methods.is_credit_card,UPM.user_id as sender_uId, UPM.is_bank as sender_bank,UPM.is_debit_card as sender_d_card,UPM.is_credit_card as sender_c_dard');

        //u2.firstname as to_firstname,u2.lastname as to_lastname
        //$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name, Roles.role_name');
        $this->db->from($this->db->dbprefix.'Transactions');
        $this->db->join($this->db->dbprefix.'Users', 'Users.id = '.$this->db->dbprefix.'Transactions.to_user_id', 'left' );
        //$this->db->join('Users', 'Users.id = Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'Users as u2', 'u2.id = '.$this->db->dbprefix.'Transactions.from_user_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods', 'User_Payment_Methods.id = '.$this->db->dbprefix.'Transactions.to_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'User_Payment_Methods as UPM', 'UPM.id = '.$this->db->dbprefix.'Transactions.from_payment_method_id', 'left' );
        $this->db->join($this->db->dbprefix.'Roles', 'Roles.id = '.$this->db->dbprefix.'Users.role_id');
        $this->db->join($this->db->dbprefix.'Tran_Types', 'Tran_Types.id = '.$this->db->dbprefix.'Transactions.tran_type_id', 'left' );
        $this->db->where($this->db->dbprefix.'Transactions.tran_type_id',3);


        /*$this->db->select('Transactions.*, Users.firstname,Users.lastname,Tran_Types.tran_name');
        $this->db->from('Transactions');
        $this->db->join('Users', 'Users.id = Transactions.to_user_id', 'left' );
        $this->db->join('Tran_Types', 'Tran_Types.id = Transactions.tran_type_id', 'left' );
        $this->db->where('Transactions.tran_type_id',3); */
        
        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        
        //--------search text-box value start
        // if(!empty($search['value'])){
        //     $search_info = trim($search['value']);
        //     $this->db->where('(CONCAT(Users.firstname," ",Users.lastname) LIKE "%'.$search_info.'%" OR  `Transactions.amount` LIKE "%'.$search_info.'%" OR `Transactions.charge` LIKE "%'.$search_info.'%" OR `Tran_Types.tran_name` LIKE "%'.$search_info.'%" OR `Transactions.msg` LIKE "%'.$search_info.'%" )',NUll);
        // }
        if(!empty($search['value'])){
            $search_info = trim($search['value']);

             $this->db->where('(CONCAT('.$this->db->dbprefix.'Users.firstname," ",'.$this->db->dbprefix.'Users.lastname) LIKE "%'.$search_info.'%" OR  '.$this->db->dbprefix.'Transactions.amount LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.charge LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Tran_Types.tran_name LIKE "%'.$search_info.'%" OR '.$this->db->dbprefix.'Transactions.msg LIKE "%'.$search_info.'%" )',NUll);
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

    public function qrcodeajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
        }else if(!empty($column_name) && $column_name=='mobile_no' ){
            $orderby_name = 'mobile_no';
        }else if(!empty($column_name) && $column_name=='creation_date_time' ){
            $orderby_name = 'creation_date_time';
        }else{
            $order='desc';
            $orderby_name = 'id';
        }
        
        $search = $this->input->get('search');

        $this->db->select('Users.*, Roles.role_name');
        $this->db->from('Users');
        $this->db->join('Roles', 'Roles.id = Users.role_id');
        
        $this->db->where('Users.id!=',1);
        if(!empty($orderby_name)){
           $this->db->order_by('Users.'.$orderby_name, $order);
        }
         
        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(CONCAT(Users.firstname," ",Users.lastname) LIKE "%'.$search_info.'%" OR `Users.mobile_no` LIKE "%'.$search_info.'%")',NUll);
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
