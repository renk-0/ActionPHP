<?php namespace Controller\Form;

use Modules\Kernel\Form;
use Modules\Kernel\Role;
use Modules\Kernel\User;

class AddUser extends Form {
	public array $roles = [];
	
	function __construct() {
		parent::__construct('editUser.phtml');
		$this->setTitle('Editar usuario');
		$this->roles = Role::loadAll();
	}

	function verify(): bool {
		if(!isset($_GET['id']) && empty($_GET['id']))
			return false;
		if(!isset($_POST['username']) && empty($_POST['username']))
			return false;
		if(!isset($_POST['password']) && empty($_POST['password']))
			return false;
		if(!isset($_POST['rol']) && empty($_POST['rol']))
			return false;
		if(empty(Role::load($_POST['rol'])))
			return false;
		return true;
	}

	function _submit() {
		$user = User::load($_GET['id']);
		$rol = Role::load($_POST['rol']);
		$user->role = $rol->name;
		$user->username = $_POST['username'];
		$user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$user->save();
	}
}

