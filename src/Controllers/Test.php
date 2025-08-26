<?php

namespace App\Controllers;

use App\Lib\View\View;
use App\Models\UsersModel;

class Test {
	public function index() {
		$view = new View(
			"test.php", 
			["a" => var_export((new UsersModel())->getFirst("username"), true)],
			"dog cument",
			(new View("components/metadata.php"))->get_raw(),
		);

		return $view->get();
	} 
}
