<?php namespace Modules\Kernel;

use Error;

class View {
	private string $file;
	
	function __construct(string $file) {
		if(!isset($file))
			throw new Error('Views needs a template');
		$this->file = "src/Templates/$file";
	}

	function __toString() {
		return $this->file;
	}

	static function render(View $view): bool {
		ob_start();
		include $view;
		return ob_end_flush();
	}
}

