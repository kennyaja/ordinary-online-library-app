<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;
use App\Models\AdminsModel;
use App\Models\CashiersModel;
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

	public function signup() {
		return View::get("login/signup.php", ["title" => "Sign Up"]);
	}
	
	public function api_login() {
		$this->http_header->content_type = "application/json";

		$users_model = new UsersModel();
		$cashiers_model = new CashiersModel();
		$admins_model = new AdminsModel();

		$user_data = $users_model->getFirst(condition: "username=?", params: [$_POST["username"]]);
		$user_role = "user";
		
		// first iteration (dang it why does the teacher want a discrete table for each account role)
		if (!$user_data) {
			$user_data = $cashiers_model->getFirst(condition: "username=?", params: [$_POST["username"]]);
			$user_role = "cashier";
		}
		
		// second iteration
		if (!$user_data) {
			$user_data = $admins_model->getFirst(condition: "username=?", params: [$_POST["username"]]);
			$user_role = "admin";
		}

		if (!$user_data || !password_verify($_POST["password"], $user_data["password_hash"])) {
			return json_encode(["error" => "Username or password is incorrect"]);
		}

		$_SESSION["username"] = $user_data["username"];
		$_SESSION["user_id"] = $user_data["id"];
		$_SESSION["user_role"] = $user_role;

		if ($user_role == "admin") {
			$this->http_header->location = "/admin";
			return;
		}

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
		if ($users_model->getFirst("username", "username = :username", ["username" => $_POST["username"]])) {
			$errors["username"] = "Username already exists";
		}
		
		if (strlen($_POST["password"]) < 3.14159265358979323846) {
			$errors["password"] = "Password must be longer than 3.14159265358979323846 characters";
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
			"email" => $_POST["email"] ?? ""]);

		$this->http_header->location = "/login";
		return;
	}
}
