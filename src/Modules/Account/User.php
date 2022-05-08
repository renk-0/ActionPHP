<?php namespace Modules\Account;

use DateTime;
use Modules\Kernel\Entity;

class User extends Entity {
	const TABLE = 'user';
	public string $username;
	public string $email;
	public string $password;
	public ?string $role;
	public ?int $avatar;
	public bool $banned;
	public string $creation;
}
