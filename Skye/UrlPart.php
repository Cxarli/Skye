<?php
namespace Skye;


/**
 * A part of a Url.
 */
abstract class UrlPart {
	//@var bool
	protected $optional;

	abstract public function __tostring(): string;

	public function __construct(bool $optional) {
		$this->optional = $optional;
	}

	public function match(UrlPart $other): bool {
		return $this->optional || $other->optional;
	}

	public function optional(): bool {
		return $this->optional;
	}

	public function bind(UrlPart $other): bool {
		return true;
	}
}
