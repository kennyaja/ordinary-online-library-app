<?php

use App\Controllers;

return [
	"/" => [Controllers\Index::class, "index"],

	"/j" => [Controllers\Test::class, "index"],
	"/yeet" => [Controllers\Test::class, "yeet"],
	
	"/admin" => [Controllers\Admin::class, "index"],
	"/admin/users" => [Controllers\Admin::class, "users"],
	
	"/login" => [Controllers\Login::class, "index"],
	"/signup" => [Controllers\Login::class, "signup"],
	"/api/login" => [Controllers\Login::class, "api_login", "method" => "POST"],
	"/api/logout" => [Controllers\Login::class, "api_logout"],
	"/api/signup" => [Controllers\Login::class, "api_signup", "method" => "POST"],

	"/admin/login" => [Controllers\Login::class, "admin_login"],
	"/api/admin_login" => [Controllers\Login::class, "api_admin_login", "method" => "POST"],
	"/api/admin_logout" => [Controllers\Login::class, "api_admin_logout"],
	
	"#status:400" => [Controllers\Error::class, "err_400"],
	"#status:401" => [Controllers\Error::class, "err_401"],
	"#status:403" => [Controllers\Error::class, "err_403"],
	"#status:404" => [Controllers\Error::class, "err_404"],
	"#status:500" => [Controllers\Error::class, "err_500"],
];

