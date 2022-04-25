<?php namespace Modules\Kernel;

class User extends Entity {
	const TABLE = 'user';
	public string $username;
	public string $password;
	public string $role;
}
