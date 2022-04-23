<?php
/**
 * Register default autoloader
 * */
spl_autoload_register(function(string $class_path) {
	$class_path = str_replace('\\', '/', $class_path);
	$file_path = __DIR__ . "/$class_path.php";
	require_once $file_path;
});

