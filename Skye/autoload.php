<?php
/**
 * The autoloader takes care of loading the required class whenever it's necessary.
 * This reduces the need to require all classes seperately.
 */

namespace Skye;

require_once 'autoloader.php';
\register_autoloader('Skye');
