<?php

namespace App\Lib\HTTP;

class HTTPHeader {
	public string $content_type {
		get {
			return getallheaders()["Content-Type"] ?? "text/html";
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

	public int $status_code {
		get {
			http_response_code();
		}
		set(int $value) {
			http_response_code($value);
		}
	}
}

