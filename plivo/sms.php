<?php

header('Access-Control-Allow-Origin: *');
//error_reporting(0);
function sms()
{
    require_once 'plivo.php';
    $auth_id = "MAZTC2YZIZZTJLMWY4MW";
    $auth_token = "MTE1NGZhZWQ2OGQ0MzliOGRmOGMzMGUyMTk5MzE2";
    
    $p = new RestAPI($auth_id, $auth_token);
   if(!empty($_POST['mobile_no']))
   {
         $dst= $_POST['mobile_no'];
         $country_code= (!empty($_POST['country_code'])) ? $_POST['country_code'] : 1;
         $message="Thank you. We will notify you with any important updates, including the link to download Dapple Pay when we launch";
          // Send a message
          if($country_code  ==1){
                $params = array(
                  'src' => '13053061487', // Sender's phone number with country code
                  'dst' => "+".$country_code.$dst, // Receiver's phone number with country code
                  'text' => $message, // Your SMS text message
                  // To send Unicode text  
                  'url' => 'http://dapplepay.com/', // The URL to which with the status of the message is sent
                  'method' => 'POST' // The method used to call the url
              );

          }else{
             $params = array(
                  'src' => '14059216935', // Sender's phone number with country code
                  'dst' => "+".$country_code.$dst, // Receiver's phone number with country code
                  'text' => $message, // Your SMS text message
                  // To send Unicode text  
                  'url' => 'http://dapplepay.com/', // The URL to which with the status of the message is sent
                  'method' => 'POST' // The method used to call the url
              );
          }
         
          // Send message
          $response = $p->send_message($params);   
        // print_r( $response['response']);die;
              if(@$response['response']['error'] =='')
              {
                    if(@$response['status']==200 || 202){
                      
                       $return = array('status'=>true,'message'=>'Mesage send successfully to your mobile number please check');
                    }
                    else{

                           $return = array('status'=>false,'message'=>'message send fail');
                      } 
              }else{
                $error_msg = @$response['response']['error'];
                 $return = array('status'=>false,'message'=>'Mobile number is invalid '.$error_msg);
              }         
     
      }else{
       $return = array('status'=>false,'message'=>'Mobile number Cannot be left blank');
     }
    echo json_encode($return);
}
sms(); // call sms function to send the sms
?>





