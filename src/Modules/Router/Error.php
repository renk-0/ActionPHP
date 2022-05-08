<?php namespace Modules\Router;

use Error as GlobalError;
use Exception;
use Modules\Kernel\Page;

class Error extends Page {
	public GlobalError|Exception $error;

	function __construct() {
		parent::__construct(__DIR__ . '/Templates/exception.phtml');
		http_response_code(500);
	}
}
