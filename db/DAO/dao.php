<?php
/**
 * Database Manager - DAO
 * Cars Web Api - Enterprise Application Development
 * @author John Lennon
 */
class BaseDAO { 
	public $dbManager; //Setting up the DB manager
	
	function BaseDAO($dbMng) {
		$this->dbManager = $dbMng;
	}
	
	function getDbManager() {
		return $this->dbManager;
	}
}
?>