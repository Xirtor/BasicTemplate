<?php
/**
* @package Xirtor Auth
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Auth;

use Xirtor\Auth\User;

/**
* User registration
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Registration{

	public $user;
	protected $_registered = false;

	public $error;

	// error messages
	public static $messages = [
		'alreadyExistsWithUsername' => 'User witsh entered username already exists',
		'alreadyExistsWithEmail' => 'User witsh entered email already exists',
		'insertUserFailed' => 'Insert user failed'
	];

	// error handler
	public function errorHandler($messageKey){
		$this->error = static::$messages[$messageKey];
		return false;
	}


	public function __construct(User $user){
		$this->user = $user;
	}

	public static function getHash($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function handle(array $values = null){
		// set user
		if ($values) {
			$user = new User($values);
		} else if (isset($this->user)) {
			$user = &$this->user;
		} else {
			throw new Exception('user object and values not found');
		}

		// find user with username or email
		$find = User::find()->where('username = ' . $user->username)->orWhere('email = ' . $user->email)->one()->object();

		// user already exists
		if ($find) {
			if ($user->username === $find->username) {
				return $this->errorHandler('alreadyExistsWithUsername');
			} else {
				return $this->errorHandler('alreadyExistsWithEmail');
			}
		}

		// set hash
		$user->hash = static::getHash($user->password);
		unset($user->password);

		// insert user
		if (!$user->insert()) return $this->errorHandler('insertUserFailed');


		$this->_registered = true;
		return true;

	}

	public function is(){
		return $this->_registered;
	}

}