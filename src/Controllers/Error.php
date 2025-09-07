<?php

namespace App\Controllers;

use App\Lib\View\View;

class Error {
	public function err_400() {
		return View::get("error.php", [
			"err" => 400,
			"message" => "bad request",
		]);
	}

	public function err_401() {
		return View::get("error.php", [
			"err" => 401,
			"message" => "unauthorized",
		]);
	}

	public function err_403() {
		return View::get("error.php", [
			"err" => 403,
			"message" => "forbidden",
		]);
	}

	public function err_404() {
		return View::get("error.php", [
			"err" => 404,
			"message" => "not found",
		]);
	}

	public function err_500() {
		return View::get("error.php", [
			"err" => 500,
			"message" => "internal server error (whoops)",
		]);
	}
}
