<?php
class Database{
	
	// private $host  = 'remotemysql.com';
    // private $user  = 'dD2j7IvSPj';
    // private $password   = "Y4yno4UbHD";
    // private $database  = "dD2j7IvSPj";
	private $host = 'localhost';
	private $user = 'benax_iot_root';
	private $password = 'Td(FAdeZ9xp3';
	private $database = 'benax_iot';
    
    public function getConnection(){
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS `isite_received_data` (
				`data_id` int(11) NOT NULL AUTO_INCREMENT,
				`device_name` varchar(80) NOT NULL,
				`temperature` int(11) NOT NULL,
				`received_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`data_id`)
			   )");
		    $stmt->execute();
			return $conn;
		}
    }
}
?>