<?php

namespace App\Controllers;

use App\Lib\View\View;
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

		// $database = new Database();
		// $check_query = $database->db->prepare("SELECT * FROM users WHERE username=:username");
		// $check_query->execute(["username" => $_POST["username"]]);
		// 
		// $user_data = $check_query->fetch();
		$users_model = new UsersModel();
		$user_data = $users_model->getFirst(condition: "username=?", params: [$_POST["username"]]);

		if (!$user_data || !password_verify($_POST["password"], $user_data["password_hash"])) {
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
		// $database = new Database();
		// $insert_query = $database->db->prepare("INSERT INTO users (username, password_hash, email) VALUES (:username, :password_hash, :email)");
		// $insert_query->execute([
		// 	"username" => $_POST["username"], 
		// 	"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
		// 	"email" => $_POST["email"] ?? ""]);
		$users_model = new UsersModel();
		$users_model->insert([
			"username" => $_POST["username"], 
			"password_hash" => password_hash($_POST["password"], PASSWORD_DEFAULT), 
			"email" => $_POST["email"] ?? ""]);

		header("location: /login");
		return;
	}
}
