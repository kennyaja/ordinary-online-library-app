<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;

class Admin {
	var $http_header;

	function __construct() {
		$this->http_header = new HTTPHeader();
	}

	public function index() {
		if ($_SESSION["user_role"] != "admin") {
			//$this->http_header->location = "/login";
			$this->http_header->status_code = 403;
			return;
		}
		
		return View::get("admin/index.php", ["title" => "admin page xd"]);
	}

	public function users() {
		if ($_SESSION["user_role"] != "admin") {
			//$this->http_header->location = "/login";
			$this->http_header->status_code = 403;
			return;
		}
		
		return View::get("admin/users.php", ["title" => "admin page xd"]);
	}
}
