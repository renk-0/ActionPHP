<?php namespace Modules\Kernel;

use ReflectionMethod;

abstract class Form extends Page {
	function init(): ReflectionMethod {
		$event = parent::init();
		if($event->name == '_submit')
			$this->verify();
		return $event;
	}

	abstract function verify(): bool;
	abstract function _submit();
}
