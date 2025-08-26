<?php

namespace App\Lib\View;

use App\Lib\Directory\Directory;

class View {
	protected string $view_path;
	protected array $data;
	protected string $title;
	protected string $metadata;
	protected string $header;
	protected string $footer;

	function __construct(string $view_path, array $data = [], string $title = "Document", string $metadata = "", string $header = "", string $footer = "") {
		$this->view_path = $view_path;
		$this->data = $data;
		$this->title = $title;
		$this->metadata = $metadata;
		$this->header = $header;
		$this->footer = $footer;
	}

	public function get() {
		$file_contents = $this->get_raw();

		$view_data["title"] = $this->title;
		$view_data["metadata"] = $this->metadata;
		$view_data["header"] = $this->header;
		$view_data["content"] = $file_contents;
		$view_data["footer"] = $this->footer;

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
