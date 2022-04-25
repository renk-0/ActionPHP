<?php namespace Modules\Kernel;

use Modules\Mysql\Database;

class Entity {
	const TABLE = self::TABLE;
	public int $id;

	function save() {
		$data_values = [];
		$data_types = '';
		$table = static::TABLE;
		$query = "INSERT INTO `$table` SET ";
		unset($this->id);
		foreach($this as $key => $value) {
			$query .= "`$key` = ?,";
			$data_types .= Database::typeChar($value);
			$data_values[] = $value;
		}
		$query = substr($query, 0, -1);
		
		$db = Database::getConnection();
		$stmt = $db->prepare($query);
		$stmt->bind_param($data_types, ...$data_values);
		$stmt->execute();
		$this->id = $stmt->insert_id;
		$stmt->close();
		return true;
	}

	function update() {
		$data_values = [];
		$data_types = '';
		$current_id = $this->id;
		$table = static::TABLE;
		$query = "UPDATE `$table` SET ";
		unset($this->id);
		foreach($this as $key => $value) {
			$query .= "`$key` = ?,";
			$data_types .= Database::typeChar($value);
			$data_values[] = $value;
		}
		$query = substr($query, 0, -1);
		$query .= " WHERE id = ?";
		$data_types .= 'i';
		$data_values[] = $current_id;
		$this->id = $current_id;
		
		$db = Database::getConnection();
		$stmt = $db->prepare($query);
		$stmt->bind_param($data_types, ...$data_values);
		$stmt->execute();
		$stmt->close();
		return true;
	}

	static function load(int $id): ?static {
		$table = static::TABLE;
		$query = "SELECT * FROM `$table` WHERE id = ?";
		$db = Database::getConnection();
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_object(static::class);
		$result->free();
		$stmt->close();
		return $row;
	}

	/** @return static[] */
	static function loadAll(int ...$ids): array {
		$rows = [];
		$table = static::TABLE;
		$db = Database::getConnection();
		if(count($ids) > 0) {
			$query = "SELECT * FROM `$table` WHERE id = ?";
			$stmt = $db->prepare($query);
			foreach($ids as $id) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$result = $stmt->get_result();
				$rows[] = $result->fetch_object(static::class);
				$result->free();
			}
			$stmt->close();
		} else {
			$query = "SELECT * FROM `$table`";
			$stmt = $db->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();
			while($entity = $result->fetch_object(static::class))
				$rows[] = $entity;
			$result->free();
			$stmt->close();
		}
		return $rows;
	}

	static function remove(int $id) {
		$table = static::TABLE;
		$query = "DELETE FROM `$table` WHERE id = ?";
		$db = Database::getConnection();
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
	}

}

