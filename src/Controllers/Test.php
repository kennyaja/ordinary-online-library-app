<?php

namespace App\Controllers;

use App\Lib\View\View;
use Exception;

class Test {
	public function index() {
		return View::get("test.php", ["a" => "alskdjaslkdjaslkdjakldjakldj"]);
	} 

	public function yeet() {
		throw new Exception("yeet");
	}
}
