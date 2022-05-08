<?php namespace Modules\Kernel;

use ReflectionClass;
use ReflectionMethod;

abstract class Page extends View {
	private string $styleSheet;
	private string $script;
	private string $title;
	private array $permissions = [];

	function render(): bool {
		ob_start();
		include "src/Templates/page_template.phtml";
		return ob_end_flush();
	}

	protected function title(string $title) {
		$this->title = $title;
	}

	protected function style(string $href) {
		$this->styleSheet = $href;
	}

	protected function script(string $src) {
		$this->script = $src;
	}

	protected function access(string ...$permissions) {
		$this->permissions = $permissions;
	}

	public function init(): ?ReflectionMethod {
		// Check if the user has permissions
		

		// Process the event
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
}
