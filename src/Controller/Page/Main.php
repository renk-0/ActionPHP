<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Main extends Page {
	function __construct() {
		parent::__construct('index.phtml');
		$this->addStyle('global.css');
		$this->setTitle('Remilia Pocky!!');
	}

	function _hi() {
		echo 'Ok!';
	}
}
