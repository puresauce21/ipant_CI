<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Setting_model extends CI_model{

	function __construct(){
		parent::__construct();	
		
	}
	
    
    
    public function tutorialSplashAjaxlist($isCount=false, $type='', $start = 0,$stop = 0, $column_name='',$order='') {
    	if(!empty($column_name) && $column_name=='title' ){
            $orderby_name = 'title';
        }else if(!empty($column_name) && $column_name=='content' ){
            $orderby_name = 'content';
        }


	    $search = $this->input->get('search');
	    $this->db->select('*');
	    $this->db->where('type', $type);
	    $this->db->from('Tutorial_Splash');
	    
	    if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }

	    // search condition
	    if(!empty($search['value'])){
	        $search_value = trim($search['value']);
	        $this->db->where('(`Tutorial_Splash.title` LIKE "%'.$search_value.'%" OR `content` LIKE "%'.$search_value.'%" )',NUll);
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
    
    

    public function requestajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='firstname' ){
            $orderby_name = 'firstname';
            $table_name='Users';
        }else if(!empty($column_name) && $column_name=='phone_no' ){
            $orderby_name = 'phone_no';
            $table_name = 'Request_Call';
        }else if(!empty($column_name) && $column_name=='email' ){
            $orderby_name = 'email';
            $table_name = 'Request_Call';
        }
        
        //------post data for search filter  
        $postdata = $this->session->userdata('postdata');
        
        $search = $this->input->get('search');
        $this->db->select('Request_Call.*, Users.firstname, Users.lastname');
        $this->db->from('Request_Call');
        $this->db->join('Users','Request_Call.user_id = Users.id');

        if(!empty($orderby_name)){
           $this->db->order_by($table_name.".".$orderby_name, $order);
        }
        
        //--------search filter drop-down and calander condition  start
        if(!empty($postdata['user_status'])){
            if($postdata['user_status']==2){
               $postdata['user_status']=0;
            }
            $this->db->where('status',$postdata['user_status']);
        }
        //--------search filter drop-down and calander condition end
       

        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(CONCAT(Users.firstname," ",Users.lastname) LIKE "%'.$search_info.'%" OR  `Request_Call.phone_no` LIKE "%'.$search_info.'%" OR `Request_Call.email` LIKE "%'.$search_info.'%")',NUll);
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
    *  @access: Public
    *  @description: This method is use to get user data
    *  @auther: Gokul rathod
    *  @return: void 
    */
    
     function getuserdata($userId=''){
        if(!empty($userId)){  
            $this->db->select('*');
            $this->db->where('id',$userId);
            //$this->db->where('status','1');
            $query = $this->db->get('Users');
            if($query->row())
                return $query->row();
            else
                return false;
                
        }else{
            return false;
        }   
    }
    

    /*
    *  @access: Public
    *  @description: This method is use to change password for admin
    *  @auther: Gokul rathod
    *  @return: void
    */
    
    public  function change_password($userId,$newPass){ 
         if(!empty($userId)) {
             $data=array('password'=>$newPass);
             $this->db->where('id', $userId);
            return $this->db->update('Users' ,$data);
        }else{
            return false;
        }
    }

    public function faqajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='category_name' ){
            $orderby_name = 'category_name';
        }else if(!empty($column_name) && $column_name=='question' ){
            $orderby_name = 'question';
        }else if(!empty($column_name) && $column_name=='answer' ){
            $orderby_name = 'answer';
        }
        
        
        $search = $this->input->get('search');

        $this->db->select('Faq.*, Category.category_name');
        $this->db->from('Faq');
        $this->db->join('Category','Category.id = Faq.category_id');
        
        $this->db->where('type','Faq');
        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }
        
        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(`category_name` LIKE "%'.$search_info.'%" OR `question` LIKE "%'.$search_info.'%" OR `answer` LIKE "%'.$search_info.'%")',NUll);
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


     public function virtualFaqajaxlist($isCount=false,$start=0,$stop=0, $column_name='',$order='') {
        if(!empty($column_name) && $column_name=='question' ){
            $orderby_name = 'question';
        }else if(!empty($column_name) && $column_name=='answer' ){
            $orderby_name = 'answer';
        }
        
        
        $search = $this->input->get('search');

        $this->db->select('*');
        $this->db->from('Faq');
        //$this->db->join('Category','Category.id = Faq.category_id');
        
        $this->db->where('type','Virtual');
        if(!empty($orderby_name)){
           $this->db->order_by($orderby_name, $order);
        }
        
        //--------search text-box value start
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(`question` LIKE "%'.$search_info.'%" OR `answer` LIKE "%'.$search_info.'%")',NUll);
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

     //-------------------------------------------------------------------------
    /*
    *  @access: public
    *  @Description: This method is use to get email template record 
    *  @modified by: gokul rathod
    *  @return: json
    */
    
    public function emailajaxlist($isCount=false,$start=0,$stop=0) {
        $search = $this->input->get('search');
        
        $this->db->select('*');
        $this->db->from('email_template');
        $this->db->order_by('id','DESC');
        
        if(!empty($search['value'])){
           $search_info = trim($search['value']);
           $this->db->where('(`masterSubject` LIKE "%'.$search_info.'%" OR `masterContent` LIKE "%'.$search_info.'%" )',NUll);
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
        
        return $returnData;
        
    }
    
}
?>
