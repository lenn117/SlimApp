<?php
/* Model class for Cars
 * Web Api assignment - Enterprise Application Development
 * @author John Lennon
 */
include_once './conf/config.inc.php';
include_once './db/DAO_factory.php';

class carsModel{
	public $DAO_Factory, $validationFactory; //factories
	public $carsDAO; //DAOS
	public $apiResponse;
	
	public function __construct(){
		$this->DAO_Factory = new DAO_Factory();
		$this->DAO_Factory->initDBResources();
		$this->carsDAO = $this->DAO_Factory->getCarsDAO();
	}
	
	public function isCarExisting($id){ //Checking if car exists using id
		return ($this->carsDAO->isCarExisting($id));
	}
	
	public function getCars(){ //Getting all cars info
		$carsList = $this->carsDAO->getCars();
		return $carsList;
	}
	
	public function getCar($id){ //Getting a car + info using id
		$carDetail = $this->carsDAO->getCarsById($id);
		return $carDetail[0];
	}
	
	public function findCarsByString($str){ //Searching using term for car/s + info
		$carsList = $this->carsDAO->findCarsByString($str);
		return $carsList;
	}
	
	public function addCar($name, $make, $year, $prevOwner){ //Adding a new car to DB
		return ($this->carsDAO->insertCar($name, $make, $year, $prevOwner));
	}
	
	public function updateCar($id, $newName, $newModel, $newYear, $newPrevOwner){ //Updating car info
		return ($this->carsDAO->updateCar($id, $newName, $newModel, $newYear, $newPrevOwner));
	}
	
	public function deleteCar($id){ //Deleting car using known id
		$this->carsDAO->deleteCar($id);
	}
	
	public function __destruct(){ //Clearing resources of DB
		$this->DAO_Factory->clearDBResources();
	}
}
?>