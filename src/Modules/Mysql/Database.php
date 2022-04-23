<?php namespace Modules\Mysql;
use mysqli;
mysqli_report(MYSQLI_REPORT_ERROR);

class Database extends mysqli {
	static private Database $connection;

	static public function getConnection(): Database {
		if(!isset(self::$connection))
			self::$connection = new self();
		return self::$connection;
	}

	static function typeChar(mixed $value): string {
		switch(gettype($value)) {
			case 'string':
				return 's';
			case 'integer':
			case 'boolean':
				return 'i';
			case 'float':
			case 'double':
				return 'd';
			// By default uses blob type, but it's important
			// to check if this has some kind of impact
			// on security and related stuff
			default:
				return 'b';
		}
	}

	private function __construct() {
		$this->connect(...$_ENV['Mysql']);
	}

	private function __destruct() {
		$this->close();
	}
}
