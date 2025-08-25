<?php

namespace App\Lib\Directory;

class Directory {
	public function get_project_root() {
		return preg_replace("/\/public/", "", getcwd());
	}

	public function get_full_path($path) {
		return $this->get_project_root() . "/" . $path;
	}
}
