<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require("../vendor/autoload.php");
$routes = require("../src/routes.php");

echo $routes[str_replace("/", "", $path)];
