<?php
require_once "src/autoloader.php";

use Modules\Kernel\Enviroment;
use Modules\Kernel\NotFoundException;
use Modules\Kernel\Page;
use Modules\Kernel\Router;
use Modules\Kernel\View;

Enviroment::read('site.ini');
Enviroment::include('local.ini');
Router::read($_ENV['Site']['routes']);

try {
	/** @var Page */
	$content = Router::get($_SERVER['DOCUMENT_URI']);
	if(empty($content))
		throw new NotFoundException('Page not found');
	$event = $content->init();
	if($event) $event->invoke($content);
	View::render($content->getPage());
} catch(NotFoundException $not_found) {
	$view = new Page($_ENV['Site']['not_found']);
	$view->error = $not_found;
	View::render($view->getPage());
} catch(Error|Exception $error) {
	$view = new Page($_ENV['Site']['error_page']);
	$view->error = $error;
	View::render($view->getPage());
}
