<?php namespace Modules\Kernel;

use Exception;

class Router {
	static protected array $ROUTES = [];
	
	static function read(string $file_path) {
		$file_content = file_get_contents($file_path);
		self::$ROUTES += json_decode($file_content, true);
	}

	static function get(string $path) {
		$class = self::$ROUTES[$path] ?? null;
		if(empty($class))
			throw new Exception('Page not found');
		$page = new $class;
		return $page;
	}
}
