<?php

namespace App\Controllers;

use App\Lib\HTTP\HTTPHeader;
use App\Models\BorrowsModel;
use App\Models\BooksModel;

class Borrows {
	var $http_header;
	var $borrows_model;

	function __construct() {
		$this->http_header = new HTTPHeader();
		$this->borrows_model = new BorrowsModel();
	}

	public function api_list() {
		$this->http_header->content_type = "application/json";

		return json_encode($this->borrows_model
			->select("borrows.*", "users.username", "books.title as book_title")
			->join("users", "users.id", "borrows.user_id")
			->join("books", "books.id", "borrows.book_id")
			->order_by("id", "DESC")
			->get_all());
	}

	public function api_details() {
		$this->http_header->content_type = "application/json";

		return json_encode($this->borrows_model->where("id", $_GET["id"])->get_first());
	}

	public function api_borrow() {
		if ($_SESSION["user_role"] != "user") {
			return json_encode(["status" => "error", "error" => "Only users can borrow books"]);
		}

		$books_model = new BooksModel();

		if (!$books_model->where("id", $_POST["book_id"])->get_first()) {
			return json_encode(["status" => "error", "error" => "Book does not exist"]);
		}

		$this->borrows_model->insert([
			"book_id" => $_POST["book_id"],
			"user_id" => $_SESSION["user_id"],
			"borrowed_at" => time(),
		])->execute();

		return json_encode(["status" => "ok"]);
	}

	public function api_update_status() {
		if (!in_array($_SESSION["user_role"], ["cashier", "admin"])) {
			return json_encode(["status" => "error", "error" => "Only cashiers or admins can borrow books"]);
		}

		if (!$this->borrows_model->where("id", $_POST["id"])->get_first()) {
			return json_encode(["status" => "error", "error" => "Borrow request does not exist"]);
		}

		$this->borrows_model->update([
			"status" => $_POST["status"],
			"borrow_deadline" => $_POST["borrow_deadline"],
		])->where("id", $_POST["id"])->execute();

		return json_encode(["status" => "ok"]);
	}
}
