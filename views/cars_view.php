<?php
/* View class for Cars
 * Web Api assignment - Enterprise Application Development
 * @author John Lennon
 */
class carsView{
	private $model, $controller, $slimApp;
	
	public function __construct($controller, $model, $slimApp){
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;
	}
	
	public function output(){
		//prepare json response
		$jsonResponse = json_encode($this->model->apiResponse);
		$this->slimApp->response->write($jsonResponse);
	}
}
?>