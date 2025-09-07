<?php

use App\Controllers;

return [
	"/" => [Controllers\Index::class, "index"],

	"/j" => [Controllers\Test::class, "index"],
	
	"/admin" => [Controllers\Admin::class, "index"],
	"/admin/users" => [Controllers\Admin::class, "users"],

	"/login" => [Controllers\Login::class, "index"],
	"/signup" => [Controllers\Login::class, "signup"],
	"/api/login" => [Controllers\Login::class, "api_login", "method" => "nig"],
	"/api/logout" => [Controllers\Login::class, "api_logout"],
	"/api/signup" => [Controllers\Login::class, "api_signup", "method" => "POST"],
	
	"#status:404" => [Controllers\Error::class, "err_404"],
];

