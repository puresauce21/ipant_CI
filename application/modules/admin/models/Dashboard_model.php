<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_model{

	function __construct(){
		parent::__construct();	
	}
	
	
	//public function withdrawCharge() {
        //$query=$this->db->get(); 
        // if($isCount){
        //      $returnData = $query->num_rows();
        // }else{
        //     $returnData = $query->result();
        // }
        // //echo $this->db->last_query();die;
        // return $returnData;
    //}
    // $this->db->select_sum('amount');

    // total Deposit amount
    public function getTransMethodAmt($tranType=''){
        if(!empty($tranType)){
            $this->db->select('sum(amount) as totalAmount');
            $this->db->from($this->db->dbprefix.'Transactions');        
            $this->db->where('tran_type_id',$tranType); 
            $query=$this->db->get(); 
            return $query->row();       
        }else{
            return false;
        }
    }



    public function getTransChargeAmt(){
        $this->db->select('sum(charge) as totalCharge');
        $this->db->from($this->db->dbprefix.'Transactions');        
        $query=$this->db->get(); 
        return $query->row();       
    }
}
?>
