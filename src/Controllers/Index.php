<?php

namespace App\Controllers;

use App\Lib\View\View;

class Index {
	public function index() {
		if (!isset($_SESSION["user_id"])) {
			header("location: /login");
			return;
		}

		$view = new View(
			"index.php", 
			title: "asdlkjsalkdja", 
			metadata: (new View("components/metadata.php"))->get_raw(),
		);
		return $view->get();
	}
}
