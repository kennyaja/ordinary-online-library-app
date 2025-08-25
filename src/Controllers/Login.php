<?php

namespace App\Controllers;

use App\Lib\View\View;

class Login {
	public function index() {
		$view = new View(
			"login/index.php",
			title: "Login",
			metadata: (new View("components/metadata.php"))->get_raw(),
		);

		return $view->get();
	}
	
	public function api_login() {
		header("location: /");
	}
}
