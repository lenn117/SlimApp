<?php
/* Index page for Cars
 * Web Api assignment - Enterprise Application Development
 * @author John Lennon
 *
 */
require_once '../Slim/Slim.php';
Slim\Slim::registerAutoloader ();

//Instantiate the slim api
$app = new Slim\Slim ( array (
		'debug' => true 
) );

$app = new \Slim\Slim ();

ob_end_clean();

include_once "./conf/config.inc.php";
include_once "models/cars_model.php";
include_once "controllers/cars_Controller.php";
include_once "views/cars_view.php";

//Defining the Slim application routes for browser.
$app->get ( '/', 'welcomeFunction' );
function welcomeFunction() {
	echo "Welcome";
}

$app->get ( '/cars', function () use($app) {
	$MVC = new MVCComponents ( ACTION_GET_CARS, $app );
} );

$app->get ( '/cars/:id', function ($id) use($app) {
	$parameters["id"] = $id;
	$MVC = new MVCComponents ( ACTION_GET_CAR, $app, $parameters );
} );

$app->get ( '/cars/search/:query', function ($query) use($app) {
	$parameters["query"] = $query;
	$MVC = new MVCComponents ( ACTION_SEARCH_CARS, $app , $parameters);
} );

$app->get ( '/cars', function () use($app) {
	$parameters["json"]=$app->request->getBody();
	$MVC = new MVCComponents ( ACTION_GET_CAR, $app, $parameters );
} );

$app->get ( '/cars/:id', function ($id) use($app) {
	$parameters["id"] = $id;
	$parameters["json"] = $app->request->getBody();
	$MVC = new MVCComponents ( ACTION_GET_CAR, $app, $parameters );
} );

$app->get ( '/cars/:id', function ($id) use($app) {
	$parameters["id"]=$id;
	$MVC = new MVCComponents ( ACTION_GET_CAR, $app, $parameters);
} );

$app->post ( '/cars', function () use($app) { //Adding new car to Db
	$request = $app->request();
	$body = $request->getBody();

	$s = preg_match('/name:([a-zA-Z ]+)/', $body, $nameMatch); //Using regex expression to get info from user input
    $name = $nameMatch[1]; //Reads input till space for name of car

    $s = preg_match('/model:([a-zA-Z ]+)/', $body, $modelMatch);
    $model = $modelMatch[1]; //Reads input till space for model of car

    $s = preg_match('/year:([0-9 ]+)/', $body, $yearMatch);
    $year = $yearMatch[1]; //Reads input till space for year of car

    $s = preg_match('/prevOwner:([a-zA-Z ]+)/', $body, $prevOwnerMatch);
    $prevOwner = $prevOwnerMatch[1]; //Reads input till space for previous owner of car

    $params = array("name" => $name, "model" => $model, "year" => $year, "prevOwner" => $prevOwner);

	$parameters["json"] = json_encode($params); //Encoding user input from string to json array

	$MVC = new MVCComponents ( ACTION_ADD_CAR, $app, $parameters ); //Using json data to add new car
} );


$app->put ( '/cars/:id', function ($id) use($app) { //Updating car info
	$parameters["id"] = $id;

	$request = $app->request();
	$body = $request->getBody();

	$s = preg_match('/name:([a-zA-Z ]+)/', $body, $nameMatch);
    $name = $nameMatch[1];//Reads input till space for name of car

    $s = preg_match('/model:([a-zA-Z ]+)/', $body, $modelMatch);
    $model = $modelMatch[1];//Reads input till space for model of car

    $s = preg_match('/year:([0-9 ]+)/', $body, $yearMatch);
    $year = $yearMatch[1];//Reads input till space for year of car

    $s = preg_match('/prevOwner:([a-zA-Z ]+)/', $body, $prevOwnerMatch);
    $prevOwner = $prevOwnerMatch[1];//Reads input till space for previous owner of car

    $params = array("name" => $name, "model" => $model, "year" => $year, "prevOwner" => $prevOwner);

	$parameters["json"] = json_encode($params);//Encoding user input from string to json array
	$MVC = new MVCComponents ( ACTION_UPDATE_CAR, $app, $parameters );//Using json data to update car
} );

$app->delete ( '/cars/:id', function ($id) use($app) { //Deleting car info
	$parameters["id"] = $id;
	$MVC = new MVCComponents ( ACTION_DELETE_CAR, $app, $parameters );
} );

//set up common headers for every response
$app->response()->header("Content-Type", "application/json; charset=utf-8");

//Run the slim framework
$app->run();

class MVCComponents{
	public function __construct($action, $app, $parameters=null){
		$model = new carsModel(); //common model
		$controller = new carsController($model, $action, $app, $parameters);
		//common controller with different actions
		$view = new carsView($controller, $model, $app); //common view
		$view->output();
	}
}
?>