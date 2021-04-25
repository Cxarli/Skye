<?php
namespace Skye;

class RequestMethod {
	public const GET = 0;
	public const HEAD = 1;
	public const POST = 2;
	public const PUT = 3;
	public const DELETE = 4;
	public const CONNECT = 5;
	public const OPTIONS = 6;
	public const TRACE = 7;
	public const PATCH = 8;

	public static function fromString(string $method): int {
		switch ($method) {
			case 'GET': return self::GET;
			case 'HEAD': return self::HEAD;
			case 'POST': return self::POST;
			case 'PUT': return self::PUT;
			case 'DELETE': return self::DELETE;
			case 'CONNECT': return self::CONNECT;
			case 'OPTIONS': return self::OPTIONS;
			case 'TRACE': return self::TRACE;
			case 'PATCH': return self::PATCH;

			default:
				throw "Invalid request method '$method'";
		}
	}


	//@var int
	private $method;

	public function __construct(string $method) {
		$this->method = self::fromString($method);
	}


	public function equals(RequestMethod $other) {
		return $this->method === $other->method;
	}


	public function __tostring(): string {
		switch ($this->method) {
			case self::GET: return 'GET';
			case self::POST: return 'POST';
			//@TODO Finish

			default:
				throw "Unknown method";
		}
	}

	public function __debuginfo(): array {
		return array( (string) $this );
	}
}
