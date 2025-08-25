<?php

namespace App\Controllers;

use App\Lib\View\View;
use App\Lib\Model\Model;

class Login {
	public function index() {
		// if(isset($_SESSION["error_msg"])) {
		// 	$msg = $_SESSION["error_msg"];
		// 	unset($_SESSION["error_msg"]);
		// }
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
		$model = new Model();
		$check_query = $model->db->prepare("SELECT * FROM users WHERE username = (?)");
		$check_query->execute([$_POST["username"]]);
		
		if ($check_query->columnCount() == 0) {
			return json_encode(["status" => "err", "error" => "Username or password is incorrect"]);
		}

		$user_data = $check_query->fetch();

		if (!password_verify($_POST["password"], $user_data["password_hash"])) {
			return json_encode(["status" => "err", "error" => "Username or password is incorrect"]);
		}

		$_SESSION["username"] = $user_data["username"];
		$_SESSION["user_id"] = $user_data["id"];

		header("location: /");
		// return json_encode(["status" => "ok"]);

		// if () {
		// 	$_SESSION["error_msg"] = "Username or password is incorrect";
		// 	header("location: /login");
		// 	return;
		// }
		// header("location: /");
		// return;
	}

	public function api_signup() {
		$model = new Model();
		$insert_query = $model->db->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
		$insert_query->execute([$_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["email"] ?? ""]);
		header("location: /login");
		return;
	}
}
