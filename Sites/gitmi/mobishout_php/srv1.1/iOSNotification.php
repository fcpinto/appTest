<?php

class iOSNotification
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

    function userNotification($title, $message, $deviceToken)
    {
        $resp = "";
        // Put your device token here (without spaces):
        //$deviceToken = 'b736aad9f6459a9d24fd3ffffd0599884b40777a5c16a80092658ed28f10f33f';

        // Put your private key's passphrase here:
        $passphrase = 'mobipromos123!';

        // Put your alert message here:
        //$message = $arr[0]['message'];
        //$message = "testing";
        ////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'mobiPROMOSck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        $resp = 'Connected to APNS!' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            $resp .= 'Message not delivered' . PHP_EOL;
        else
            $resp .= 'Message successfully delivered' . PHP_EOL;

        // Close the connection to the server
        fclose($fp);


        /*catch(Exception $e){
            $response = (object) array('s' => '0','m' => $e);
            return $response;
        }*/

        $r = (object) array('s' => '1','m' => $resp);
        //echo($r);
        return $r;
    }
}

?>