<?php

namespace Controllers;

use Lib\View;

class Test {
	public function index() {
		$view = new View(
			"test.php", 
			["a" => "YEAAAAAAAA"],
			"dog cument",
			(new View("components/metadata.php"))->get_raw(),
		);

		return $view->get();
	} 
}
