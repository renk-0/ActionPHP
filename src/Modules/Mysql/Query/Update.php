<?php namespace Modules\Mysql\Query;

use Modules\Kernel\Update as KernelUpdate;
use Modules\Mysql\Driver;
use Modules\Mysql\Query;
use Modules\Mysql\Results;
use Modules\Mysql\Traits\QueryConditionTrait;
use Modules\Mysql\Traits\QueryLimitTrait;
use Modules\Mysql\Traits\QueryOrderTrait;
use Modules\Mysql\Traits\QuerySetTrait;

class Update extends Query implements KernelUpdate {
    use QuerySetTrait;
    use QueryLimitTrait;
    use QueryOrderTrait;
    use QueryConditionTrait;

    function execute(): bool|Results {
        $types = $this->setTypes . $this->condTypes;
        $refs = array_merge($this->setValues, $this->condValues);
		$stmt = $this->driver->prepare($this);
        if(!empty($types))
            $stmt->bind_param($types, ...$refs);
		$stmt->execute();
        $stmt->close();
        return true;
    }

    function __toString(): string {
        $query = "UPDATE `{$this->table}` SET {$this->setPart}";
        if(!empty($this->condPart))
            $query .= " WHERE {$this->condPart}";
        if(!empty($this->orderPart))
            $query .= " ORDER BY {$this->orderPart}";
        if(isset($this->count))
            $query .= " LIMIT {$this->count} OFFSET {$this->offset}";
        return $query;
    }
}
