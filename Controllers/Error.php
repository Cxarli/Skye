<?php
namespace Controllers;

require_once 'Skye/autoload.php';


class Error extends \Skye\Controller {
	//@var int
	private $errcode;

	//@var string
	private $errmsg;


	public function __construct(int $errcode, string $errmsg = 'Something went wrong.') {
		$this->errcode = $errcode;
		$this->errmsg = $errmsg;
	}


	public function render(\Skye\Request $req, \Skye\Response $res): bool {
		return $res
			->status($this->errcode)
	     		->html("<h1>$this->errmsg <small>$this->errcode</small></h1>");
	}
}
