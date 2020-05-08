<?php	
		$curl = curl_init();
		$user = $_POST['user'];
		$userid = $_POST['user_id'];
		$password = $_POST['password'];
		$serialNum = $_POST['serialNum'];
		$timeStamp = $_POST['timeStamp'];
		$soapparam = $_POST['soapparam'];
		 $UUID = $_POST['UUID'];
		$runningDepositNumber = $_POST['runningDepositNumber'];
		$amountvat = $_POST['amount'];
        
        $jsonreponse= json_decode($amountvat,true);
		//print_r($jsonreponse);die;

		$postData = file_get_contents('php://input');
		//$UUID =str_replace("}","",str_replace("{","",explode("</UUID>", explode("<UUID>",$postData)[1])[0])); ;
		
	  
	   echo "Service not avalible";die;
	  

	    $conn = new mysqli("localhost","ipant","!Pant@123#","ipant");
	        // Check connection
	        if ($conn->connect_error) {
	            die("Connection failed: " . $conn->connect_error);
	        }
		//$myfile = fopen("/var/www/html/ipant/log.txt", "a") or die("Unable to open file!");
		//$txt = '
		//++++++++++++++++++++++'.date("H:m Y-m-d").'++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//'.$postData;
		//fwrite($myfile, $txt);	
		//fclose($myfile);
	    // Creating an array for demo 
	     $listdata=[];
          if($jsonreponse){
	    	foreach ($jsonreponse as  $value){
		      $listdata[]=  '<list>
			    <vatPerc>'.$value['vatPerc'].'</vatPerc>
			    <amount>'.$value['amount'].'</amount>
			    </list>';
			    	
	    	}
	       
           $amountdata= implode(' ',$listdata);

		if(!$soapparam) { // isAlive define if soapparam is null
			if(!$postData){
				$params12='<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:c14n="http://www.w3.org/2001/10/xml-exc-c14n#" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:saml1="urn:oasis:names:tc:SAML:1.0:assertion" xmlns:saml2="urn:oasis:names:tc:SAML:2.0:assertion" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" xmlns:wsc="http://docs.oasis-open.org/ws-sx/ws-secureconversation/200512" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:ns3="http://schemas.datacontract.org/2004/07/System" xmlns:ns2="http://schemas.microsoft.com/2003/10/Serialization/" xmlns:ns1="http://www.returpack.se/WebServices/ClearingService" xmlns:ns4="http://ws.returpack.kul.sp247.net/" xmlns:ns5="http://deposit.rvm.pantgateway.returpack.com/" xmlns:ns6="http://configuration.rvm.pantgateway.returpack.com/" xmlns:ns7="http://www.envipco.com/wsdl/depositService.wsdl"><SOAP-ENV:Body><ns7:RegisterReceipt>
	<ident>
        <user>'.$user.'</user> 
        <password>'.$password.'</password>
        <serialNum>'.$serialNum.'</serialNum>
        <timeStamp>'.$timeStamp.'</timeStamp>
	</ident>
	 <UUID>{'.$UUID.'}</UUID>
	 <runningDepositNumber>'.$runningDepositNumber.'</runningDepositNumber>
	  <amount>'
		 .$amountdata.
	'</amount>

	</ns7:RegisterReceipt></SOAP-ENV:Body></SOAP-ENV:Envelope>';
	   $params='';

				
			} else {
				$params = $postData;
			}
		} else $params = $soapparam;

		
		//print_r($params);die;
		$params = str_replace('<?xml version="1.0" encoding="UTF-8"?>',"",$params);


		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://admin.ipant.se/ipant/soap/soap.php",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type:  text/xml;charset=\'utf-8\'",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
				"Content-length: ".strlen($params)
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			 // $sumAmount = 0;
	   //      foreach($jsonreponse as  $value) {            
	   //          $sumAmount += $value['amount'];
	   //      } 
		   //addTransaction($UUID,$runningDepositNumber,$sumAmount,$userid);
			//insert into register table
			 
			 

			$arr = array("request"=>$params,'response'=>$response); 
			$axm = array2xml($arr);
			print_r(str_replace('xsi:type="xsd:string"','',str_replace("</item>","",str_replace('<item xsi:type="SOAP-ENC:Struct">',"",$response))));
		   
	       

		  }
	}else{
    echo 'amount is required';

	}

	

	function array2xml($array, $xml = false){
	
	    if($xml === false){
	        $xml = new SimpleXMLElement('<result/>');
	    }
	
	    foreach($array as $key => $value){
	        if(is_array($value)){
	            array2xml($value, $xml->addChild($key));
	        } else {
	            $xml->addChild($key, $value);
	        }
	    }
	
	    return $xml->asXML();
	}
	function addTransaction($UUID,$runningDepositNumber,$amount,$userid){

       //echo $userid;die;
        // Create connection
        //$conn = new mysqli("localhost","root","yuri","payment");
        $conn = new mysqli("localhost","ipant","!Pant@123#","ipant");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if($UUID && $runningDepositNumber && $amount && $userid){
	        $sumAmount =  sprintf("%.2f",$amount/100);
	        $sessionId = str_replace("}","",str_replace("{","",$UUID));  
	        $sql = "SELECT * FROM payout_scanning WHERE sessionId='".$sessionId."'";    
	        $result = $conn->query($sql);
	        $time=time();
			$ref_num          = getuniquenumber();

		        if ($result->num_rows > 0) {
		            // output data of each row
		            while($row = $result->fetch_assoc()) {       
		                 /* Add money using Rvm machine */
		    			//Then after insert into Transactions table
		                   $payout_scanning_id =$row['payout_scanning_id'];
		                   $check_trx_details = "SELECT * FROM ipant_Transactions WHERE payout_scanning_id='".$payout_scanning_id."'";    
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
							     //$userbalancedata['current_wallet_balance'] = $total_amount;
			    			    // $updatebalancedata = $this->dynamic_model->updatedata($this->db->dbprefix.'Users', $userbalancedata, $userid);
			    			  //End of fetch amount and update in users tables
				    		     	}
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


  



?>