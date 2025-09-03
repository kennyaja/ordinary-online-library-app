<?php

ini_set("display_errors", 0);

session_start();

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require(getcwd() . "/../vendor/autoload.php");

//use Dotenv\Dotenv;
//$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
//$dotenv->load();

use App\Lib\Directory\Directory;

$dotenv_vars = file(Directory::get_full_path(".env"));
foreach ($dotenv_vars as $index => $var) {
	$key_value_arr = explode("=", trim($var), 2);
	$_ENV[$key_value_arr[0]] = $key_value_arr[1];
}

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

if (http_response_code() >= 400) {
	echo http_response_code();
}