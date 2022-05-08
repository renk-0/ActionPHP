<?php namespace Modules\Account;

use DateTime;

abstract class Session {
	static function exists(): bool {
		$path = session_save_path();
		$name = session_name();

		if($ssid = $_COOKIE[$name] ?? false) {
			if(file_exists("$path/sess_$ssid"))
				return true;
		}
		
		return false;
	}

	static function started(): bool {
		if(session_status() == PHP_SESSION_ACTIVE)
			return true;
		return false;
	}

	static function start(): bool {
		if(Session::exists())
			return session_start();
		return false;
	}

	static function create(User $account): bool {
		if(self::started()) {
			session_unset();
			session_destroy();
			session_commit();
		}
		session_start();
		$_SESSION['uid'] = $account->id;
		$_SESSION['date'] = new DateTime();
		return true;
	}

	static function close() {
		session_unset();
		session_destroy();
		session_commit();
	}

	static function stop() {
		if(Session::started())
			session_commit();
	}
}
