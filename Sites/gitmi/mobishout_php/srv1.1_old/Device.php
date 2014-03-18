<?php

/**
 * Class Device
 */
class Device {

    /**
     * @var db mysqli|string This is a db connector.
     */
    private $db;

    //***** CONFIG ******//
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
     * newDevice
     *
     * create a new device
     *
     * @param $arr
     * @return array|object
     */
    function newDevice($arr)
    {
        /**
         * this statement check if already exists the new device token
         * returns empty array if not exist
         */
        $deviceExists = $this->deviceExists($arr[0]['devicetoken']);
        $flag = ($deviceExists->s==1);


        if($flag){//count($r)==0){
            $sql = 'insert into devices (devicetype, devicetoken, deviceuid, devicename, devicemodel, deviceversion)
					values (

					"' . $arr[0]['devicetype'] . '",
					"' . $arr[0]['devicetoken'] . '",
					"' . $arr[0]['deviceuid'] . '",
					"' . $arr[0]['devicename'] . '",
					"' . $arr[0]['devicemodel'] . '",
					"' . $arr[0]['deviceversion'] . '")';

            $r = $this->db->query($sql);

        }else{
            $r = $deviceExists;
        }
        return $r;
    }


    function deviceExists($token){
        $sql = 'select * from devices
				where devicetoken="'.$token.'"';

        $r = $this->db->query($sql);

        if(count($r) == 0){
            $r = (object) array('s' => '1','m' => 'DEVICE NOT EXISTS');
        }
        else{
            $r = (object) array('s' => '0','m' => 'DEVICE ALREADY EXISTS');
        }

        return $r;
    }

    /**
     * getDevicesByType
     *
     * returns all devices of choosen type
     * (usually call from Class Notification)
     *
     * @param $type
     * @return array
     */
    function getDevicesByType($type){

        $sql = 'select * from devices
				where devicetype="'.$type.'" and status = "1"';

        $r = $this->db->query($sql);

        return $r;
    }
} 