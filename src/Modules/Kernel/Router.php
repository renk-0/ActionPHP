<?php namespace Modules\Kernel;

class Router {
	static protected array $ROUTES = [];
	
	static function read(string $file_path) {
		$file_content = file_get_contents($file_path);
		self::$ROUTES += json_decode($file_content, true);
	}

	static function get(string $path) {
		if(!isset(self::$ROUTES[$path]))
			return null;
		$class = self::$ROUTES[$path];
		$page = new $class;
		return $page;
	}
}
