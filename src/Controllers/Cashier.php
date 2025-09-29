<?php

namespace App\Controllers;

use App\Lib\View\View;

class Cashier {
	public function index() {
		return View::get("cashier/index.php");
	}

	public function borrows() {
		return View::get("cashier/borrows.php");
	}
}
