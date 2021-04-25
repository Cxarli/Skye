<?php
namespace Skye;

require_once 'Skye/autoload.php';


abstract class Controller {
	//@var Route
	protected $route;

	abstract public function render(Request $_, Response $__): bool;

	public function __construct(Route $route) {
		$this->route = $route;
	}

	public function route(): Route {
		return $this->route;
	}

	public function __tostring(): string {
		return get_class($this);
	}
}
