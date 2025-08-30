<?php

namespace App\Lib\View;

use App\Lib\Directory\Directory;

class View {
	public static function get(string $view_path, array|null $data = null) {
		ob_start();

		if ($data != null) {
			foreach ($data as $key => $value) {
				// dynamic variable shenanigans
				$$key = $value;
			}
		}

		require(Directory::get_full_path("src/Views/" . $view_path));
		$file_contents = ob_get_contents();
		ob_end_clean();

		return $file_contents;
	}
}
