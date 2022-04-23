<?php
require_once "src/autoloader.php";

use Modules\Kernel\Enviroment;
use Modules\Kernel\Page;
use Modules\Kernel\Router;
use Modules\Kernel\View;

Enviroment::read('site.ini');
Enviroment::include('local.ini');
Router::read($_ENV['Site']['routes']);

try {
	/** @var Page */
	$content = Router::get($_SERVER['DOCUMENT_URI']);
	$event = $content->init();
	if($event) $event->invoke($content);
	View::render($content->getPage());
} catch(Error|Exception $error) {
	$page = new Page($_ENV['Site']['error_page']);
	$page->error = $error;
	View::render($page);
}
