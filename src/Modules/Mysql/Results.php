<?php namespace Modules\Mysql;

use Modules\Kernel\Results as KernelResults;
use mysqli_result;

class Results implements KernelResults {
	private bool $isFree = false;
	protected mysqli_result $result;

	function __construct(mysqli_result $result) {
		$this->result = $result;
	}
	
	function row(string $class = null): object|array|null {
		if(isset($class) && !empty($class))
			return $this->result->fetch_object($class);
		return $this->result->fetch_assoc();
	}

	function free() {
		$this->result->free();
		$this->isFree = true;
	}

	function __destruct() {
		if(!$this->isFree)
			$this->free();
	}

	function all(string $class = null): array {
		if(isset($class) && !empty($class)) {
			$results = [];
			while($row = $this->result->fetch_object($class))
				$results[] = $row;
			return $results;
		} else
			return $this->result->fetch_all(MYSQLI_ASSOC);
	}
}
