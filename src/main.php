<?php

session_start();

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require(getcwd() . "/../vendor/autoload.php");

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

use App\Lib\Directory\Directory;
$routes = require(Directory::get_full_path("src/routes.php"));

//if (is_array($routes[$path])) {
//	if ($routes[$path]["method"] != $_SERVER["REQUEST_METHOD"]) {
//		echo "nuh uh";
//	} else {
//		echo $routes[$path][0];
//	}
//} else {
//	echo $routes[$path];
//}

if (isset($routes[$path])) {
	if (array_key_exists("method", $routes[$path]) ) {
		if ($routes[$path]["method"] == $_SERVER["REQUEST_METHOD"]) {
			echo (new $routes[$path][0])->{$routes[$path][1]}();
		} else {
			http_response_code(404);
		}
	} else {
		echo (new $routes[$path][0])->{$routes[$path][1]}();
	}
} else {
	http_response_code(404);
}

