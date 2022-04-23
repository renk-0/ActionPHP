<?php namespace Controller\Page;

use Modules\Kernel\Page;

class Search extends Page {
	function __construct() {
		parent::__construct('searches.phtml');
		$this->query = $_GET['q'];
	}
}
