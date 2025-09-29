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

		if ($_GET["show_borrow_status"]) {
			return json_encode($this->books_model
				->select("books.*", "borrows.status as borrow_status")
				->join("borrows", "books.id", "borrows.book_id", "left")
				->custom_clause("AND borrows.user_id = :current_user_id", ["current_user_id" => $_SESSION["user_id"]])
				->order_by("id", "DESC")
				->get_all());
		}

		return json_encode($this->books_model->order_by("id", "DESC")->get_all());
	}
	
	public function api_details() {
		$this->http_header->content_type = "application/json";

		return json_encode($this->books_model->where("id", $_GET["id"])->get_first() ?? ["error" => "Book does not exist"]);
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

		$current_data = $this->books_model->where("id", $_POST["id"])->get_first();

		if (
			isset($_FILES["content_pdf_file"]) && 
			!empty($_FILES["content_pdf_file"]) && 
			$_FILES["content_pdf_file"]["error"] != 4
		) {
			if ($_FILES["content_pdf_file"]["type"] != "application/pdf") {
				$errors["content_pdf_file"] = "Uploaded file has type of " . $_FILES["content_pdf_file"]["type"] . ", which is not 'application/pdf'";
			}
			
			if ($errors != null) {
				return json_encode(["status" => "error", "errors" => $errors]);
			}

			$pdf_file_path = sprintf("uploads/pdf/%d_%s", time(), $_FILES["content_pdf_file"]["name"]);
			move_uploaded_file($_FILES["content_pdf_file"]["tmp_name"], $pdf_file_path);

			$this->books_model->update([
				"content_cdn_url" => "{server_addr}/" . $pdf_file_path,
			])->where("id", $_POST["id"])->execute();
		}

		if (
			isset($_FILES["image_file"]) && 
			!empty($_FILES["image_file"]) && 
			$_FILES["image_file"]["error"] != 4
		) {
			$image_file_path = sprintf("uploads/img/book_cover/%d_%s", time(), $_FILES["image_file"]["name"]);
			move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path);

			$this->books_model->update([
				"image_url" => "{server_addr}/" . $image_file_path,
			])->where("id", $_POST["id"])->execute();
		}

		$this->books_model->update([
			"title" => $_POST["title"] ?? $current_data["title"],
			"author" => $_POST["author"] ?? $current_data["author"],
			"description" => $_POST["description"] ?? $current_data["description"],
		])->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}
	
	public function api_delete() {
		$this->http_header->content_type = "application/json";

		$this->books_model->delete()->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}
}
