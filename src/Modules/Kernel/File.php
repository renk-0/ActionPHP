<?php namespace Modules\Kernel;

class File extends Entity {
	const TABLE = 'file';
	public string $filename;
	public string $mime;
	public int $size;
	public string $path;

	/** @return File[] */
	static function uploadedFiles(): array {
		$files = [];
		foreach($_FILES as $name => $fields) {
			$files[$name] = [];
			$cant_files = count($fields['error']);
			for($i = 0; $i < $cant_files; $i++) {
				if($fields['error'][$i] != UPLOAD_ERR_OK)
					continue;
				$file = new File;
				$file->mime = $fields['type'][$i];
				$file->filename = $fields['name'][$i];
				$file->path = $fields['tmp_name'][$i];
				$file->size = $fields['size'][$i];
				$files[$name][] = $file;
			}
		}
		return $files;
	}

	function moveTo(string $dir): bool {
		$old_path = $this->path;
		$new_path = "{$_ENV['Site']['files_dir']}/$dir";
		if(!file_exists($new_path)) {
			if(!mkdir($new_path, 0o755, true));
				return false;
		}
		$ufilename = "$_SERVER[REQUEST_TIME_FLOAT]|{$this->filename}";
		$ufilename = md5($ufilename);
		$new_path = "$new_path/$ufilename";
		$this->path = "$dir/$ufilename";
		if(is_uploaded_file($this->path))
			return move_uploaded_file($old_path, $new_path);
		else
			return rename($old_path, $new_path);
	}

	function delete() {
		$file_path = "{$_ENV['Site']['files_dir']}/{$this->path}";
		if(file_exists($file_path))
			unlink($file_path);
		$this::remove($this->id);
	}

	function url(): string {
		return "/{$_ENV['Site']['files_dir']}/{$this->path}";
	}
}
