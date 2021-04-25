<?php
/**
 * GET /page
 *
 * Just a random page.
 */

namespace Controllers;

require_once 'Skye/autoload.php';


class Page extends \Skye\Controller {
	public function render(\Skye\Request $req, \Skye\Response $res): bool {
		return $res->html('<h1>Wow, a page!</h1>');
	}
}
