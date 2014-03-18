<?php

class Issues
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

    function getIssues()
    {
        $sql = 'select * from issues ';
        
        $r = $this->db->query($sql);
        return $r;
    }

    function getIssue($arr)
    {
        $sql = 'select * 
				from issues 
				where issue_id=' . $arr[0]['issue_id'];
        
        $r = $this->db->query($sql);
        return $r;
    }
	
	function newIssueFolder($arr)
    {
		$sql = 'SELECT MAX(issue_id) as max_id FROM issues';
		
		$r = $this->db->query($sql);
		
		$max_id = $r[0]['max_id'];
		
		/* var_dump($r);
		echo $r[0]['max_id'];
		 */
		
		$max_id = $max_id+1;
		
		$id = (string) $max_id;
		
		if(strlen($max_id)==1)
		{
			$id = "00$id";
		}
 		if(strlen($max_id)==2)
		{
			$id = "0$id";
		} 

			if (!file_exists('../../../shout/')) {
				mkdir("../../../shout".$id."/", 0777, true);
			} 

/* 		 $sql = 'select * from issues
				where issue_id="'.$arr[0]['issue_id'].'"';

        $r = $this->db->query($sql);

		if(count($r)==0){ */
		
			$sql = 'INSERT INTO issues (issue_id, active)
					VALUES (

					"' . $id . '",
					0)';
									
/* 		}else{
			$r = (object) array('s' => '0','m' => 'FILENAME ALREADY EXISTS');
		}	 */

		$r = $this->db->query($sql);
        return $id;	 
    }
	
	function deleteIssueFolder($arr)
    {
		$sql = 'SELECT MAX(issue_id) as max_id FROM issues';
		
		$r = $this->db->query($sql);
		
		$max_id = $r[0]['max_id'];
		
		/* var_dump($r);
		echo $r[0]['max_id'];
		 */
		
		$max_id = $max_id;
		
		$id = (string) $max_id;
		
		if(strlen($max_id)==1){
			$id = "00$id";
		}
 		if(strlen($max_id)==2){
			$id = "0$id";
		}

		if (!file_exists('../../../shout/')) {
				rmdir("../../../shout".$id."/");
		} 

		$sql = 'delete from issues
		where issue_id = "'.$max_id.'"';
			
        $r = $this->db->query($sql);
        return $r;	
    }
	
	function newIssue($arr)
    {
        $sql = 'select * from issues
				where filename="'.$arr[0]['filename'].'"';

        $r = $this->db->query($sql);

		if(count($r)==0){
			$sql = 'INSERT INTO issues (filename, keywords, title, subtitle, description, thumbnail, document_type_id, date_start, date_end, active)
					VALUES (

					"' . $arr[0]['filename'] . '",
					"' . $arr[0]['keywords'] . '",
					"' . $arr[0]['title'] . '",
					"' . $arr[0]['subtitle'] . '", 
					"' . $arr[0]['description'] . '", 
					"' . $arr[0]['thumbnail'] . '",					
					"' . $arr[0]['document_type_id'] . '",
					"' . $arr[0]['date_start'] . '", 
					"' . $arr[0]['date_end'] . '",
					"' . $arr[0]['active'] . '")';
					
			$r = $this->db->query($sql);
			
		//set thumbnail image link
         $this->auxF = new AuxFunctions();
        $thumbnailLink = $this->auxF->base64toPhoto($arr[0]['issue_id'],$arr[0]['thumbnail']); 
			
		}else{
			$r = (object) array('s' => '0','m' => 'FILENAME ALREADY EXISTS');
		}
        return $r;
    }
	

 	function setIssue($arr)
    {

		//set thumbnail image link
        $this->auxF = new AuxFunctions();
        $thumbnailLink = $this->auxF->base64toPhoto($arr[0]['issue_id'],$arr[0]['thumbnail']);   
	   
         $sql = 'update issues set 
				filename = "'.$arr[0]['filename'].'",
				keywords = "'.$arr[0]['keywords'].'",
				title = "'.$arr[0]['title'].'",
				subtitle = "'.$arr[0]['subtitle'].'",
				description = "'.$arr[0]['description'].'",
				thumbnail = "' . $thumbnailLink . '",
				document_type_id = "'.$arr[0]['document_type_id'].'",
				date_start = "'.$arr[0]['date_start'].'",
				date_end = "'.$arr[0]['date_end'].'",
				active = "'.$arr[0]['active'].'"
				where issue_id = "'.$arr[0]['issue_id'].'"'; 

/* 		$sql = 'update issues set 
				filename = "'.$arr[0]['filename'].'"
				where issue_id = "'.$arr[0]['issue_id'].'"';	 */	
				
        $r = $this->db->query($sql);
        return $r;
    }
	
	 	function deleteIssue($arr)
    {
        $sql = 'delete from issues
				where issue_id = "'.$arr[0]['issue_id'].'"';

		$max_id = $arr[0]['issue_id'];
				
		if(strlen($max_id)==1)
		{
			$id = "00$max_id";
		}
 		if(strlen($max_id)==2)
		{
			$id = "0$max_id";
		}	 		
		
		$id = 'shout'.$id;
		
		function rrmdir($id) { 
		  foreach(glob('../../../'.$id . '/*') as $file) { 
			if(is_dir($file)) rrmdir($file); else unlink($file); 
		  } rmdir('../../../'.$id); 
		}			
				
		rrmdir($id);	 
/*  		if (!file_exists('shout/')) {
				//system("rm -rf ".escapeshellarg("test".$id."/"));
				rmdir("shout".$id."/");
			}   */

        $r = $this->db->query($sql);
        return $max_id;
    }
}
?>