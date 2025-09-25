<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Models\UsersModel;

class Users {
	var $http_header;
	var $users_model;

	function __construct() {
		$this->http_header = new HTTPHeader();
		$this->users_model = new UsersModel();
	}

	public function api_list() {
		$this->http_header->content_type = "text/json";

		return json_encode($this->users_model->getAll());
	}

	public function api_details() {
		$this->http_header->content_type = "text/json";

		return json_encode($this->users_model->getFirst());
	}

	public function api_insert() {
		$this->http_header->content_type = "application/json";

		$errors = $this->validate_user_data($_POST["username"], $_POST["password"], $_POST["email"]);
		if ($errors != []) {
			return json_encode(["status" => "error", "errors" => $errors]);
		}

		$this->users_model->insert([
			"username" => $_POST["username"], 
			"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
			"email" => $_POST["email"] ?? "",
			"role" => $_POST["role"] ?? "user",
		])->execute();

		return json_encode(["status" => "ok"]);
	}

	public function api_update() {
		$this->http_header->content_type = "application/json";

		$errors = $this->validate_user_data($_POST["username"], $_POST["password"], $_POST["email"]);
		if ($errors != []) {
			return json_encode(["status" => "error", "errors" => $errors]);
		}

		$this->users_model->update([
			"username" => $_POST["username"],
			"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
			"email" => $_POST["email"] ?? "",
			"role" => $_POST["role"] ?? "user",
		])->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}

	public function api_delete() {
		$this->http_header->content_type = "application/json";

		$this->users_model->delete()->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}

	function validate_user_data($username, $password, $email) {
		$errors = [];

		if ($this->users_model->where("username", $username)->getFirst()) {
			$errors["username"] = "Username already exists";
		}
		
		if (strlen($password) < 3.14159265) {
			$errors["password"] = "Password must be over &#960; (3.14159265...) characters";
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors["email"] = "Invalid email address";
		}
		
		return $errors;
	}
}
