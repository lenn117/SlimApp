<?php
/**
 * Database Manager - DAO Factory
 * Web Api assignment - Enterprise Application Development
 * @author John Lennon
 */
include_once 'simple_db_manager.php';

class DAO_Factory{
	private $dbManager;
	
	function getDbManager() {
		if ($this->dbManager == NULL) {
			throw new Exception ("No persistence storage link.");
			return $this->dbManager;
		}
	}
	
	
	//Init Resources - connect to db
	function initDBResources(){
		$dbName = "ditcoursedb";
		$this->dbManager = new DBmanager($dbName);
		$this->dbManager->openConnection();
	}
	
	
	//Release the resources - close the db
	function clearDBResources(){
		if ($this->dbManager != NULL) {
			$this->dbManager->closeConnection();
		}
	}
	
	function getCarsDAO(){
		require_once ("DAO/carsDAO.php");
		$carsDAO = new carsDAO($this->dbManager);
		
		return $carsDAO;
	}
}
?>