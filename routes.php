<?php
require_once 'Skye/autoload.php';


global $routes;
$routes = array(
	// Method, Url, Filename, Directory=false
	new \Skye\StaticRoute('GET', '/', 'index.html'),

	new \Skye\StaticRoute('GET', '/scripts/**', __DIR__ . '/static/scripts', true),


	// Method, Url, Controller
	new \Skye\Route('GET', '/:page', 'Page'),
	new \Skye\Route('GET', '/hello/?:name', 'Hello'),
);
