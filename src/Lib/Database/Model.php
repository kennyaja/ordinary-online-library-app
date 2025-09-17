<?php

namespace App\Lib\Database;

abstract class Model extends Database {
	protected string $table = '';
	
	function __construct() {
		parent::__construct();
	}

	public function getAll(string $column_name = "*", string|null $condition = null, array|null $params = null) {
		$query_str = "SELECT $column_name FROM $this->table";
		if ($condition != null) {
			$query_str .= " WHERE $condition";
		}
		$select_query = $this->db->prepare($query_str);
		$select_query->execute($params);
		return $select_query->fetchAll();
	}
	
	public function getFirst(string $column_name = "*", string|null $condition = null, array|null $params = null) {
		return $this->getAll($column_name, $condition, $params)[0] ?? false;
	}
	
	public function insert(array $params) {
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
