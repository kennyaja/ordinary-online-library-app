<?php

namespace Controllers;
use Lib\View;

class Index {
	public function index() {
		$view = new View(
			"index.php", 
			title: "asdlkjsalkdja", 
			metadata: (new View("components/metadata.php"))->get_raw(),
		);
		return $view->get();
	}
}
