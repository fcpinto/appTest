<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With');
include 'config.php';
/**
 * @param $class_name
 */
function __autoload($class_name)
{
    include_once $class_name . '.php';
    //var_dump($class_name);
}

//response array
$r = array();

//query string in json format
//eg. ?q={"User_getUser":[{"id":1}]} to get user id=1
$q = $_REQUEST['q'];
$q = stripslashes($q);
//var_dump($q);


$callback = $_REQUEST['callback'];

$json = json_decode($q, true);

foreach ($json as $key => $value) {
    $a = explode("_", $key);
    $obj = new $a[0];
    $result[$key] = $obj->$a[1]($value);
};

//var_dump($result);
//$user = new User();
//$r = $user->getUser();
//$r[] = (object) array('getUser' => $user->getUser());
//var_dump($r);
//var_dump($q);
//echo $q;
//$json = json_decode($q,true);
//var_dump($json);
//foreach ($json as $key => $value){
//    echo $key;
//    $a = explode(".", $key);
//    echo $a[0];
//    $obj = new $a[0];
//    var_dump($obj->$a[1]($value));
//    echo $value[0]['id'];
//    var_dump($value);
//};
//echo json_encode($r);


//start output
if ($callback) {
    //header('Content-Type: text/javascript');
    echo $callback . '(' . json_encode($result) . ');';
} else {
    //header('Content-Type: application/x-json');
    echo json_encode($result);
}
?>