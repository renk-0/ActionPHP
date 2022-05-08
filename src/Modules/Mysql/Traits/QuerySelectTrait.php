<?php namespace Modules\Mysql\Traits;

trait QuerySelectTrait { 
	protected string $selectPart = '*';

	function select(string $field) {
		if($this->selectPart[0] == '*')
			$this->selectPart = '';
		if(!empty($this->selectPart))
			$this->selectPart .= ', ';
		$this->selectPart .= $field;
	}
}
