<?php namespace Modules\Mysql\Traits;

trait QueryOrderTrait {
	protected string $orderPart = '';

	function orderBy(string $field, string $order = 'ASC') {
		if(!empty($this->orderPart))
			$this->orderPart .= ", ";
		$this->orderPart .= "$field $order";
	}
}
