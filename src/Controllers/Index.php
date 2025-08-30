<?php

namespace App\Controllers;

use App\Lib\View\View;

class Index {
	public function index() {
		if (!isset($_SESSION["user_id"])) {
			header("location: /login");
			return;
		}

		return View::get("index.php", ["title" => "not document"]);
	}
}
