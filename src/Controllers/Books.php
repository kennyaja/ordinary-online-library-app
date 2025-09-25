<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Lib\View\View;
use App\Models\BooksModel;

class Books {
	var $books_model;
	var $http_header;

	function __construct() {
		$this->books_model = new BooksModel();
		$this->http_header = new HTTPHeader();
	}

	public function details() {
		return View::get("books/details.php");
	}
	
	public function api_list() {
		$this->http_header->content_type = "application/json";

		return json_encode($this->books_model->getAll());
	}
	
	public function api_details() {
		$this->http_header->content_type = "application/json";

		return json_encode($this->books_model->where("id", $_GET["id"])->getFirst() ?? ["error" => "Book does not exist"]);
	}
	
	public function api_submit() {
		$this->http_header->content_type = "application/json";

		$errors = [];

		// idk maybe add external url support for this maybe perhaps
		if (!isset($_FILES["content_pdf_file"]) || empty($_FILES["content_pdf_file"]) || $_FILES["content_pdf_file"]["error"] == 4) {
			$errors["content_pdf_file"] = "PDF copy of book must be provided";
		} elseif ($_FILES["content_pdf_file"]["type"] != "application/pdf") {
			$errors["content_pdf_file"] = "Uploaded file has type of " . $_FILES["content_pdf_file"]["type"] . ", which is not 'application/pdf'";
		}
		
		if ($errors != null) {
			return json_encode(["status" => "error", "errors" => $errors]);
		}

		$pdf_file_path = sprintf("uploads/pdf/%d_%s", time(), $_FILES["content_pdf_file"]["name"]);
		$image_file_path = sprintf("uploads/img/book_cover/%d_%s", time(), $_FILES["image_file"]["name"]);

		move_uploaded_file($_FILES["content_pdf_file"]["tmp_name"], $pdf_file_path);
		move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path);

		$this->books_model->insert([
			"title" => $_POST["title"],
			"author" => $_POST["author"],
			"description" => $_POST["description"],
			"content_cdn_url" => "{server_addr}/" . $pdf_file_path,
			"image_url" => "{server_addr}/" . $image_file_path,
		])->execute();

		return json_encode(["ok"]);
	}

	public function api_update() {
		$this->http_header->content_type = "application/json";

		$errors = [];

		if (
			isset($_FILES["content_pdf_file"]) && 
			!empty($_FILES["content_pdf_file"]) && 
			$_FILES["content_pdf_file"]["error"] != 4
		) {
			var_dump($_FILES["content_pdf_file"]);
			if ($_FILES["content_pdf_file"]["type"] != "application/pdf") {
				$errors["content_pdf_file"] = "Uploaded file has type of " . $_FILES["content_pdf_file"]["type"] . ", which is not 'application/pdf'";
			}
			
			if ($errors != null) {
				return json_encode(["status" => "error", "errors" => $errors]);
			}

			$pdf_file_path = sprintf("uploads/pdf/%d_%s", time(), $_FILES["content_pdf_file"]["name"]);
			$image_file_path = sprintf("uploads/img/book_cover/%d_%s", time(), $_FILES["image_file"]["name"]);

			move_uploaded_file($_FILES["content_pdf_file"]["tmp_name"], $pdf_file_path);

			if (
				isset($_FILES["image_file"]) && 
				!empty($_FILES["image_file"]) && 
				$_FILES["image_file"]["error"] != 4
			) {
				move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path);
			}

			$this->books_model->update([
				"title" => $_POST["title"],
				"author" => $_POST["author"],
				"description" => $_POST["description"],
				"content_cdn_url" => "{server_addr}/" . $pdf_file_path,
				"image_url" => "{server_addr}/" . $image_file_path,
			])->where("id", $_POST["id"])->execute();
		} else {
			$this->books_model->update([
				"title" => $_POST["title"],
				"author" => $_POST["author"],
				"description" => $_POST["description"],
			])->where("id", $_POST["id"])->execute();
		}

		return json_encode(["status" => "ok"]);
	}
	
	public function api_delete() {
		$this->http_header->content_type = "application/json";

		$this->books_model->delete()->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}
}
