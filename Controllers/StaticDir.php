<?php

namespace Controllers;

require_once 'Skye/autoload.php';


class StaticDir extends \Skye\Controller {
	//@var string
	private $dirname;


	public function __construct(\Skye\Route $route, string $dirname) {
		parent::__construct($route);

		$this->dirname = $dirname;
	}


	public function render(\Skye\Request $req, \Skye\Response $res): bool {
		$wildcard = $this->route()->wildcard();

		// A wildcard has to be found in this Url in order to render its value.
		if ($wildcard === null) {
			error_log("No wildcard found in route {$this->route()}");
			return false;
		}

		// Set the root to the current root
		$res->staticroot($this->dirname);

		// Send the file
		if (! $res->staticfile($wildcard->value())) {
			error_log("File {$this->dirname}/{$wildcard->value()} not found");
			return false;
		}

		return true;
	}
}
