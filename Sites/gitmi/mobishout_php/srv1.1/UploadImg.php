<?php
/**
 * User: zul
 * Date: 13/03/14
 * Time: 00:04
 */

class UploadImg {
    /**
     * @var db mysqli|string This is a db connector.
     */
    private $db;
    private $uploaddir = '../../../AAD/';
    private $plistPath = '../../../AAD/Ad.plist';
    private $allowedExts = array("png");
    private $adImgNames = array("Ad~iphone","Ad-568h@2x","Ad-Portrait~ipad","Ad-Landscape~ipad");

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

    function newAd($arr){
        $files = array();
        $names = $this->adImgNames;

        for($i=0;$i<count($names);$i++){
            array_push($files, $this->saveFile($_FILES['file'.($i+1)], $names[$i], ($i+1)));
        }

        $sql = 'insert into ads (delay,link,description,date_start,date_end)
                values(
                "' . $arr[0]['delay'] . '",
                "' . $arr[0]['link'] . '",
                "' . $arr[0]['description'] . '",
                "' . $arr[0]['date_start'] . '",
                "' . $arr[0]['date_end'] . '")';

        $r = $this->db->query($sql);

        $r[0]->files = $files;

        $this->createPlist($arr[0]['delay'],$arr[0]['link']);

        return $r;
    }
    function saveFile($file, $newName, $n){

        $fileName = $file['name'];
        $fileType = $file["type"];

        $nameExplode = explode(".", $fileName);
        $extension = end($nameExplode);

        if ((($fileType == "image/x-png") || ($fileType == "image/png")) && in_array($extension, $this->allowedExts)
        ) {

            $tmpFilePath = $file["tmp_name"];
            //Make sure we have a filepath
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newFilePath = $this->uploaddir . $newName . '.' . $extension;

                //Upload the file into the temp dir
                move_uploaded_file($tmpFilePath, $newFilePath);

                return (object) array('success'=>true, 'name' => $fileName, 'new_name' => ($newName . '.' . $extension));
            }
        }
        return (object) array('success'=>false, 'name' => $fileName, 'input' => ('file'.$n));
    }
    function createPlist($delay,$link){
        $myFile = $this->plistPath;
        $fp = fopen($myFile, 'w') or die("can't open file");

        $StringData = '<?xml version="1.0" encoding="UTF-8"?>
                        <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
                        <plist version="1.0">
                        <dict>
                            <key>Delay</key>
                            <string>'.$delay.'</string>
                            <key>Link</key>
                            <string>'.$link.'</string>
                        </dict>
                        </plist>';

        $StringData=utf8_encode($StringData);
        $StringData="\xEF\xBB\xBF".$StringData;
        fwrite($fp,$StringData);

        fclose($fp);
    }
} 