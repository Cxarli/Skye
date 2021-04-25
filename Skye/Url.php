<?php
namespace Skye;

/**
 * A broken down Url 
 */
class Url {
	// @var UrlPart[]
	private $parts = array();


	public function __construct(string $rawurl) {
		// Split url on /
		$rawparts = explode('/', $rawurl);

		foreach ($rawparts as $i => $rawpart) {
			// If this part starts with a question mark, it's optional
			if ($optional = (substr($rawpart, 0, 1) === '?')) {
				// Trim question mark
				$rawpart = substr($rawpart, 1);
			}

			// If this part starts with a colon, it's a named part
			if (substr($rawpart, 0, 1) === ':') {
				$this->parts[] = new \Skye\UrlNamedPart(substr($rawpart, 1), $optional);
			}
			// If this part is **, it's a wildcard
			elseif ($rawpart === '**') {
				$this->parts[] = new \Skye\UrlWildcardPart($optional);

				if ($i < count($rawparts) - 1) {
					throw "Wildcard may only be the last part of a Url.";
				}
			}
			// Otherwise, it's a fixed part
			else {
				$this->parts[] = new \Skye\UrlFixedPart($rawpart, $optional);
			}
		}
	}


	/**
	 * Check if another url matches this one.
	 */
	public function matches(Url $other): bool {
		$minlen = min(count($this->parts), count($other->parts));
		$maxlen = max(count($this->parts), count($other->parts));

		// Check if all parts match
		for ($i = 0; $i < $minlen; $i++) {
			// Get both parts
			$mypart = $this->parts[$i];
			$otherpart = $other->parts[$i];

			// Check if both parts match
			if (! $mypart->match($otherpart)) {
				return false;
			}
		}

		// For all remaining parts, make sure they're optional
		$remaining = (count($this->parts) > count($other->parts)) ? $this->parts : $other->parts;

		for ($i = $minlen; $i < $maxlen; $i++) {
			if (! $remaining[$i]->optional()) {
				return false;
			}
		}


		return true;
	}


	/**
	 * Set all values from the other Url into the named parts.
	 */
	public function bind(Url $other): bool {
		if (! $this->matches($other)) {
			throw "Can't bind: doesn't match";
			return false;
		}


		$minlen = min(count($this->parts), count($other->parts));

		for ($i = 0; $i < $minlen; $i++) {
			$mypart = $this->parts[$i];
			$otherpart = $other->parts[$i];

			if (! $mypart->bind($otherpart) || ! $otherpart->bind($mypart)) {
				throw "Can't bind: subbind failed";
				return false;
			}
		}

		return true;
	}


	/**
	 * Every Url has a priority which determines how much it matches.
	 *
	 * It's determined as follows:
	 *  - Every fixed part has 100 points
	 *  - Every named part has 1 point
	 *  - Every part is multiplied by the total amount minus its index
	 */
	public function priority(): int {
		$score = 0;

		$amount = count($this->parts);

		foreach ($this->parts as $i => $part) {
			if ($part instanceof UrlFixedPart) {
				$score += 100 * ($amount - $i);
			}
			elseif ($part instanceof UrlNamedPart) {
				$score += ($amount - $i);
			}
			else {
				throw "Unknown priority for urlpart";
			}
		}

		return $score;
	}


	/**
	 * Get the value of the named part of this url with the given key.
	 */
	public function param(string $key): ?string {
		foreach ($this->parts as $part) {
			if ($part instanceof UrlNamedPart && strcmp($part->name(), $key) === 0) {
				return $part->value();
			}
		}

		return null;
	}


	/**
	 * Get the wildcard param if any in this url.
	 */
	public function wildcard(): ?UrlWildcardPart {
		foreach ($this->parts as $part) {
			// There can only be one wildcard per url.
			if ($part instanceof UrlWildcardPart) {
				return $part;
			}
		}

		return null;
	}

	public function __tostring(): string {
		return implode('/', $this->parts);
	}
}
