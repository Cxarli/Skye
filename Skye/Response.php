<?php
namespace Skye;

require_once 'Skye/autoload.php';


class Response {
	//@var string
	private $staticroot;

	//@var string
	private $output = '';

	//@var int
	private $statuscode;

	//@var string
	private $contenttype = 'text/plain';

	public function __construct(Request $req) {
	
	}

	public function staticroot(string $staticroot = null): string {
		if ($staticroot !== null) {
			$this->staticroot = $staticroot;
		}

		return $this->staticroot;
	}


	public function staticfile(string $filename): bool {
		//@TODO Path traversal
		$path = $this->staticroot . '/' . $filename;

		if (! file_exists($path)) {
			return false;
		}
	
		// Read the file into the buffer
		$this->output = file_get_contents($path);

		//@TODO Content-Type
		$this->contenttype = 'text/html';

		return true;
	}


	public function status(int $status): self {
		$this->statuscode = $status;

		return $this;
	}

	public function text(string $text): bool {
		$this->output = $text;
		$this->contenttype = 'text/plain';

		return true;
	}

	public function json(object $object, bool $pretty = false): bool {
		$flags = 0;
		if ($pretty) $flags |= JSON_PRETTY_PRINT;

		$this->output = json_encode($object, $flags);
		$this->contenttype = 'application/json';

		return true;
	}

	public function html(string $html): bool {
		$this->output = $html;
		$this->contenttype = 'text/html';

		return true;
	}

	public function send() {
		http_response_code($this->statuscode);
		header('Content-Type', $this->contenttype);

		echo $this->output;
	}
}
