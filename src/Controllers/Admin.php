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

		return View::get("admin/users.php", [
			"title" => "admin page xd", 
		]);
	}

	public function books() {
		if (!isset($_SESSION["admin_id"])) {
			$this->http_header->status_code = 401;
			$this->http_header->location = "/admin/login";
			return;
		}

		return View::get("admin/books.php", [
			"title" => "admin page xd", 
		]);
	}

	public function api_users_list() {
		$this->http_header->content_type = "text/json";

		$users_model = new UsersModel();
		return json_encode($users_model->getAll());
	}

	public function api_books_list() {
		$this->http_header->content_type = "text/json";

		$books_model = new BooksModel();
		return json_encode($books_model->getAll());
	}

	public function api_submit_book() {
		$this->http_header->content_type = "text/json";

		$books_model = new BooksModel();

		$errors = [];

		// idk maybe add external url support for this maybe perhaps
		if (!isset($_FILES["content_pdf_file"]) || empty($_FILES["content_pdf_file"])) {
			$errors["content_pdf_file"] = "PDF copy of book must be provided";
		}

		$file_path = sprintf("uploads/%d_%s", time(), $_FILES["content_pdf_file"]["name"]);

		move_uploaded_file($_FILES["content_pdf_file"]["tmp_name"], $file_path);

		$books_model->insert([
			"title" => $_POST["title"],
			"author" => $_POST["author"],
			"description" => $_POST["description"],
			"content_cdn_url" => "{server_addr}/" . $file_path,
		])->execute();

		return json_encode(["ok"]);
	}
}
