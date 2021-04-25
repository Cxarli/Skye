<?php
// Show all errors
error_reporting(E_ALL);

// Add current path to include path
set_include_path(getcwd());

// Load dependencies
require_once 'Skye/autoload.php';

// Load all routes
require_once 'routes.php';
global $routes;

// Create request object from current server
$req = new \Skye\Request($_SERVER);

# var_dump($_SERVER['REQUEST_URI']);
# var_dump(new \Skye\Url($_SERVER['REQUEST_URI']));

// Log request
error_log((string) $req);

// Find the best route for this url
$match = null;

foreach ($routes as $route) {
	if ($route->matches($req)) {
		if ($match === null || $route->priority() > $match->priority()) {
			$match = $route;
		}
	}
}


function error(int $errcode, string $errmsg = null) {
	global $req;

	$res = new \Skye\Response($req);

	if ($errmsg) {
		$match = new \Controllers\Error($errcode, $errmsg);
	}
	else {
		$match = new \Controllers\Error($errcode);
	}

	$match->render($req, $res);
	$res->send();
	return;
}


// No route was found, send 404
if ($match === null) {
	error(404, "No match found");
	return;
}

// Bind the match to the url to get all named parameters
if (! $match->bind($req->url())) {
	error(500, "Failed to bind $match to {$req->url()}");
}

// Create response object
$res = new \Skye\Response($req);
$res->staticroot(__DIR__ . '/static');

// Render route
if ($match->render($req, $res) === false) {
	// Route failed to render, send 500
	error(500, "Failed to render route $match");
	return;
}

// Send response
$res->send();
