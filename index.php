<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

// Client ID should be an encrypted string that looks similar to this: OXYyM2h2ajIzMWNmdHIyMGJ2dGozNDB2MzRqYnQzNDB0djFuajR2MDEyMzRiMDVqYjVqdnQwMzE0dGJ2ajR5NTB5bj=
$client_id = "YourClientIDHere";
$headers = array('Accept: application/json', 'Authorization: Basic '.rawurlencode($client_id)); 
$param = array('first_name'=>'UserFName','last_name'=>'UserLName','email'=>'UserEmail','password'=>'UserPwd'); 
$url = 'https://capi-eval.signnow.com/api/user'; 

$handle = curl_init(); 
curl_setopt($handle, CURLOPT_URL, $url); 
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers); 
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($handle, CURLOPT_SSLVERSION, 3);
curl_setopt($handle, CURLOPT_POST, true); 
curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($param));
$response = curl_exec($handle); 

var_dump($response);