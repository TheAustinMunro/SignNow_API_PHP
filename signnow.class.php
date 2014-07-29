<?php
class SignNow {
	public $clientID;
	public $clientToken;
	public function __construct() {
		$this->clientID    = ;// Your client id goes here.
		// On class invocation grab a new client token.
		$this->clientToken = $this->getOAuthToken();
	}
	// For creating a user. 
	public function createUser ($email, $password, $firstName="", $lastName="") {
		$url        = "https://capi-eval.signnow.com/api/user"; 
		$header     = array("Accept: application/json", "Authorization: Basic ".$this->clientID);
		$parameters = json_encode(array("email"=>$email,"password"=>$password));
		if (isset($firstName) && !empty($firstName)) { $tempArray["first_name"] = $firstName; }
		if (isset($lastName)  && !empty($lastName))  { $tempArray["last_name"]  = $lastName; }
		return self::makeCurlRequest ($url, $header, $parameters);
	}
	// For getting an OAuthToken for main user.
	public function getOAuthToken () {
		$url        = "https://capi-eval.signnow.com/api/oauth2/token";
		$header     = array("Accept: application/json", "Authorization: Basic ".$this->clientID);
		$parameters = "username=email@example.com&password=yourpassword&grant_type=password";
		// Example parameters would look like "username=email@example.com&password=yourpassword&grant_type=password"
		return json_decode(self::makeCurlRequest ($url, $header, $parameters))->access_token;
	}
	// For getting history of a document.
	public function getDocumentHistory ($document) {
		$url        = "https://capi-eval.signnow.com/api/document/".$document."/history";
		$header     = array("Accept: application/json", "Authorization: Bearer ".$this->clientToken);
		return self::makeCurlRequest ($url, $header, "", false);
	}
	// For inviting a user to sign a document.
	public function inviteUserToSignDocument ($document, $email) {
		$url        = "https://capi-eval.signnow.com/api/document/".$document."/invite?email=enable";
		$header     = array("Accept: application/json", "Authorization: Bearer ".$this->clientToken);
		$parameters = json_encode(array("from"=>"email@example.com","to"=>$email));
		return self::makeCurlRequest ($url, $header, $parameters);
	}
	// For uploading a document.
	public function uploadDocument ($file) {
		$url        = "https://capi-eval.signnow.com/api/document";
		$header     = array("Accept: application/json", "Authorization: Bearer ".$this->clientToken);
		$parameters = array("file"=>"@".realpath($file));
		$response   = json_decode(self::makeCurlRequest ($url, $header, $parameters));
		return $response->id;
	}
	// To make a curl request to the sign now api.
	public static function makeCurlRequest ($url, $header="", $parameters="", $post=true) {
		$handle = curl_init(); 
		curl_setopt($handle, CURLOPT_URL, $url); 
		if(isset($header) && !empty($header)) { curl_setopt($handle, CURLOPT_HTTPHEADER, $header); }
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($handle, CURLOPT_SSLVERSION, 3);
		if($post) { curl_setopt($handle, CURLOPT_POST, true); }
		if(isset($parameters) && !empty($parameters)) { curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters); }
		$response = curl_exec($handle); 
		return $response;
	}
}