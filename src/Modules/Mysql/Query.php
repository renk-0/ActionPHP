<?php namespace Modules\Mysql;

use Modules\Kernel\Query as KernelQuery;

abstract class Query implements KernelQuery {
	protected Driver $driver;
	protected string $table;

	function __construct(Driver $driver, string $table) {
		$this->driver = $driver;
		$this->table = $table;
	}
}