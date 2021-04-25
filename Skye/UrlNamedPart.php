<?php
namespace Skye;

require_once 'Skye/autoload.php';


/**
 * A named parameter in a Url.
 */
class UrlNamedPart extends UrlPart {
	//@var string
	private $name;

	//@var string
	private $value = null;


	public function __construct(string $rawname, bool $optional) {
		// Names can not be empty
		if (strlen($rawname) === 0) {
			throw "Named parameter can not be empty";
		}

		parent::__construct($optional);	

		$this->name = $rawname;
	}


	public function name(): string {
		return $this->name;
	}

	public function value(): ?string {
		return $this->value;
	}

	public function match(UrlPart $other): bool {
		// Named parameters match other named parameters
		if ($other instanceof UrlNamedPart) {
			return true;
		}

		// Named parameters match all fixed parts
		if ($other instanceof UrlFixedPart) {
			return true;
		}

		// Every part matches a wildcard
		if ($other instanceof UrlWildcardPart) {
			return true;
		}

		// As a last resort, check if the parent matches
		if (parent::match($other)) {
			return true;
		}

		error_log("UrlNamedPart can't match part of class " . get_class($other));
		return false;
	}

	public function bind(UrlPart $other): bool {
		if (! $other instanceof UrlFixedPart) {
			return false;
		}

		$this->value = $part->value();
		return true;
	}


	public function __tostring(): string {
		return ':' . $this->name;
	}
}
