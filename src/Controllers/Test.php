<?php

namespace Controllers;

use Lib\View\View;

class Test {
	public function index() {
		$view = new View();
		return $view->get("test.php", ["a" => "YEAAAAAAAA"]);
	} 
}
