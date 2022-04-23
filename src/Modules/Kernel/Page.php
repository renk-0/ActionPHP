<?php namespace Modules\Kernel;

use ReflectionClass;
use ReflectionMethod;

class Page extends View {
	private View $page;

	function __construct(string $file) {
		parent::__construct($file);
		$this->page = new View('page_template.phtml');
		$this->page->styles = [];
		$this->page->scripts = [];
		$this->setContent($this);
	}

	/**
	 * Process the requested event send by
	 * the user and check if the method
	 * is a valid event
	 * */
	public function init(): ?ReflectionMethod {
		$event = $_GET['e'] ?? NULL;
		if(isset($event) && !empty($event)) {
			$refl = new ReflectionClass(static::class);
			if($refl->hasMethod("_$event")) {
				$method = $refl->getMethod("_$event");
				$name = $method->getName();
				if(strpos($name, '__') !== 0)
					return $method;
			}
		}
		return null;
	}

	function getPage(): View {
		return $this->page;
	}

	protected function setContent(View $content) {
		$this->page->content = $content;
	}

	function setTitle(string $title) {
		$this->page->title = $title;
	}

	function getTitle(): ?string {
		return $this->page->title;
	}

	function addStyle(string $file) {
		$this->page->styles[] = $file;
	}

	function addScript(string $file) {
		$this->page->scripts[] = $file;
	}
}
