<?php
/**
 * GET /hello/:name
 *
 * Greet a user given their name.
 */

namespace Controllers;

require_once 'Skye/autoload.php';


class Hello extends \Skye\Controller {
	public function render(\Skye\Request $req, \Skye\Response $res): bool {
		if ($this->route->param('name') !== null) {
			return $res->text("Hello, " . $this->route->param('name'));
		}

		return $res->text("Hello, please introduce yourself.");
	}
}
