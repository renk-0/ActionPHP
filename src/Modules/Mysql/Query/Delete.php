<?php namespace Modules\Mysql\Query;

use Modules\Kernel\Delete as KernelDelete;
use Modules\Mysql\Driver;
use Modules\Mysql\Query;
use Modules\Mysql\Results;
use Modules\Mysql\Traits\QueryConditionTrait;
use Modules\Mysql\Traits\QueryLimitTrait;

class Delete extends Query implements KernelDelete {
	use QueryConditionTrait;
	use QueryLimitTrait;

	function execute(): bool|Results {
		$stmt = $this->driver->prepare($this);
		if(!empty($this->condTypes))
			$stmt->bind_param($this->condTypes, ...$this->condValues);
		$stmt->execute();
		$stmt->close();
		return true;
	}

	function __toString(): string {
		$query = "DELETE FROM `{$this->table}`";
		if(!empty($this->condPart))
			$query .= " WHERE {$this->condPart}";
		if(isset($this->count))
			$this .= " LIMIT {$this->limit} OFFSET {$this->offset}";
		return $query;
	}
}
