<?php

class AndroidNotification
{

    private $db;

    function __autoload($class_name)
    {
        include_once $class_name . '.php';
    }

    function __construct()
    {
        $this->db = new db();
        $this->db->connect();
    }

    function __destruct()
    {
        unset($this->db);
    }
	
	function sendAllAPN($userID, $friendID, $msg){
	    //array de tokens do user
		//$arr = getUserDevices($friendID);
		$arr = 'b9554a031a80787b80539fe955afef10adb0f76ee392c58c4b126e7c1b718958';
		
		//$fullname = getFullName($userID);
		$fullname = 'testing';
		
		//$num_req = getUserRequests($friendID);
		$num_req = 1;
		
		$msg = 'blablabla';
		
		//for ($i = 0; $i < sizeof($arr); $i++) {
			sendAPN($fullname, $num_req, $arr, $msg);
			setLog($userID, 'FRIEND_REQ', 'INFO: UserID - '.$userID.' - FriendID - '.$friendID.' - DEVICE - '.$arr[$i].' - MSG - '.$fullname.' '.$msg);
		//}
	}

	function sendAPN($fullname, $num_req, $deviceToken, $msg){
		
		//echo 'INSOIDE SEND APN'.$fullname;
		//$fullname = getFullName ($userID);
		//$deviceToken = 'b9554a031a80787b80539fe955afef10adb0f76ee392c58c4b126e7c1b718958';
		
		
		$payload['aps'] = array('alert' => $fullname.' '.$msg, 'title' =>'heat-app.com', 'badge' => intval($num_req), 'sound' => 'default', 'category' => 'notification');
		
		if ($_REQUEST['debug']){
			print_r ($payload['aps']);
		}
		
		$payload = json_encode($payload);

		//echo $payload."<br/>";

		$apnsHost = 'gateway.sandbox.push.apple.com';//sandbox for development testing. For production , must use gateway.push.apple.com
		$apnsPort = 2195;

		//openssl pkcs12 -in server_certificates_bundle_sandbox.p12 -out server_certificates_bundle_sandbox.pem -nodes -clcerts
		$apnsCert = dirname(__FILE__).'/server_certificates_bundle_sandbox.pem';//read how to create pem key at http://code.google.com/p/apns-php/wiki/CertificateCreation

		//echo $apnsCert."<br/>";

		$streamContext = stream_context_create();

		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

		$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);

		/*
		echo "Show Error";
		echo $error."<br/>";
		echo $errorString."<br/>";
		*/

		$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload)) . $payload;

		fwrite($apns, $apnsMessage);

		@socket_close($apns);
		fclose($apns);
	}
}

?>