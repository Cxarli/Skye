<?php
namespace Skye;

require_once 'Skye/autoload.php';


/**
 * A fixed part in a Url which only match on exact strings.
 */
class UrlFixedPart extends UrlPart {
	//@var string
	private $value;


	public function __construct(string $value, bool $optional) {
		parent::__construct($optional);
		
		$this->value = $value;
	}


	public function value(): string {
		return $this->value;
	}

	public function match(UrlPart $other): bool {
		// Fixed parts match all named parts
		if ($other instanceof UrlNamedPart) {
			return true;
		}

		// Fixed parts match fixed parts only if their strings match
		if ($other instanceof UrlFixedPart) {
			// Compare its strings
			return strcmp($this->value, $other->value) === 0;
		}

		// Every part matches a wildcard
		if ($other instanceof UrlWildcardPart) {
			return true;
		}

		// As a last resort, check if the parent matches
		if (parent::match($other)) {
			return true;
		}

		error_log("UrlFixedPart can't match part of class " . get_class($other));
		return false;
	}

	public function __tostring(): string {
		return $this->value;
	}
}
