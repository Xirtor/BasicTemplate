<?php
/**
* @package Xirtor Auth
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Auth;

use Xirtor\Web\Model;
use Xirtor\Auth\Authorization;
use Xirtor\Auth\Registration;

/**
* User model with authorization and registration
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class User extends Model{

	public function auth(){
		static $obj = null;
		if ($obj === null) {
			$obj = new Authorization($this);
		}
		return $obj;
	}

	public function registration(){
		static $obj = null;
		if ($obj === null) {
			$obj = new Registration($this);
		}
		return $obj;
	}

}