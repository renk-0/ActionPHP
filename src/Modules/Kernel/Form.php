<?php namespace Modules\Kernel;

use ReflectionMethod;

abstract class Form extends Page {
	function init(): ?ReflectionMethod {
		$event = parent::init();
		if(empty($event))
			return null;
		if(!$this->verify())
			return null;
		return $event;
	}

	abstract function verify(): bool;
	abstract function _submit();
}
