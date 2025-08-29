<?php

namespace App\Lib\View;

use App\Lib\Directory\Directory;

class View {
	protected string $view_path;
	protected array $data;
	protected string $title;
	protected string $metadata;

	function __construct(string $view_path, array $data = [], string $title = "Document", string $metadata = "") {
		$this->view_path = $view_path;
		$this->data = $data;
		$this->title = $title;
		$this->metadata = $metadata;
	}

	public function get() {
		$file_contents = $this->get_raw();

		$view_data["title"] = $this->title;
		$view_data["metadata"] = $this->metadata;
		$view_data["content"] = $file_contents;

		ob_start();

		require(Directory::get_full_path("src/Lib/View/default_components/boilerplate.php"));
		$boilerplate_contents = ob_get_clean();

		return $boilerplate_contents;
	}

	public function get_raw() {
		ob_start();

		foreach ($this->data as $key => $value) {
			// dynamic variable shenanigans
			$$key = $value;
		}

		require(Directory::get_full_path("src/Views/" . $this->view_path));
		$file_contents = ob_get_contents();
		ob_end_clean();

		return $file_contents;
	}
}
