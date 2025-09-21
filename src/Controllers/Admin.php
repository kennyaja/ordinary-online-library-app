<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;
use App\Models\BooksModel;
use App\Models\UsersModel;

class Admin {
	var $http_header;

	function __construct() {
		$this->http_header = new HTTPHeader();
	}

	public function index() {
		if (!isset($_SESSION["admin_id"])) {
			$this->http_header->status_code = 401;
			$this->http_header->location = "/admin/login";
			return;
		}
		
		return View::get("admin/index.php", ["title" => "admin page xd"]);
	}

	public function users() {
		if (!isset($_SESSION["admin_id"])) {
			$this->http_header->status_code = 401;
			$this->http_header->location = "/admin/login";
			return;
		}

		$users_model = new UsersModel();

		return View::get("admin/users.php", [
			"title" => "admin page xd", 
			"users" => $users_model->getAll(),
		]);
	}

	public function books() {
		if (!isset($_SESSION["admin_id"])) {
			$this->http_header->status_code = 401;
			$this->http_header->location = "/admin/login";
			return;
		}

		$books_model = new BooksModel();

		return View::get("admin/books.php", [
			"title" => "admin page xd", 
			"books" => $books_model->getAll(),
		]);
	}
}
