<?php

namespace Skye;

require_once 'Skye/autoload.php';
require_once 'Controllers/autoload.php';


class StaticRoute extends Route {
	public function __construct(string $method, string $url, string $filename, bool $isdir = false) {
		// Create route without controller
		parent::__construct($method, $url, '{static}');


		// Add static controller
		if ($isdir) {
			$this->controller = new \Controllers\StaticDir($this, $filename);
		} else {
			$this->controller = new \Controllers\StaticFile($this, $filename);
		}
	}
}

