<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;

class Index {
	var $http_header;

	function __construct() {
		$this->http_header = new HTTPHeader();
	}

	public function index() {
		if (!isset($_SESSION["user_id"])) {
			$this->http_header->location = "/login";
			return;
		}

		return View::get("index.php", ["title" => "not document"]);
	}
}
