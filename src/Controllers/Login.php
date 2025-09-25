<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;
use App\Models\UsersModel;

class Login {
	var $http_header;
	
	public function __construct() {
		$this->http_header = new HTTPHeader();
	}

	public function index() {
		if (isset($_SESSION["user_id"])) {
			$this->http_header->location = "/";
			return;
		}

		return View::get("login/index.php", ["title" => "Log In"]);
	}

	public function admin_login() {
		if (isset($_SESSION["admin_id"])) {
			$this->http_header->location = "/admin";
		}

		return View::get("admin/login.php", ["title" => "Log in"]);
	}

	public function signup() {
		return View::get("login/signup.php", ["title" => "Sign Up"]);
	}
	
	public function api_login() {
		$this->http_header->content_type = "application/json";

		$users_model = new UsersModel();

		// $user_data = $users_model->getFirst(condition: "username=?", params: [$_POST["username"]]);
		$user_data = $users_model->where("username", $_POST["username"])->getFirst();

		if (!$user_data || !password_verify($_POST["password"], $user_data["password_hash"])) {
			return json_encode(["error" => "Username or password is incorrect"]);
		}

		$_SESSION["username"] = $user_data["username"];
		$_SESSION["user_id"] = $user_data["id"];
		$_SESSION["user_role"] = $user_data["role"];

		$this->http_header->location = "/";
	}

	public function api_logout() {
		unset($_SESSION["username"]);
		unset($_SESSION["user_id"]);
		unset($_SESSION["user_role"]);
		
		$this->http_header->location = "/";
	}

	// yeah whatever ill validate the inputs later
	public function api_signup() {
		$this->http_header->content_type = "application/json";

		$users_model = new UsersModel();
		
		$errors = [];

		if ($users_model->where("username", $_POST["username"])->getFirst()) {
			$errors["username"] = "Username already exists";
		}
		
		if (strlen($_POST["password"]) < 3.14159265) {
			$errors["password"] = "Password must be over &#960; (3.14159265...) characters";
		}
		
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$errors["email"] = "Invalid email address";
		}
		
		if ($errors != []) {
			return json_encode(["errors" => $errors]);
		}
		
		$users_model->insert([
			"username" => $_POST["username"], 
			"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
			"email" => $_POST["email"] ?? "",
			"role" => "user",
		])->execute();

		$this->http_header->location = "/login";
		return;
	}
}
