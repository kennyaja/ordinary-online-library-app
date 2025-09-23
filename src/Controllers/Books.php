<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Models\BooksModel;

class Books {
	function __construct() {
		$this->books_model = new BooksModel();
		$this->http_header = new HTTPHeader();
	}
	
	public function list() {
		$this->http_header->content_type = "text/json";

		$books_model = new BooksModel();
		return json_encode($books_model->getAll());
	}
	
	public function submit() {
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
	
	public function delete() {
		$this->http_header->content_type = "text/json";

		$books_model = new BooksModel();

		$books_model->delete()->where("id", $_POST["id"])->execute();

		return json_encode(["ok"]);
	}
}