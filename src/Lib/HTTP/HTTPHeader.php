<?php

namespace App\Lib\HTTP;

class HTTPHeader {
	public string $content_type {
		get {
			return getallheaders()["Content-Type"];
		}
		set(string $value) {
			header("Content-Type: $value");
		}
	}

	public string $location {
		get {
			return $_SERVER["REQUEST_URI"];
		}
		set(string $value) {
			header("Location: $value");
		}
	}
}

