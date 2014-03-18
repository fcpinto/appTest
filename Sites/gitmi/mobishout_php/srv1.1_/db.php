<?php
/**
 * Class db
 */
class db
{
    protected $conn;
    protected $db_user = 'mobinteg_msps';
    protected $db_pass = '5E_s~S~qihh_';
    protected $db_host = 'localhost';
    protected $db_name = 'mobinteg_msps';

    /**
     * @return mysqli|string
     */
    function connect()
    {
        try {
            $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            // check connection
            
            if ($this->conn->connect_error) {
                trigger_error('Database connection failed: '  . $this->conn->connect_error, E_USER_ERROR);
            }
            
            return $this->conn;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return null|string
     */
    function disconnect()
    {
        try {
            $this->conn = null;
            return $this->conn;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function query($sql)
    {
		$rows = array();
        try {
			$result = $this->conn->query($sql);

            if ($result) {		
				if (gettype($result) == "object"){
					
					while ($row = $result->fetch_assoc()) {
						$rows[] = $row;
					}
					mysqli_free_result($result);
				}else{
					$rows [] = (object) array('s' => '1');
				}
            }else{
				$rows [] = (object) array('s' => '0','m' => 'ERROR ON QUERY: '.$sql);
			}
        } catch (Exception $e) {
            $rows [] = (object) array('s' => '0','m' => 'EXCEPTION: ' . $e->getMessage());
        }
        return $rows;
    }
	
	    function multi_query($sql)
		{
		$rows = array();
        try {
			$result = $this->conn->multi_query($sql);

            if ($result) {		
				if (gettype($result) == "object"){
					
					while ($row = $result->fetch_assoc()) {
						$rows[] = $row;
					}
					mysqli_free_result($result);
				}else{
					$rows [] = (object) array('s' => '1');
				}
            }else{
				$rows [] = (object) array('s' => '0','m' => 'ERROR ON QUERY: '.$sql);
			}
        } catch (Exception $e) {
            $rows [] = (object) array('s' => '0','m' => 'EXCEPTION: ' . $e->getMessage());
        }
        return $rows;
    }
}

?>