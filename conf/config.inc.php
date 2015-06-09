<?php
/**
 * Configuration file
 * containing all info for setting api up.
 *	Enterprise Application Development
 * @author John Lennon
 */

define('DB_HOST', 'localhost');	 //Setup database host
define('DB_USER', 'root'); 	//Setup database user
define('DB_PASS', '');	//Setup database password
define('DB_NAME', 'ditcoursedb');	//Setup database name
define('DB_PORT', '3306'); //setup db port

//car actions  - codes
define("ACTION_GET_CARS",1);
define("ACTION_GET_CAR",2);
define("ACTION_SEARCH_CARS",3);
define("ACTION_ADD_CAR",4);
define("ACTION_UPDATE_CAR",5);
define("ACTION_DELETE_CAR",6);

//http status codes
define("HTTPSTATUS_OK", 200);
define("HTTPSTATUS_CREATED", 201);
define("HTTPSTATUS_NOCONTENT", 204);
define("HTTPSTATUS_BADREQUEST", 400);
define("HTTPSTATUS_NOTFOUND", 404);
define("HTTPSTATUS_INTSERVERR", 500);

define("INPUT_MAX_LENGTH", 255) ; //varchar(255)
?>