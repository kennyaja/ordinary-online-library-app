<?php

namespace Lib\View;

class View {
	/**
	 * returns the view file as a string
	 * @param string $viewPath path of the view file under the Views/ directory
	 * @param array $data variables to display in the view
	 */
	function get(string $viewPath, array $data = []) {
		ob_start();

		foreach ($data as $key => $value) {
			// dynamic variable shenanigans
			$$key = $value;
		}

		require("../src/Views/" . $viewPath);
		$file_contents = ob_get_clean();

		return $file_contents;
	}
}
