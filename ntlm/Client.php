<?php 

require_once("NTLMStream.php");

require_once("NTLMSoapClient.php");

stream_wrapper_unregister('http');

stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

//öRNEK SOAP URL
//SAMPLE SOAP URL
//http://192.1.1.1:1010/DynamicsNAV100/WS/SASTARSOFT%20NAV2018/Page/ITEMS

// Initialize Soap Client 
$baseURL = 'http://192.1.1.1:1010/DynamicsNAV100/WS/';  //Microsoft Dynamics tarafında oluşturduğumuz Soap Urli parçalayarak birden fazla url kullanabiriz.
                                                        //We can use more than one url by breaking the Soap Url we created by Microsoft Dynamics.

$cur='SASTARSOFT NAV2018'; // Soap Url üzerinde hangi firma için olduğunu yazıyoruz.
                            // We write which company it is for on the Soap Url.

?>