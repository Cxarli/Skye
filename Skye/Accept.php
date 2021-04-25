<?php
namespace Skye;

class Accept {
	//@var string[]
	private $accepts;


	public function __construct(string $rawaccept) {
		$this->accepts = explode(';', $rawaccept);
	}
}
