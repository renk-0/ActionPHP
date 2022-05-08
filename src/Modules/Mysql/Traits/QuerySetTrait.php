<?php namespace Modules\Mysql\Traits;

trait QuerySetTrait {
	protected string $setPart = '';	
	protected string $setTypes = '';
	protected array $setValues = [];

	function set(string $field, &$ref, string $type = 's') {
		$this->setValues[] =& $ref;
		$this->setTypes .= $type;
		if(!empty($this->setPart))
			$this->setPart .= ', ';
		$this->setPart .= "`$field`=?";
	}
}
