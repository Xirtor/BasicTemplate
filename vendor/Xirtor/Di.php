<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor;

use Xirtor\Object;

/**
* Di container
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Di extends Object{
	
	public function __set($name, $value){
		$this->$name = $value instanceof Closure ? $value->bindTo($this) : $value;
	}

	public function __get($name){
		return isset($this->$name) ? $this->$name : null;
	}

	public function __call($name, array $arguments = null){
		return is_callable($this->$name) ? call_user_func_array($this->$name, $arguments) : null;
	}

}