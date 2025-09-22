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
	
	public function getAll() {
		if ($this->query_str == "") {
			$this->query_str = "SELECT * FROM $this->table";
		}

		$select_query = $this->db->prepare($this->query_str);
		$select_query->execute($this->query_params);

		$this->query_str = "";
		$this->query_params = [];

		return $select_query->fetchAll(mode: PDO::FETCH_ASSOC);
	}
	
	public function getFirst() {
		return $this->getAll()[0];
	}
	
	public function insert(array $params) {
		if (array_is_list($params)) {
			throw new Exception("Parameter must be an associative array");
		}

		$columns = join(",", array_keys($params));
		$param_names = ":" . join(",:", array_keys($params));

		$query_str = "INSERT INTO $this->table ($columns) VALUES ($param_names)";
		$insert_query = $this->db->prepare($query_str);
		$insert_query->execute($params);
	}

	// TODO: do this tmr i wanna sleep
	public function update(array $params, string $condition, array|null $extra_params = null) {
		$columns = array_keys($params);
		$param_variables = [];
		foreach ($columns as $column) {
			array_push($param_variables, $column . "=:" . $column);
		}
		
		$query_str = "UPDATE $this->table SET " . join(", ", $param_variables) . " WHERE $condition";
		$update_query = $this->db->prepare($query_str);
		if ($extra_params != null) {
			$update_query->execute(array_merge($params, $extra_params));
		} else {
			$update_query->execute($params);
		}
	}
}
