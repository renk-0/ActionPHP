<?php namespace Modules\Kernel;

use DateTime;

class User extends Entity {
	public string $username;
	public string $password;
	public string $role;
}
