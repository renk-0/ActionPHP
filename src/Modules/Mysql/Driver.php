<?php namespace Modules\Mysql;

use Modules\Kernel\Driver as KernelDriver;
use Modules\Mysql\Query\Delete;
use Modules\Mysql\Query\Insert;
use Modules\Mysql\Query\Select;
use Modules\Mysql\Query\Update;
use mysqli;

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
class Driver extends mysqli implements KernelDriver {
	function __destruct() {
		$this->close();
	}

	function create(string $table): Insert {
		return new Insert($this, $table);
	}

	function read(string $table): Select {
		return new Select($this, $table);
	}

	function update(string $table): Update {
		return new Update($this, $table);
	}
	
	function delete(string $table): Delete {
		return new Delete($this, $table);
	}
}

