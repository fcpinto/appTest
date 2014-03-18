<?php

class createPlist
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

 	function create($arr)
    { 
		$sql = "SELECT * FROM issues where active = 1";
		
		$arr = array();
		
		$arr = $this->db->query($sql);
	
		//var_dump($arr);
		
	    $myFile = "../../../Magazines.plist";
        $fp = fopen($myFile, 'w') or die("can't open file");
		//$fp = fopen('test.plist', 'w');

		$StringData = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<array>';
		
		for($i=0; $i <count($arr); $i++){
			 
			$id = $arr[$i]['issue_id'];
			
			if(strlen($id)==1){
				$id = "00$id";
			}
			if(strlen($id)==2){
				$id = "0$id";
			} 

			$encondedData = base64_encode('shout' . $id );
			$encondedData = str_replace("=","",$encondedData);
			
			$StringData .= '
    <dict>
		<key>FileName</key>
		<string>shout' . $id . '/' . $encondedData . '.pdf</string>
		<key>Subtitle</key>
		<string>' . $arr[$i]['subtitle'] . '</string>
		<key>Title</key>
		<string>' . $arr[$i]['title'] . '</string>
	</dict>';
		}
/* 	<dict>
		<key>FileName</key>
		<string>shout' . $id . '/shout' . $id . '.pdf</string>
		<key>Subtitle</key>
		<string><![CDATA[' . $arr[$i]['subtitle'] . ']]></string>
		<key>Title</key>
		<string><![CDATA[' . $arr[$i]['title'] . ']]></string>
	</dict>';
		} */
		
		$StringData .= '
</array>
</plist>';
		
		echo $StringData;
		//mi needs to be an utf8 file. So we need to convert the string to utf 8 and the utf-8 file headers
		$StringData=utf8_encode($StringData);
		$StringData="\xEF\xBB\xBF".$StringData;
		fwrite($fp,$StringData);
		
		fclose($fp);	
		
		//missing return message
	 }
 }
?>