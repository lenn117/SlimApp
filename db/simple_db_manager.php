<?php
/**
 * Database Manager
 * Web Api assignment -Enterprise Application Development
 * @author John Lennon
 */
class DBManager {
	private $db_link;
	private $hostname = DB_HOST;
	private $username = DB_USER;
	private $password = DB_PASS;
	private $dbname;
	
	function __construct($dbname){
		$this->dbname = $dbname;
	}
	
	function openConnection(){
		
		$this->db_link = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname) or die("Unable to connect to database.");
	}
	
	public function executeSelectQuery($query){;
		$result = mysqli_query($this->db_link, $query) or die("Syntax error in SQL Statement.");
		//Fetch a result row as an associative array
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$rows[] = $row;
		}

	return $rows;
	}

	public function executeInsertOrUpdateQuery($query){
		$result = mysqli_query($this->db_link, $query) or die("Syntax error in SQL Statement.");
		echo "Insert/Update Query Ran!";
	}

	
	function closeConnection(){
		$this->db_link->close();
	}
}
?>