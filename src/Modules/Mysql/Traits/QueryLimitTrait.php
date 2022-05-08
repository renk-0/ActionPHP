<?php namespace Modules\Mysql\Traits;

trait QueryLimitTrait {
	protected int $count;
	protected int $offset;

	function limit(int $count, int $offset = 0) {
		$this->count = $count;
		$this->offset = $offset;
	}
}
