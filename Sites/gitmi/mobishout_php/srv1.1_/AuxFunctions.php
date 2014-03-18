<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With'); 

class AuxFunctions
{
    public $a = array();
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

    function base64toPhoto($issue_id, $thumbnail)
    {
        global $servicesFolder;

        $mainURL = $servicesFolder.'/shout';
        if ($thumbnail != "" && $thumbnail != null) {


            $pos = strpos($thumbnail, "http://");
            if ($pos === false) {
                $dataImage = $thumbnail;
                $dataImage = str_replace("data:image/png;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/jpg;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/jpeg;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/gif;base64,", "", $dataImage);
                $decoded = base64_decode($dataImage);
				
				if(strlen($issue_id)==1){
					$coded_id = "00$issue_id";
				}
				if(strlen($issue_id)==2){
					$coded_id = "0$issue_id";
				}	
				
				$imageName = 'shout'. $coded_id;
				$imageName = base64_encode($imageName).'.png';
				$imageName = str_replace("=","",$imageName);
				
                //$imageName = $issue_id . '_thumbnail.png';

				//$imageNameURL = 'http://vozdamadeira.mobi-shout.com/admin/srv1.0/shout00'.$issue_id.'/'.$imageName;
                //echo "*********".$imageNameURL;
				
				if(strlen($issue_id)==1){
					$issue_id = "00$issue_id";
				}
				if(strlen($issue_id)==2){
					$issue_id = "0$issue_id";
				}
				
				 $imageNameURL = $mainURL . $issue_id .'/'. $imageName;
                file_put_contents('../../../shout'.$issue_id .'/'. $imageName, $decoded);
            } else {
                $imageNameURL = $thumbnail;
            }
            return $imageNameURL;
        } else {
            return "";
        }
    }

    //mi::dg ->
    function saveBase64toPhoto($details)
    {
        global $servicesFolder;

        $folderName = $details->folder;
        $imageName = $details->name;
        $thumbnail = $details->image;
        $mainURL = $servicesFolder.'/'.$folderName;

        if ($thumbnail != "" && $thumbnail != null) {

            $pos = strpos($thumbnail, "http://");
            if ($pos === false) {
                $dataImage = $thumbnail;
                $dataImage = str_replace("data:image/png;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/jpg;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/jpeg;base64,", "", $dataImage);
                $dataImage = str_replace("data:image/gif;base64,", "", $dataImage);
                $decoded = base64_decode($dataImage);

                $imageName =$imageName.'.png';

                $imageNameURL = $mainURL .'/'. $imageName;
                file_put_contents('../../../'.$folderName .'/'. $imageName, $decoded);
            } else {
                $imageNameURL = $thumbnail;
            }
            return $imageNameURL;
        } else {
            return "";
        }
    }
}