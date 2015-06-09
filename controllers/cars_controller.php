<?php
/**
 * Controller class for Cars
 * Web Api assignment -Enterprise Application Development
 * @author John Lennon
 */
class carsController{
	private $model, $slimApp;
	
	public function __construct($model, $action=null, $slimApp, $parameters=null){
		$this->model = $model;
		$this->slimApp = $slimApp;
		$requestPar = $this->slimApp->request()->params();
		
		if($action!=null){
			switch ($action){
				case ACTION_GET_CARS: $this->getCars(); //Action for getting info of one car.
				break;
				
				case ACTION_GET_CAR: $this->getCar($parameters); //Action for getting info of multiple cars.
				break;
				
				case ACTION_SEARCH_CARS: $this->findCarsByString($parameters); //Searching for cars with specific term.
				break;
				
				case ACTION_ADD_CAR: $this->addUpdateCar($parameters, false); //Adding new car + information
				echo "-------  Car added!  ------  "; //Printing to console for user
				break;
				
				case ACTION_UPDATE_CAR: $this->addUpdateCar($parameters, true); //Updating car information
				echo "-------  Car updated!  ------  "; //Printing to console for user
				break;
				
				case ACTION_DELETE_CAR: $this->deleteCar($parameters); //Deleting Car from API
				echo "-------  Car deleted!  ------  "; //Printing to console for user
				break;
				default:
					
			}
		}
	}
	
	private function getCars(){ //Function for getting all info on all cars
		$this->model->apiResponse = $this->model->getCars();
		if(count($this->model->apiResponse)==0)
			$this->slimApp->response->setStatus(HTTPSTATUS_NOCONTENT);
		else
			$this->slimApp->response->setStatus(HTTPSTATUS_OK);
	}
	
	private function getCar($parameters){ //Function for getting info on a car with particular id
		$id = $parameters["id"];
		if (isset($id)){
			if (is_numeric($id)){
				if($this->model->isCarExisting($id)){
					$this->model->apiResponse = $this->model->getCar($id);
					$this->slimApp->response->setStatus(HTTPSTATUS_OK);
					return;
				}
			}
			else{
				$this->slimApp->response->setStatus(HTTPSTATUS_BADREQUEST);
				return;
			}
		}
		$this->slimApp->resource->setStatus(HTTPSTATUS_NOTFOUND);
	}
	
	private function findCarsByString($parameters){ //Function for getting all info cars using a search term
		$query = $parameters["query"];
		$this->model->apiResponse = $this->model->findCarsByString($query);
		$this->slimApp->response->setStatus(HTTPSTATUS_OK);
	}
	
private function addUpdateCar($parameters, $isUpdate = false) { //Function for adding / updating cars
		$inputJson = $parameters ["json"]; //Input is taken in json form
		if (isset ( $inputJson )) {
			$jo = json_decode ( $inputJson, true ); // decoding json string to ass. array
			if (isset ( $jo ["name"] ) && isset ( $jo ["model"] ) && isset ( $jo ["year"] ) && isset ( $jo ["prevOwner"] )) {
				//Setting each field from json decoded array
				if (is_numeric ( $jo ["year"] )) {
					if ($isUpdate) { //If updating old field then code below runs
						if (isset ( $parameters ["id"] )) {
							$id = $parameters ["id"];
							if ($this->model->isCarExisting ( $id )) {
								$id = $this->model->updateCar ( $id, $jo ["name"], $jo ["model"], $jo ["year"], $jo ["prevOwner"] );
								$this->slimApp->response->setStatus ( HTTPSTATUS_OK ); //Car updated and ok http status
								return;
							} else //Car not found error handling
								$this->slimApp->response->setStatus ( HTTPSTATUS_NOTFOUND );
						}
					} else { //If adding new car
						$id = $this->model->addCar ( $jo ["name"], $jo ["model"], $jo ["year"], $jo ["prevOwner"] );
						if ($id) {
							$jsonResponse ["Location"] = "cars/$id";
							$this->model->apiResponse = $jsonResponse;
							$this->slimApp->response->setStatus ( HTTPSTATUS_CREATED );
							return;
						}
					}
				}
			}
		}
		else 
		$this->slimApp->response->setStatus ( HTTPSTATUS_BADREQUEST );
	}
	
	private function deleteCar($parameters){ //Deleting car from car DB using known id
		$id = $parameters["id"];
		if ($this->model->isCarExisting($id)){ //checks if car id does exist, 404 if not found
			$this->model->deleteCar($id);
			$this->slimApp->response->setStatus(HTTPSTATUS_OK);
			return;
		}
		$this->slimApp->response->setStatus(HTTPSTATUS_NOTFOUND);
	}
}
?>