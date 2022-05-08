<?php namespace Modules\Router;

use Modules\Kernel\Page;

class NotFound extends Page {
	function __construct() {
		parent::__construct(__DIR__ . '/Templates/not_found.phtml');
		http_response_code(404);
	}
}
