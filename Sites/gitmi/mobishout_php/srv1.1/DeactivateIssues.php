<?php
class DeactivateIssues
{
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
    function deactivateIssues()
    {
    	$sql="UPDATE issues set active = 0 WHERE date_end < CURDATE()";
    	
    	$r = $this->db->query($sql);
    	file_get_contents("http://mobi-shout.com/mobishout/mobipromos/web/admin/srv1.1/index.php?q={%22CreatePlist_create%22:[{}]}","r");
        return $r;

    }
}
?>