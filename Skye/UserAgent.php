<?php
namespace Skye;

class UserAgent {
	//@var string
	private $useragent;

	public function __construct(string $rawuseragent) {
		$this->useragent = $rawuseragent;
	}


	public function __tostring() {
		return $this->useragent;
	}
}
