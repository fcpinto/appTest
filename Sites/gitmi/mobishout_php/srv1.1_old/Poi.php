<?php
/**
 * Created by IntelliJ IDEA.
 * User: zul
 * Date: 19/02/14
 * Time: 17:18
 */

/**
 * Class Poi - Point Of Interest
 */
class Poi {

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

    //***** TYPE OF POI ******//
    /**
     * getPoisType
     *
     * to get all types of pois (table: pois_type)
     *
     * @return mixed
     */
    function getPoisType(){
        $sql = 'select * from pois_type';

        $r = $this->db->query($sql);
        return $r;
    }

    /**
     * setPoiType
     *
     * to update type of poi (table: pois_type)
     *
     * @param $arr
     * @return mixed
     */
    function setPoiType($arr){

        $sql = 'update pois_type set
				description = "' . $arr[0]['description'] . '",
				active = "' . $arr[0]['active'] . '"
				where poi_type_id = "' . $arr[0]['poi_type_id'] . '"';

        $r = $this->db->query($sql);
        return $r;
    }

    /**
     * newPoiType
     *
     * to create a new type of poi (table: pois_type)
     *
     * @param $arr
     * @return mixed
     */
    function newPoiType($arr){

        $sql = 'INSERT INTO pois_type (description, active)
					VALUES (
					"' . $arr[0]['description'] . '",
					"' . $arr[0]['active'] . '")';

        $r = $this->db->query($sql);
        return $r;
    }

    //***** POI ******//
    /**
     * getPois
     *
     * to get all pois (table: pois)
     *
     * @return mixed
     */
    function getPois(){
        $sql = 'select * from pois';

        $r = $this->db->query($sql);
        return $r;
    }

    /**
     * getPoi
     *
     * to get a specific poi from id (table: pois)
     *
     * @param $arr
     * @return mixed
     */
    function getPoi($arr){

        $sql = 'select *
				from pois
				where poi_id=' . $arr[0]['poi_id'];

        $r = $this->db->query($sql);
        return $r;
    }

    /**
     * setPoi
     *
     * to update a specific poi from id (table: pois)
     *
     * @param $arr
     * @return mixed
     */
    function setPoi($arr){

        $sql = 'update pois set
				poi_type_id = "' . $arr[0]['poi_type_id'] . '",
				title = "' . $arr[0]['title'] . '",
				description = "' . $arr[0]['description'] . '",
				lat = "' . $arr[0]['lat'] . '",
				lng = "' . $arr[0]['lng'] . '",
				date_start = "' . $arr[0]['date_start'] . '",
				date_end = "' . $arr[0]['date_end'] . '",
				active = "' . $arr[0]['active'] . '"
				where poid_id = "' . $arr[0]['poid_id'] . '"';

        $r = $this->db->query($sql);
        return $r;
    }

    /**
     * newPoi
     *
     * to create a poi (table: pois)
     *
     * @param $arr
     * @return mixed
     */
    function newPoi($arr){

        $sql = 'INSERT INTO pois (poi_type_id, title, description, lat, lng, date_start, date_end, active)
					VALUES (
					"' . $arr[0]['poi_type_id'] . '",
					"' . $arr[0]['title'] . '",
					"' . $arr[0]['description'] . '",
					"' . $arr[0]['lat'] . '",
					"' . $arr[0]['lng'] . '",
					"' . $arr[0]['date_start'] . '",
					"' . $arr[0]['date_end'] . '",
					"' . $arr[0]['active'] . '")';

        $r = $this->db->query($sql);
        return $r;
    }
} 