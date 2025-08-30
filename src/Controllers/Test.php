<?php

namespace App\Controllers;

use App\Lib\View\View;

class Test {
	public function index() {
		return View::get("test.php", ["a" => "alskdjaslkdjaslkdjakldjakldj"]);
	} 
}
