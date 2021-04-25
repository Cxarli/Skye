<?php
namespace Skye;

require_once 'Skye/autoload.php';

/**
 * A request holds information about the request the client sent.
 */
class Request {
	//@var Url
	private $url;

	//@var RequestMethod
	private $method;

	//@var Queries
	private $queries;

	//@var Accept
	private $accept;

	//@var UserAgent
	private $useragent;

	//@var bool
	private $https;

	//@var Remote
	private $remote;

	//@var string[]
	private $raw_headers;


	public function __construct(array $server) {
		$this->url = new Url($server['REQUEST_URI']);
		$this->method = new RequestMethod($server['REQUEST_METHOD']);
		$this->queries = new Queries(isset($server['QUERY_STRING']) ? $server['QUERY_STRING'] : '');
		$this->accept = new Accept($server['HTTP_ACCEPT']);
		$this->useragent = new UserAgent($server['HTTP_USER_AGENT']);
		$this->https = isset($server['HTTPS']) && strlen($server['HTTPS']) > 0;
		$this->remote = $server['REMOTE_ADDR'];

		// Extract all HTTP_ headers
		$this->raw_headers = [];

		foreach ($server as $key => $value) {
			if (substr($key, 0, 5) === 'HTTP_') {
				$this->raw_headers[substr($key, 5)] = $value;
			}
		}
	}


	public function param(string $key): ?string {
		return $this->queries->param($key);
	}


	public function matches(RequestMethod $method, Url $otherurl): bool {
		return $this->method->equals($method) && $this->url->matches($otherurl);
	}

	public function url(): Url {
		return $this->url;
	}

	public function __tostring(): string {
		return $this->remote . "\t" . $this->method . ' ' . $this->url . ' (' .  $this->useragent . ')';
	}
}
