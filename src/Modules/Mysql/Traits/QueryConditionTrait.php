<?php namespace Modules\Mysql\Traits;

trait QueryConditionTrait {
	protected string $condPart = '';
	protected string $condTypes = '';
	protected array $condValues = [];
	
	function condition(
		string $field, &$ref, string $type = 's',
		string $condition = '=',
		string $operator = 'AND'
	) {
		$this->condValues[] =& $ref;
		$this->condTypes .= $type;
		if(!empty($this->condPart))
			$this->condPart .= " $operator ";
		$this->condPart .= "`$field` $condition ?";
	}
}
