<?php namespace Modules\Kernel;


class View {
	const DIR = 'src/Templates/';
	private string $file;

	function __construct(string $file) {
		if($file[0] != '/')
			$file = self::DIR . $file;
		$this->file = $file;
	}

	function __toString() {
		return $this->file;
	}

	function render(): bool {
		ob_start();
		include $this->file;
		return ob_end_flush();
	}
}

