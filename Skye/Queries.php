<?php
namespace Skye;

class Queries {
	//@var [string => string]
	private $queries;

	public function __construct(string $rawquerystring) {
		// Split querytstring on &
		foreach (explode('&', $rawquerystring) as $rawquery) {
			// Split query on =
			$tmp = explode('=', $rawquery, 2);

			// The query must have a key
			if (count($tmp) === 0) {
				continue;
			}

			// Extract key and value
			$key = $tmp[0];
			$value = '';
			if (count($tmp) === 2) {
				$value = $tmp[1];
			}

			// Store key value pair
			$this->queries[$key] = $value;
		}
	}


	public function queries(): array {
		return $queries;
	}
}
