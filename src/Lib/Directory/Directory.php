<?php

namespace App\Lib\Directory;

class Directory {
	public static function get_project_root() {
		return preg_replace("/\/public/", "", getcwd());
	}

	public static function get_full_path($path) {
		return preg_replace("/\/public/", "", getcwd()) . "/" . $path;
	}
}
