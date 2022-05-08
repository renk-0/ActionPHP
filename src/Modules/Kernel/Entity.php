<?php namespace Modules\Kernel;

class Entity {
	const TABLE = self::TABLE;
	public int $id;
	
	function save() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$insert = $driver->create(static::TABLE);
		unset($this->id);
		foreach($this as $k => &$v)
			$insert->set($k, $v);
		$this->id = $insert->execute();
	}

	function update() {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$update = $driver->update(static::TABLE);
		foreach($this as $k => &$v)
			$update->set($k, $v);
		$update->condition('id', $this->id);
		$update->execute();
	}

	static function load(int $id): ?static {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(static::TABLE);
		$select->condition('id', $id);
		$res = $select->execute();
		$entity = $res->row(static::class);
		$res->free();
		return $entity;
	}

	static function loadAll(int ...$ids): array {
		$rows = [];
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$select = $driver->read(static::TABLE);
		if(count($ids) > 0) {
			$select->condition('id', $id);
			foreach($ids as $id) {
				$res = $select->execute();
				$rows[] = $res->row(static::class);
				$res->free();
			}
			return $rows;
		} else {
			$res = $select->execute();
			$rows = $res->all(static::class);
			$res->free();
			return $rows;
		}
	}

	static function remove(int $id) {
		/** @var \Modules\Mysql\Driver */
		$driver = Storage::driver();
		$delete = $driver->delete(static::TABLE);
		$delete->condition('id', $id);
		$delete->execute();
	}
}

