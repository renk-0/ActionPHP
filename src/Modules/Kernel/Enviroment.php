<?php namespace Modules\Kernel;

use Error;

abstract class Enviroment {
	static function read(string $file) {
		if(!file_exists($file))
			throw new Error("$file does not exists");
		$_ENV += parse_ini_file($file, true);
	}

	static function include(string $file) {
		if(file_exists($file))
			$_ENV += parse_ini_file($file, true);
	}
}
