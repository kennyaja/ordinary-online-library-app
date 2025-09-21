<?php

ini_set("display_errors", 0);

session_start();

require(getcwd() . "/../vendor/autoload.php");

use App\Lib\Directory\Directory;
use App\Lib\HTTP\HTTPHeader;

$http_header = new HTTPHeader();

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (substr($path, -1) == '/' && $path != '/') {
	$path = rtrim($path, '/');
}

//use Dotenv\Dotenv;
//$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
//$dotenv->load();

$dotenv_vars = file(Directory::get_full_path(".env"));
foreach ($dotenv_vars as $index => $var) {
	$key_value_arr = explode("=", trim($var), 2);
	$_ENV[$key_value_arr[0]] = $key_value_arr[1] ?? "";
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
	if ((array_key_exists("method", $routes[$path]) && $routes[$path]["method"] == $_SERVER["REQUEST_METHOD"]) ||
		!array_key_exists("method", $routes[$path])
	) {
		try {
			printf("%s", (new $routes[$path][0])->{$routes[$path][1]}());
		} catch (\Throwable $th) {
			http_response_code(500);
		}
	} else {
		http_response_code(404);
	}
} else {
	http_response_code(404);
}

// every status code corresponding to an error in http starts either with a 4 or 5
// ref: https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status
if (http_response_code() >= 400 && $http_header->content_type == "text/html") {
	$status_code_key = "#status:" . http_response_code();
	if (isset($routes[$status_code_key])) {
		if ($th != null && $_ENV["app_environment"] == "dev") {
			echo (new $routes[$status_code_key][0])->{$routes[$status_code_key][1]}($th);
		} else {
			echo (new $routes[$status_code_key][0])->{$routes[$status_code_key][1]}();
		}
	}
}
