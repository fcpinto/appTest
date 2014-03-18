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
	
    function userNotification($title, $message, $registrationId)
    {
	
		$tickerText   = "ticker text message";
		$contentTitle = "content title";
		$contentText  = "content body";
		 
		//$registrationId = 'APA91bHjM2MoEgMcqNeTTMA_X8skggfq2YkQ3XI3k1HCKzSNboqpHZ9HDHpzoe4LGIifOgtb3fIeWADaQAxFAkxAOxtMFTBwgEr5kd-7KHCiXnpVo2tAAHyOibRKcWjmj-OOxrb5MYNXkbrpd9cKRBJse60Bk28LoA';

		$apiKey = "AIzaSyCL-8693xu7hKuKrVKHem9tM3qFY1RrXjk";
	
		//$message = $arr[0]['message'];

        try{
            $response = $this->sendNotification(
                $apiKey,
                array($registrationId),
                array('title' => $title, 'message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText)
            );

            $r = (object) array('s' => '1','m' => $response);
            return $r;
        }
        catch(Exception $e){
            $r = (object) array('s' => '0','m' => $e);
            return $r;
        }
    }
	
	function sendNotification( $apiKey, $registrationIdsArray, $messageData )
	{
		$randomNum=rand(10,100);

		$headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
		$data = array('data' => $messageData, 'registration_ids' => $registrationIdsArray, 'message_id'=>"".$randomNum."");

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

		$response = curl_exec($ch);
		curl_close($ch);
	 
		return $response;
	}
}

?>