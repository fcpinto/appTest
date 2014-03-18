<?php
/**
 * User: zul
 * Date: 12/03/14
 * Time: 16:27
 */

class Ad {
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
     * setNewAd
     *
     * $arr[{delay,link,image1,image2,image3,image4}]
     *
     * @param $arr
     * @return array
     */
    function setNewAd($arr){

        //return $GLOBALS['servicesFolder'].'/shout';

        /*global $servicesFolder;

        return $servicesFolder;*/



        $this->auxF = new AuxFunctions();

        $image1 = (object) array('name' => 'Ad~iphone', 'folder' => 'AAD', 'image' => $arr[0]["image1"]);
        $image2 = (object) array('name' => 'Ad-568h@2x', 'folder' => 'AAD', 'image' => $arr[0]["image2"]);
        $image3 = (object) array('name' => 'Ad-Portrait~ipad', 'folder' => 'AAD', 'image' => $arr[0]["image3"]);
        $image4 = (object) array('name' => 'Ad-Landscape~ipad', 'folder' => 'AAD', 'image' => $arr[0]["image4"]);

        $photoLinks = array();
        array_push($photoLinks, $this->auxF->saveBase64toPhoto($image1));
        array_push($photoLinks, $this->auxF->saveBase64toPhoto($image2));
        array_push($photoLinks, $this->auxF->saveBase64toPhoto($image3));
        array_push($photoLinks, $this->auxF->saveBase64toPhoto($image4));

        return $photoLinks;

    }
} 