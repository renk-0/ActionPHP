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
		foreach(array_keys($_FILES) as $name)
			$files[] = self::getUploadedFile($name);
		return $files;
	}

	static function getUploadedFile(string $name): File|array|null {
		if(!isset($_FILES[$name]))
			return null;
		$uploaded = $_FILES[$name];
		if(is_array($uploaded['error'])) {
			$files = [];
			$cant_files = count($uploaded['error']);
			for($i = 0; $i < $cant_files; $i++) {
				$file = new File;
				if($uploaded['error'][$i] != UPLOAD_ERR_OK)
					continue;
				$file->mime = $uploaded['type'][$i];
				$file->filename = $uploaded['name'][$i];
				$file->path = $uploaded['tmp_name'][$i];
				$file->size = $uploaded['size'][$i];
			}
			return $files;
		} else {
			$uploaded = $_FILES[$name];
			$file = new File;
			if($uploaded['error'] != UPLOAD_ERR_OK)
				return null;
			$file->mime = $uploaded['type'];
			$file->filename = $uploaded['name'];
			$file->path = $uploaded['tmp_name'];
			$file->size = $uploaded['size'];
			return $file;
		}
	}

	function moveTo(string $dir): bool {
		$old_path = $this->path;
		$new_path = UPLOAD_DIR . "/$dir";
		if(!file_exists($new_path)) {
			if(!mkdir($new_path, 0o755, true));
				return false;
		}
		$ufilename = "$_SERVER[REQUEST_TIME_FLOAT]|{$this->filename}";
		$ufilename = md5($ufilename);
		$new_path = "$new_path/$ufilename";
		if(is_uploaded_file($this->path))
			$ret = move_uploaded_file($old_path, $new_path);
		else
			$ret = rename($old_path, $new_path);
		$this->path = "$dir/$ufilename";
		return $ret;
	}

	function delete() {
		$file_path = UPLOAD_DIR . "/{$this->path}";
		if(file_exists($file_path))
			unlink($file_path);
		$this::remove($this->id);
	}

	function url(): string {
		return UPLOAD_DIR . "/{$this->path}";
	}
}
