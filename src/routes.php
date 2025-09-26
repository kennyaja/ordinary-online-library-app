<?php

use App\Controllers;

return [
	"/" => [Controllers\Index::class, "index"],

	"/j" => [Controllers\Test::class, "index"],
	"/yeet" => [Controllers\Test::class, "yeet"],
	
	"/admin" => [Controllers\Admin::class, "index"],
	"/admin/users" => [Controllers\Admin::class, "users"],
	"/admin/books" => [Controllers\Admin::class, "books"],
	
	"/books/book" => [Controllers\Books::class, "details"],
	"/api/books/list" => [Controllers\Books::class, "api_list"],
	"/api/books/submit" => [Controllers\Books::class, "api_submit"],
	"/api/books/update" => [Controllers\Books::class, "api_update"],
	"/api/books/delete" => [Controllers\Books::class, "api_delete"],
	"/api/books/details" => [Controllers\Books::class, "api_details"],

	"/api/users/list" => [Controllers\Users::class, "api_list"],
	"/api/users/insert" => [Controllers\Users::class, "api_insert"],
	"/api/users/update" => [Controllers\Users::class, "api_update"],
	"/api/users/delete" => [Controllers\Users::class, "api_delete"],
	"/api/users/details" => [Controllers\Users::class, "api_details"],
	
	"/login" => [Controllers\Login::class, "index"],
	"/signup" => [Controllers\Login::class, "signup"],
	"/api/login" => [Controllers\Login::class, "api_login", "method" => "POST"],
	"/api/logout" => [Controllers\Login::class, "api_logout"],
	"/api/signup" => [Controllers\Login::class, "api_signup", "method" => "POST"],

	"/api/admin_login" => [Controllers\Login::class, "api_admin_login", "method" => "POST"],
	"/api/admin_logout" => [Controllers\Login::class, "api_admin_logout"],
	
	
	"#status:400" => [Controllers\Error::class, "err_400"],
	"#status:401" => [Controllers\Error::class, "err_401"],
	"#status:403" => [Controllers\Error::class, "err_403"],
	"#status:404" => [Controllers\Error::class, "err_404"],
	"#status:500" => [Controllers\Error::class, "err_500"],
];

