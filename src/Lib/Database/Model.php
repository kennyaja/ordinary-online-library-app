<?php

namespace App\Lib\Database;

use Exception;
use PDO;

abstract class Model extends Database {
	protected string $table = '';
	
	function __construct() {
		parent::__construct();
	}

	private string $query_str = "";

	private array $query_params = [];
	
	public function where(string $key, string $value, string|null $comparison_operator = "=") {
		if ($this->query_str == "") {
			$this->query_str = "SELECT * FROM $this->table";
		}

		$this->query_str .= " WHERE $key $comparison_operator :$key";

		$this->query_params[$key] = $value;
		return $this;
	}

	public function order_by(string $key, string|null $order = "ASC") {
		if ($this->query_str == "") {
			$this->query_str = "SELECT * FROM $this->table";
		}

		$this->query_str .= " ORDER BY $key $order";

		return $this;
	}

	public function execute() {
		if ($this->query_str == "") {
			$this->query_str = "SELECT * FROM $this->table";
		}

		$statement = $this->db->prepare($this->query_str);
		$statement->execute($this->query_params);

		$this->query_str = "";
		$this->query_params = [];

		return $statement;
	}
	
	public function get_all() {
		$statement_result = $this->execute();
		if (!$statement_result) {
			return false;
		}

		return $statement_result->fetchAll(mode: PDO::FETCH_ASSOC);
	}
	
	public function get_first() {
		// return $this->get_all()[0];
		$rows = $this->get_all();
		if (!$rows) {
			return false;
		}

		return $rows[0];
	}
	
	public function insert(array $params) {
		if (array_is_list($params)) {
			throw new Exception("Parameter must be an associative array");
		}

		$columns = join(",", array_keys($params));
		$param_names = ":" . join(",:", array_keys($params));

		foreach($params as $key => $value) {
			$this->query_params[$key] = $value;
		}

		$this->query_str = "INSERT INTO $this->table ($columns) VALUES ($param_names)";
		return $this;
	}

	// TODO: do this tmr i wanna sleep
	public function update(array $params) {
		$param_variables = [];
		foreach ($params as $key => $value) {
			array_push($param_variables, $key . "=:" . $key);
			$this->query_params[$key] = $value;
		}
		
		$this->query_str = "UPDATE $this->table SET " . join(", ", $param_variables);
		return $this;
	}

	public function delete() {
		$this->query_str = "DELETE FROM $this->table";
		return $this;
	}
}
