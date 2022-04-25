<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Main extends Page {
	function __construct() {
		parent::__construct('index.phtml');
		$this->setTitle('Default page');
		$this->text = "ActionPHP works! now you can edit the controller and the templates";
	}

	function _example_event() {
		$this->text = "The example event has ben fired";
	}
}
