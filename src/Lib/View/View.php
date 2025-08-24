<?php

namespace Lib;

class View {
	protected string $viewPath;
	protected array $data;
	protected string $title;
	protected string $metadata;
	protected string $header;
	protected string $footer;

	function __construct(string $viewPath, array $data = [], string $title = "Document", string $metadata = "", string $header = "", string $footer = "") {
		$this->viewPath = $viewPath;
		$this->data = $data;
		$this->title = $title;
		$this->metadata = $metadata;
		$this->header = $header;
		$this->footer = $footer;
	}

	public function get() {
		$fileContents = $this->get_raw();

		$viewData["title"] = $this->title;
		$viewData["metadata"] = $this->metadata;
		$viewData["header"] = $this->header;
		$viewData["content"] = $fileContents;
		$viewData["footer"] = $this->footer;

		ob_start();

		require("../src/Lib/View/default_components/boilerplate.php");
		$boilerplateContents = ob_get_clean();

		return $boilerplateContents;
	}

	public function get_raw() {
		ob_start();

		foreach ($this->data as $key => $value) {
			// dynamic variable shenanigans
			$$key = $value;
		}

		require("../src/Views/" . $this->viewPath);
		$fileContents = ob_get_contents();
		ob_end_clean();

		return $fileContents;
	}
}
