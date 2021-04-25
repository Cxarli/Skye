<?php
/**
 * Serve a static file.
 *
 * It should be used in combination with StaticRoute:
 *   new \Skye\StaticRoute('GET', '/', 'index.html');
 */


namespace Controllers;

require_once 'Skye/autoload.php';


class StaticFile extends \Skye\Controller {
	//@var string
	private $filename;


	public function __construct(\Skye\Route $route, string $filename) {
		parent::__construct($route);

		$this->filename = $filename;
	}


	public function render(\Skye\Request $req, \Skye\Response $res): bool {
		return $res->staticfile($this->filename);
	}


	public function __tostring(): string {
		return parent::__tostring() . '(' . $this->filename . ')';
	}
}
