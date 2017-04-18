<?php
/**
* @package Xirtor Auth
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Auth;

use Xirtor\Auth\User;
use Xirtor\Auth\Session;
use Xirtor\Http\Cookie;
use Xirtor\Exception;

/**
* User authorization
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Authorization{


	public static $tokenAlive = 3600;
	public static $tokenName = 'token';
	public static $tokenLength = 60;

	public $user;
	public $session;
	protected $_isAuth = false;

	public $error;

	// error messages
	public static $messages = [
		'userUndefined' => 'User undefined',
		'verifyFailed' => 'Verify failed',
		'updateSessionFailed' => 'Update session failed',
		'insertSessionFailed' => 'Insert session failed',
		'setCookieFailed' => 'Set cookie failed',
		'unsetCookieFailed' => 'Unset cookie failed'
	];

	// error handler
	public function errorHandler($messageKey){
		$this->error = static::$messages[$messageKey];
		return false;
	}

	// auth in
	public function __construct(User $user = null){
		$this->user = $user;
	}

	public static function verify($password, $hash){
		return password_verify($password, $hash);
	}

	public static function getToken(){
		static $symbols = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$number = strlen($symbols);
		$token = '';
		for ($i = 0; $i < static::$tokenLength; $i++) {
			$token .= $symbols[rand()%$number];
		}
		return $token;
	}

	public static function getDieTime(){
		return date('Y-m-d H:i:s', time() + static::$tokenAlive);
	}

	public static function getIp(){
		return $_SERVER['REMOTE_ADDR'];
	}

	public static function getAgent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}


	public function in(array $values = null){
		// set user
		if ($values) {
			$user = new User($values);
		} else if (isset($this->user)) {
			$user = &$this->user;
		} else {
			throw new Exception('user object and values not found');
		}

		// find user with entered username or email
		$find = User::find()->where('username = ' . $user->username)->orWhere('email = ' . $user->email)->one()->object();

		// undefined user
		if (!$find) return $this->errorHandler('userUndefined');

		// verify failed
		if (!static::verify($user->password, $find->hash)) return $this->errorHandler('verifyFailed');

		// set id
		$user->id = $find->id;

		// create session
		$session = new Session;
		$session->user_id = $user->id;
		$session->token = static::getToken();
		$session->die_time = static::getDieTime();
		$session->ip = static::getIp();
		$session->agent = static::getAgent();

		// find session
		$find = Session::find()->where('user_id = ' . $session->user_id)->andWhere('ip = ' . $session->ip)->andWhere('agent = ' . $session->agent)->one()->object();

		if ($find) {
			// if session exist update
			$session->id = $find->id;
			if (!$session->update()) return $this->errorHandler('updateSessionFailed');
		} else {
			// else insert session
			if (!$session->insert()) return $this->errorHandler('insertSessionFailed');
		}

		// set cookie
		$cookie = new Cookie(static::$tokenName, $session->token);
		$cookie->alive = static::$tokenAlive;
		if (!$cookie->set()) return $this->errorHandler('setCookieFailed');

		// true authorization
		$this->_isAuth = true;
		return true;

	}

	public function is(){
		return $this->_isAuth;
	}

	public function out(){
		// unset cookie
		$cookie = new Cookie(static::$tokenName, 'deleted');
		if (!$cookie->unset()) return $this->errorHandler('unsetCookieFailed');
		//  true out
		$this->_isAuth = false;
		return true;
	}

	public function check(){
		// 
	}

}