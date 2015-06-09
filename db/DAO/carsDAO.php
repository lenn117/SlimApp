<?php
/*
*	DAO class for Cars Web API
*	Enterprise Application Development
*	@author John Lennon
*/
require_once ("dao.php");
class carsDAO extends BaseDAO {
	function messagesDAO($dbMng){
		parent::BaseDAO($dbMng);
	}
	
	public function isCarExisting($id){ //Checking if car does exist in DB
		$sqlQuery = "SELECT count(*) as isExisting ";
		$sqlQuery .= " FROM cars ";
		$sqlQuery .= " WHERE id= '$id'";
		$result = $this->getDbManager()->executeSelectQuery($sqlQuery);
		if ($result[0]["isExisting"] == 1) return (true);
		else return (false);
	}
	
	public function getCars(){ //Getting all cars currently in DB
		$sqlQuery = " SELECT * ";
		$sqlQuery .= " FROM cars ";
		$result = $this->getDbManager()->executeSelectQuery($sqlQuery);
		return ($result);
	}
	
	public function getCarsById($id){ //Getting particular car info, using known id
		$sqlQuery = " SELECT * ";
		$sqlQuery .= " FROM cars ";
		$sqlQuery .= " WHERE id = '$id' ";
		$result = $this->getDbManager()->executeSelectQuery($sqlQuery);
		return ($result);
	}
	
	public function findCarsByString($str){ //Searching for cars using search + particular/chosen term
		$sqlQuery = " SELECT * ";
		$sqlQuery .= " FROM cars ";
		$sqlQuery .= " WHERE name LIKE '%$str%' ";
		$result = $this->getDbManager()->executeSelectQuery($sqlQuery);
		return ($result);
	}
	
	public function insertCar($name, $model, $year, $prevOwner){ //Adding a new car to the DB
		$sqlQuery = " INSERT INTO cars (name, model, year, prevOwner) ";
		$sqlQuery .= " VALUES ('$name', '$model', $year, '$prevOwner') ";
		$result = $this->getDbManager()->executeInsertOrUpdateQuery($sqlQuery);
		//return ($result);
	}
	
	public function updateCar($id, $newName, $newModel, $newYear, $newPrevOwner){ //Updating info of car currently in DB, using known id
		$sqlQuery = " UPDATE cars SET name='$newName', model='$newModel',
		year='$newYear' , prevOwner='$newPrevOwner' ";
		$sqlQuery .= " WHERE id='$id' ";
		$result = $this->getDbManager()->executeInsertOrUpdateQuery($sqlQuery);
		//return ($result);
	}
	
	public function deleteCar($id){ //Deleting car + info using known id.
		$sqlQuery = "DELETE FROM cars ";
		$sqlQuery .= " WHERE id='$id'";
		$result = $this->getDbManager()->executeInsertOrUpdateQuery($sqlQuery);
		//return ($result);
	}
}