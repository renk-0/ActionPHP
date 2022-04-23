<?php namespace Modules\Kernel;

class File extends Entity {
	public string $filename;
	public string $mime;
	public int $size;
	public string $path;
}
