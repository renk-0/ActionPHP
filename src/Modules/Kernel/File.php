<?php namespace Modules\Kernel;

class File extends Entity {
	const TABLE = 'file';
	public string $filename;
	public string $mime;
	public int $size;
	public string $path;

	/** @return File[] */
	static function uploadedFiles(): array {
		echo '<pre>';
		print_r($_FILES);
		return [];
	}

	function moveTo(string $dir): bool {
		$created_path = true;
		$new_path = "$_ENV[Site][files_dir]/$dir";
		if(!file_exists($new_path))
			$created_path = mkdir($new_path, 0755, true);
		if(!$created_path)
			return false;
		$ufilename = "$_SERVER[REQUEST_FLOAT]|{$this->filename}";
		$ufilename = md5($ufilename);
		if(is_uploaded_file($this->path))
			return move_uploaded_file($this->path, "$dir/$ufilename");
		else
			return rename($this->path, "$dir/$ufilename");
	}
}
