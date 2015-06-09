<?php
/**
 * Web test for url for api
 * Web Api assignment -Enterprise Application Development
 * @author John Lennon
 */
require_once '../simpletest/autorun.php';
require_once '../simpletest/web_tester.php';
echo "Tests on HTTP requests";

class CarWebTest extends WebTestCase{
 	private $app;
 	public $url = "http://localhost/slimapp/index.php";
	//set up app
	public function setUp(){
 		require_once '../slimapp/controllers/cars_controller.php';
 		$this->app = new CarWebTest();
 }
 	//test function for get request
 	public function testGet(){
 		$result = $this->get('http://localhost/slimapp/index.php/cars');
 		$this->assertTrue($result);
 }

 	//test get request with id
 	public function testGetId(){
 		$result = $this->get("http://localhost/slimapp/index.php/cars/1");
 		$this->assertTrue($result);
 }
 	//test post to add data to db
 	public function testPost(){
 		$result = $this->post('http://localhost/slimapp/app/index.php/cars','name=test,model=test,year=2010,prevOwner=test','application/json');
 		$this->assertTrue($result);
 }
 	//test the put request that updates the db
 	public function testPut(){
 		$result = $this->put('http://localhost/slimapp/index.php/cars','name=test,model=test,year=2009,prevOwner=test','application/json');
 		$this->assertTrue($result);
 }
 
 	public function testDelete(){
 		$result = $this->delete('http://localhost/slimapp/index.php/cars','name=test,model=test,year=2008,prevOwner=test','application/json');
  		 $this->assertTrue($result);
 }
  	//memory deallocation
 	public function tearDown(){
 		$this->app = NULL;
 }
}