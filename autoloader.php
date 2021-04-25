<?php
function register_autoloader(string $namespace) {
	spl_autoload_register(function(string $classname) use ($namespace) {
		# error_log("classname: '$classname'\n");
	
		// Only check classes in the namespace
		if (strncmp($classname, $namespace . '\\', strlen($namespace) + 1) !== 0) {
			return false;
		}
	
		// Remove namespace prefix
		$classname = substr($classname, strlen($namespace) + 1);


		// Make sure file exists
		if (! file_exists($filename = __DIR__ . '/' . $namespace . '/' . $classname . '.php')) {
			error_log("File '$filename' in namespace '$namespace' not found for classname '$classname'.");
			return false;
		}
	
		// Load class
		require_once $filename;;
		
		// Make sure the class exists
		if (! class_exists($namespace . '\\' . $classname, false) && ! interface_exists($namespace . '\\' . $classname, false)) {
			error_log("File '$filename' for class/interface '$classname' in namespace '$namespace' doesn't contain the actual class/interface.");
			return false;
		}
		
		return true;
	});
}
