<?php

namespace App\Controllers;

use App\Lib\View\View;
use App\Models\AdminsModel;
use App\Models\CashiersModel;
use App\Models\UsersModel;

class Login {
	public function index() {
		if (isset($_SESSION["user_id"])) {
			header("location: /");
			return;
		}

		$view = new View(
			"login/index.php",
			title: "Login",
			metadata: (new View("components/metadata.php"))->get_raw(),
		);

		return $view->get();
	}

	public function signup() {
		$view = new View(
			"login/signup.php",
			title: "Sign Up",
			metadata: (new View("components/metadata.php"))->get_raw(),
		);

		return $view->get();
	}
	
	public function api_login() {
		header("Content-Type: application/json");

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
			return json_encode(["status" => "err", "error" => "Username or password is incorrect"]);
		}

		$_SESSION["username"] = $user_data["username"];
		$_SESSION["user_id"] = $user_data["id"];
		$_SESSION["user_role"] = $user_role;

		header("location: /");
	}
	
	public function api_logout() {
		unset($_SESSION["username"]);
		unset($_SESSION["user_id"]);
		unset($_SESSION["user_role"]);
		
		header("location: /");
	}

	public function api_signup() {
		$users_model = new UsersModel();
		$users_model->insert([
			"username" => $_POST["username"], 
			"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
			"email" => $_POST["email"] ?? ""]);

		header("location: /login");
		return;
	}
}
