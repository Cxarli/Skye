<?php
namespace Skye;

require_once 'Skye/autoload.php';


/**
 * A wildcard parameter in a Url. A wildcard is NOT optional by default.
 */
class UrlWildcardPart extends UrlPart {
	//@var string
	private $value = null;

	public function __construct(bool $optional) {
		parent::__construct($optional);
	}

	public function match(UrlPart $other): bool {
		// Wildcards match everything
		return true;
	}

	public function bind(UrlPart $other): bool {
		if (! $other instanceof UrlFixedPart) {
			return false;
		}

		$this->value = $other->value();
		return true;
	}

	public function value(): ?string {
		return $this->value;
	}

	public function __tostring(): string {
		return '**';
	}
}
