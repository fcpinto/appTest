<?php
/**
 * Created by IntelliJ IDEA.
 * User: zul
 * Date: 28/02/14
 * Time: 13:26
 */

class Notification {

    /**
     * @var db mysqli|string This is a db connector.
     */
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

    /**
     * sendNotification
     *
     *
     *
     * @param $arr
     * @return array
     */
    function sendNotification($arr){

        $trimMsg = $arr[0]['message'];

        if (strlen($arr[0]['message']) > 60){
            $trimMsg = substr($arr[0]['message'], 0, 60) . '...';
        }
        $title = $arr[0]['title'];

        //$r = $this->sendNotificationTo('iOS', $trimMsg);
        $r = $this->sendNotificationTo('Android', $title, $trimMsg);

        return $r;

        /*$allUserDevices = $this->devices->getUserDevices($arr[0]['user_id']);

        $debug = array();

        $this->aNotification = new AndroidNotification();

        $this->iNotification = new iOSNotification();


        for ($i = 0; $i < sizeof($allUserDevices); $i++) {

            if($allUserDevices[$i]['devicetype']=='Android')
            {
                $this->aNotification->userNotification($trimMsg, $allUserDevices[$i]['devicetoken']);

            }
            else
            {
                $this->iNotification->userNotification($trimMsg, $allUserDevices[$i]['devicetoken']);
            }
            array_push ($debug, $allUserDevices[$i]['devicetoken']);
        }
        $this->mNotification->userNotification($arr);

        return $debug;*/
    }

    function sendNotificationTo($type, $title, $msg){

        $class_name = $type.'Notification';
        $deviceNotification = new $class_name();
        $device = new Device();

        $array = $device->getDevicesByType($type);
        $count = count($array);

        $r = array();


        for ($i = 0; $i < $count; $i++) {
            array_push($r, $deviceNotification->userNotification($title, $msg, $array[$i]['devicetoken']));
        }

        return $r;
    }
}