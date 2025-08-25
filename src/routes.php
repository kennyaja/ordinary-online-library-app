<?php

use App\Controllers;

return [
	"/" => [Controllers\Index::class, "index"],
	"/j" => [Controllers\Test::class, "index"],
	"/login" => [Controllers\Login::class, "index"],
	
	"/api/login" => [Controllers\Login::class, "api_login", "method" => "POST"],
];

