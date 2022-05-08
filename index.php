<?php
require_once "src/autoloader.php";
require_once 'settings.php';
include_once 'local.settings.php';

use Modules\Router\Router;
use Modules\Account\Session;
use Modules\Kernel\Storage;
use Modules\Router\Error as ErrorPage;

Session::start();
Router::file('routes.json');

try {
	$page = Router::current();
	$fn = $page->init();
	if(!empty($fn))
		$fn->invoke($page);
	$page->render();
} catch(Error|Exception $e) {
	while(ob_get_level() > 0)
		ob_end_clean();
	/** @var Page */
	$page = new ErrorPage;
	$page->error = $e;
	$page->render();
}

Session::stop();
Storage::close();
