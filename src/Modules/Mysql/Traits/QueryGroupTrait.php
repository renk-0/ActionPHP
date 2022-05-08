<?php namespace Modules\Mysql\Traits;

trait QueryGroupTrait { 
	protected string $groupPart = '';

	function groupBy(string $field, string $order = 'ASC') {
		if(!empty($this->groupPart))
			$this->groupPart .= ", ";
		$this->groupPart .= "$field $order";
	}
}


