<?php
// Replace with real server API key from Google APIs
$apiKey = "AIzaSyBqc5XqUI4gCsqOmi_lV4NbYNm9IadmMu0";

// Replace with real client registration IDs
//$registrationIDs = array( "APA91bEKxs6HYe3r3i5U_6wWc_L4vs6ql6rzA52R_HCQKU_qILPUK4IwnZ9gNj6n93AsBvdhy-Kjy_2saDP2dkdshfjl-ZKQoRLBBXfSD0e3nrqmr-P_GZgGbmMsOlV8Wt2R4opQ_ZS9xiZ_rv2x4v3eQvYWTT6ZYQ");
//$registrationIDs = array( "APA91bF_iyR6_98_zw69RAB5vBoFAZKy2pGoJKEKKn9suKmuV0BWhMP0nREBwImDjcpAPCqcmRVhXm_b2-ldvgMznjf4aSPj3q1yGnlPOcogNq8LYNMO4beAZJ_gU-DEO3VERjAJyV8FFUGMRLtKIZ2wy9nMglnK7A");
$registrationIDs = array("APA91bFosiTJefO-VR94OHJqsWGyDpoxei4btWf7rmusM6LNUCC9hjKBxXJ8oBqQSVn_X5DrsYZvO_wfQI1jnoDuy8uDbVNDdfsFjex1YcwWLWxdcpeBuPZ5jI7Bl7M9PaM6G7YoHM8fXelCYqxcpsc0_eAn_3Ac7dP93cTqZWZAzTsNWmeGHfg");
//$registrationIDs = array( "APA91bHZ4ev9vRvrvckqxzvoN_lLy-XjSeFRTmG6KK6k1ziVLqWKDdWo3xulN9zrE7BzXtUAmftfLivGMgRY7NN6KVPc0WzNwZSo_ukAvQOqqyydOPvcdbSeGBvdH0UFBET4AZDOIfUOTyYb_8JfOUA4fDbpl4FOqQ");
// Message to be sent
$message = "!!!MOBINTEG!!!";

// OlV8Wt2R4opQ_ZS9xiZ_rv2x4v3eQvYWTT6ZYQ  New-> APA91bGaNGgCeifmFIod7XaAR4e5quQyV6k3k9KH8oxeSf0GbxCVXG_fUWpF4HRmi5cU0ryHrC5LXb8tWYFXZljXO7Lyv2xUS6MCDMNHL-b7Ftp1Jq1jDQffhAsYcLzTY-71X7LD2atLitr4PxnWn9fbmzFCq1ZvKA -> {


// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
    'registration_ids' => $registrationIDs,
    'data' => array("message" => $message),
);

$headers = array(
    'Authorization: key=' . $apiKey,
    'Content-Type: application/json'
);

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);

echo $result;

//print_r($result);
//var_dump($result);
?>