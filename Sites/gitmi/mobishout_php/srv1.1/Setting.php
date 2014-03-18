<?php
/**
 * User: zul
 * Date: 17/03/14
 * Time: 13:28
 */

/**
 * Class Setting
 */
class Setting {
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
     * getSettingsByKey
     *
     * get all settings by key
     *
     * @param $arr
     * @return array
     */
    function getSettingsByType($arr){

        $sql = 'select * from settings
				where type="'.$arr[0]['type'].'"';

        $r = $this->db->query($sql);

        return $r;
    }

    function getActiveOrderBy(){

        $sql = 'select * from settings
				where active=1 and type="order by"';

        $r = $this->db->query($sql);

        return $r;
    }
    function setActiveOrderBy($arr){

        $sql = 'select * from settings
                where value ="'.$arr[0]['value'].'"';

        $flag = count($this->db->query($sql));

        if($flag){
            $sql = 'update settings
                set active=0
                where active=1 and type="order by"';

            $this->db->query($sql);

            $sql = 'update settings
                set active=1
				where value="'.$arr[0]['value'].'"';

            $r = $this->db->query($sql);

        }
        else{
            $r = array((object) array('s' => '0','m' => 'you must choose a valid value'));
        }
        return $r;
    }
} 