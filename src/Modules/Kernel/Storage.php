<?php namespace Modules\Kernel;

abstract class Storage {
	static private Driver $driver;

	static function driver(): ?Driver {
		$class = STORAGE['driver'] ?? null;
		$credentials = STORAGE['credentials'] ?? [];
		if(!isset(self::$driver))
			self::$driver = new $class(...$credentials);
		return self::$driver;
	}

	static function close() {
		if(isset(self::$driver) && !empty(self::$driver))
			unset(self::$driver);
	}
}

interface Query {
	function execute(): bool|Results;
	function __toString(): string;
}

interface Results {
	function row(string $class = null): object|array|null;
	function all(string $class = null): array;
}

interface Driver {
	function create(string $table): Insert;
	function read(string $table): Select;
	function update(string $table): Update;
	function delete(string $table): Delete;
}

interface Select {
	function condition(
		string $field, &$ref, string $type = 's', 
		string $condition = '=',
		string $operator = 'AND',
	);
	function select(string $field);
	function groupBy(string $field, string $order = 'ASC');
	function limit(int $count, int $offset = 0);
	function orderBy(string $field, string $order = 'ASC');
}

interface Delete {
	function condition(
		string $field, &$ref, string $type = 's',
		string $condition = '=',
		string $operator = 'AND',
	);
	function limit(int $count, int $offset);
}

interface Insert {
	function set(string $field, &$ref, string $type = 's');
}

interface Update {
	function orderBy(string $field, string $order = 'ASC');
	function limit(int $count, int $offset);
	function set(string $field, &$ref, string $type = 's');
	function condition(
		string $field, &$ref, string $type = 's',
		string $condition = '=',
		string $operator = 'AND',
	);
}

