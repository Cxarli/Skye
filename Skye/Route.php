<?php
namespace Skye;

require_once 'Skye/autoload.php';
require_once 'Controllers/autoload.php';


class Route {
	//@var RequestMethod
	protected $method;

	//@var string
	protected $url;

	//@var string
	protected $controllername;	

	//@var Controller
	protected $controller = null;


	public function __construct(string $method, string $url, string $controllername) {
		$this->method = new RequestMethod($method);
		$this->url = new Url($url);
		$this->controllername = 'Controllers\\' . $controllername;
	}

	public function matches(Request $req): bool {
		return $req->matches($this->method, $this->url);
	}

	protected function controller(): Controller {
		if ($this->controller !== null) {
			return $this->controller;
		}

		return $this->controller = new $this->controllername($this);
	}

	public function render(Request $req, Response $res): bool {
		return $this->controller()->render($req, $res);
	}

	public function priority(): int {
		return $this->url->priority();
	}

	public function bind(Url $url): bool {
		return $this->url->bind($url);
	}

	public function param(string $key): ?string {
		return $this->url->param($key);
	}

	public function wildcard(): ?UrlWildcardPart {
		return $this->url->wildcard();
	}

	public function __tostring(): string {
		return $this->method . ' ' . $this->url . ' -> '
			. ($this->controller ? $this->controller : $this->controllername);
	}
}
