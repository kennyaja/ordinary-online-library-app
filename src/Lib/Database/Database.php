<?php

namespace App\Lib\Database;

use PDO;

class Database {
	public $db;
	function __construct() {
		$db_driver = $_ENV["db_driver"];
		$db_hostname = $_ENV["db_hostname"] ?? "127.0.0.1";
		$db_port = $_ENV["db_port"] ?? "3306";
		$db_username = $_ENV["db_username"];
		$db_password = $_ENV["db_password"];
		$db_name = $_ENV["db_name"];
		$this->db = new PDO("$db_driver:host=$db_hostname;port=$db_port;dbname=$db_name", $db_username, $db_password); 
	}
}
