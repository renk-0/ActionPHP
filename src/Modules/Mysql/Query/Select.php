<?php namespace Modules\Mysql\Query;

use Modules\Kernel\Select as KernelSelect;
use Modules\Mysql\Query;
use Modules\Mysql\Results;
use Modules\Mysql\Traits\QueryConditionTrait;
use Modules\Mysql\Traits\QueryGroupTrait;
use Modules\Mysql\Traits\QueryLimitTrait;
use Modules\Mysql\Traits\QueryOrderTrait;
use Modules\Mysql\Traits\QuerySelectTrait;

class Select extends Query implements KernelSelect {
    use QuerySelectTrait;
    use QueryGroupTrait;
    use QueryLimitTrait;
    use QueryOrderTrait;
    use QueryConditionTrait;

    function execute(): bool|Results {
        $result = false;
		$stmt = $this->driver->prepare($this);
        if(!empty($this->condTypes))
            $stmt->bind_param($this->condTypes, ...$this->condValues);
		if($stmt->execute()) 
            $result = new Results($stmt->get_result());
        $stmt->close();
        return $result;
    }

    function __toString(): string {
        $query = "SELECT {$this->selectPart} FROM `{$this->table}`";
        if(!empty($this->condPart))
            $query .= " WHERE {$this->condPart}";
        if(!empty($this->groupPart))
            $query .= " GROUP BY {$this->groupPart}";
        if(!empty($this->orderPart))
            $query .= " ORDER BY {$this->orderPart}";
        if(isset($this->count))
            $query .= " LIMIT {$this->count} OFFSET {$this->offset}";
        return $query;
    }
}
