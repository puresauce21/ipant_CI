<?php 
	// Create connection
	//$conn = new mysqli("localhost","root","yuri","payment");
	 $conn = new mysqli("localhost","ipant","!Pant@123#","ipant");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	 $header_response=getallheaders ();
	 if(!empty($header_response && $header_response['Authorization'])){
	   $auth_token= $header_response['Authorization'];
	   //$language= $header_response['language'];

	   $user_token = json_decode(base64_decode($auth_token));
	   $user_id    =  @$user_token->userid;
	   //$auth_key   =  $user_token->token;
	    if(!empty($user_id)){

			$sessionId = str_replace("}","",str_replace("{","",$_GET['sessionId']));
			$amount = str_replace("}","",str_replace("{","",$_GET['amount']));
			
			//$Amount=(!empty($amount)) ? $amount : '0';

			$sql = "SELECT * FROM ipant_payout_scanning WHERE sessionId='".$sessionId."'";	
			$result = $conn->query($sql);

		   
		   //$amount=(!empty($_GET['amount'])) ? $_GET['amount'] : '0' ;
		 
			if ($result->num_rows > 0) {

	            //chechk scanned by other users
	            
	            $payout_scanned_by_other = "SELECT * FROM ipant_payout_scanning WHERE sessionId='".$sessionId."' AND scanned=true";	
			    $payout_scanned_by_other_result = $conn->query($payout_scanned_by_other);
			    
			    //chechk already scanned 
			    $payout_scanned = "SELECT * FROM ipant_payout_scanning WHERE sessionId='".$sessionId."' AND userId='".$user_id."' AND scanned=true";
			    $payout_scanned_result = $conn->query($payout_scanned);
	            if($payout_scanned_result->num_rows > 0) {
	                     //$res= json_encode(array("status"=>0,"error_code"=>304,"message"=>"Your QRcode Scanned is already scanned" ,'UUID'=>$sessionId));
	                      $res= json_encode(array("status"=>0,"error_code"=>304,"message"=>"Qr koden har redan skannats" ,'UUID'=>$sessionId));
					     print_r($res);
	             }elseif($payout_scanned_by_other_result->num_rows > 0){

	             	// $res= json_encode(array("status"=>0,"error_code"=>304,"message"=>"Someone already scanned this QRcode" ,'UUID'=>$sessionId));
	             	 $res= json_encode(array("status"=>0,"error_code"=>304,"message"=>"Qr koden har redan använts av en annan användare" ,'UUID'=>$sessionId));
					     print_r($res);
	             }
	             else{
					    // output data of each row
					    while($row = $result->fetch_assoc()) {	     
					        $sql = "UPDATE ipant_payout_scanning SET scanned=true, userId=".$user_id." WHERE payout_scanning_id=".$row["payout_scanning_id"];	
						    if ($conn->query($sql) === TRUE) {

						    	$amount=(!empty($row["amount"])) ? $row["amount"] : '0.00';
						    	$payout_scanning_id= $row["payout_scanning_id"] ;
							   // echo "UUID: ".$sessionId." is scanned";
						    	//add in transaction tables and update amount in our wallet
						    	$runningDepositNumber=$row["runningDepositNumber"];	
						    	$wallet_amount= addTransaction($sessionId,$runningDepositNumber,$amount,$user_id,$payout_scanning_id);
							     
							    //$res= json_encode(array("status"=>1,"error_code"=>200,"message"=>"Your QRcode Scanned successfully and transaction for ".$amount." kr is intiated","UUID"=>$sessionId,"wallet_amount"=>$wallet_amount));
							     $res= json_encode(array("status"=>1,"error_code"=>200,"message"=>"klart. ".$amount." kr finns nu i din wallet","UUID"=>$sessionId,"wallet_amount"=>number_format((float)$wallet_amount, 2, '.', '')));
							     print_r($res);
							} else {
							    //echo "Error: " . $sql . "<br>" . $conn->error;
							    $res= json_encode(array("status"=>0,"error_code"=>404,"meassage"=>"Something went wrong"));
							     print_r($res);

							}		        
					    }
			        }
			}else{
				$sql = "INSERT INTO ipant_payout_scanning (sessionId,userId,scanned,amount) VALUES ('".$sessionId."','".$user_id."', true,'0')";	
				if ($conn->query($sql) === TRUE) {
				    //echo "UUID: ".$sessionId." is scanned";
					    //add in transaction tables and update amount in our wallet
				    	$amount='7';
				    	$runningDepositNumber='';
				        $payout_scanning_id = mysqli_insert_id($conn);
				    	//$wallet_amount= addTransaction($sessionId,$runningDepositNumber,$amount,$user_id,$payout_scanning_id);


					     //$res= json_encode(array("status"=>1,"error_code"=>200,"message"=>"Your QRcode Scanned successfully ","UUID"=>$sessionId,"wallet_amount"=>'0'));
					     $res= json_encode(array("status"=>1,"error_code"=>200,"message"=>"Din QR kod har skannats","UUID"=>$sessionId,"wallet_amount"=>'0.00'));
					     print_r($res);
				    
				} else {
				      //echo "Error: " . $sql . "<br>" . $conn->error;
					    $res= json_encode(array("status"=>0,"error_code"=>404,"meassage"=>"Something went wrong"));
					     print_r($res);
				}	
			    
			}

		}else{
			$res= json_encode(array("status"=>0,"error_code"=>404,'meassge'=>'User Id is Required'));
		    print_r($res);
		}	

		}else{
			$res= json_encode(array("status"=>0,"error_code"=>401,'meassge'=>'Required Headers Are Empty'));
		    print_r($res);
		}	

	function addTransaction($UUID,$runningDepositNumber,$amount,$userid,$payout_scanning_id=''){

        // Create connection
        //$conn = new mysqli("localhost","root","yuri","payment");
        $conn = new mysqli("localhost","ipant","!Pant@123#","ipant");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if($UUID && $amount && $userid){
	        $sumAmount = $amount;
	        $sessionId = str_replace("}","",str_replace("{","",$UUID));  
	        $time=time();
			$ref_num =getuniquenumber();
            if (!empty($payout_scanning_id)){
           $check_trx_details = "SELECT * FROM ipant_Transactions WHERE to_user_id='".$userid."' AND payout_scanning_id='".$payout_scanning_id."'";    
           $final_data = $conn->query($check_trx_details);
           if($final_data->num_rows >0) {

			   }else{
			 	 $trx_sql = "INSERT INTO ipant_Transactions (tran_type_id,to_payment_method_id,amount,charge,to_user_id,from_user_id,tran_status_id,sig,amount_received,third_party_tran_id,merchant_ref_num,created_by,created_on,last_updated_by,payout_scanning_id) VALUES ('2','0','".$sumAmount."','0','".$userid."','".$userid."',6,'+','".$sumAmount."','".$ref_num."','".$ref_num."','".$userid."','".$time."','".$userid."','".$payout_scanning_id."')"; 
              $conn->query($trx_sql);

             $Transaction_id = mysqli_insert_id($conn);
			 $chargetrx = "INSERT INTO ipant_Tran_Charges (transaction_id,charge_type_id,charge_amt,created_by,last_updated_by) VALUES ('".$Transaction_id."','0','0','".$userid."','".$userid."')"; 
			 $conn->query($chargetrx);
			 //fetch amount and update in users tables
			
			 $usersql = "SELECT * FROM ipant_Users WHERE id='".$userid."'";    
			 $user_data = $conn->query($usersql);
			 if ($user_data->num_rows > 0) {
            // output data of each row
             while($row = $user_data->fetch_assoc()) {
                  $total_amount=$row['current_wallet_balance']+$sumAmount;
			       $updatedata = "UPDATE ipant_Users SET current_wallet_balance=".$total_amount." WHERE id=".$userid;
			      $conn->query($updatedata);

			       return "$total_amount";
			     //$userbalancedata['current_wallet_balance'] = $total_amount;
			    // $updatebalancedata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userbalancedata, $userid);
			  //End of fetch amount and update in users tables
    		     	}
    		    }
			 
			}               
       }
		       
	    }else{
	    	//echo "something went wrong";
	    }

    } 

    function getuniquenumber()
	{
		//////////////////GENERATE TRX #
		$a1 = date("ymd", time());
		$a2 = rand(100,999);
		$u = substr(uniqid(), 7);
		$c = chr(rand(97,122));
		$c2 = chr(rand(97,122));
		$c3 = chr(rand(97,122));
		$ok = "$c$u$c2$a2$c3";
		$txn_id = strtoupper($ok);
		return $txn_id;
		//////////////////GENERATE TRX #
	} 

 $conn->close();
	
 ?>