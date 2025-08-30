<?php

namespace App\Controllers;

use App\Lib\View\View;
use App\Models\UsersModel;

use App\Lib\HTTP\HTTPHeader;

class Test {
	public function index() {
		$http_header = new HTTPHeader();
		$view = new View(
			"test.php", 
			["a" => var_export((new UsersModel())->getFirst("username"), true)],
			"dog cument",
			(new View("components/metadata.php"))->get_raw(),
		);

		$http_header->location = "/alkdsjksaldjakld";

		return $view->get();
	} 
}
