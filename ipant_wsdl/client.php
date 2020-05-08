<?php 

require_once __DIR__ . '/vendor/autoload.php';
//require_once __DIR__ . '/server.php';

$client = new Zend\Soap\Client('http://admin.ipant.se/ipant_wsdl/server.php?wsdl');
$result = $client->sayHello(['firstName' => 'Worldggtgtgg']);
echo $result->sayHelloResult;





/*$client = new Zend\Soap\Client('http://localhost/ipant_wsdl/wsdl/depositService.wsdl');
#$result = $client->IsAlive(['user' => 'World','password' => 'World','serialNum' => 'World','timeStamp' => 'World']);

$result = $client->GetProvidersRequest(['ident' => 'dffd']);
#$result2 = $client->GetProvidersRequest(2, 'some string');
echo $result->GetProvidersResponse;*/
