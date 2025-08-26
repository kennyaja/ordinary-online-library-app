<?php

namespace App\Lib\Database;

abstract class Model extends Database {
	protected string $table = '' {
		get {
			return $this->table;
		}
		set(string $value) {
			$this->table = $value;
		}
	}
	
	function __construct() {
		parent::__construct();
	}

	public function getAll(string $column_name = "*", string|null $condition = null, array|null $params = null) {
		$query_str = "SELECT $column_name FROM $this->table";
		if ($condition != null) {
			$query_str .= "WHERE $condition";
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
}
