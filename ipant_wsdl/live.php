<?php

$postData = file_get_contents('php://input');
		$soapclient = new SoapClient("http://admin.ipant.se/ipant/depositService.wsdl");
		
		$user = $_POST['user'];
		$password = $_POST['password'];
		$serialNum = $_POST['serialNum'];
		$timeStamp = $_POST['timeStamp'];
		
		$param = array('user'=>$user,'password'=>$password,'serialNum'=>$serialNum,'timeStamp'=>$timeStamp);
		//$getresponse = $soapclient->IsAlive($param);
		//print_r($getresponse); die;
		$arr = array("request"=>$param,'response'=>$getresponse);
		$axm = array2xml($arr);
		print_r($postData);


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



?>