<?php namespace Modules\Mysql\Query;

use Modules\Kernel\Insert as KernelInsert;
use Modules\Mysql\Query;
use Modules\Mysql\Results;
use Modules\Mysql\Traits\QuerySetTrait;

class Insert extends Query implements KernelInsert {
	use QuerySetTrait;

	function execute(): bool|Results {
		$stmt = $this->driver->prepare($this);
		if(!empty($this->setTypes))
			$stmt->bind_param($this->setTypes, ...$this->setValues);
		$stmt->execute();
		$insert_id = $stmt->insert_id;
		$stmt->close();
		return $insert_id;
		
	}

	function __toString(): string {
		return "INSERT INTO `$this->table` SET {$this->setPart}";
	}
}
