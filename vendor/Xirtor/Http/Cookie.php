<?php
/**
* @package Xirtor Http
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Http;

/**
* Cookie
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Cookie{

	public $name = '';
	public $value = '';
	public $alive = 3600;
	public $path = '/';
	public $domain = '';
	public $secure = false;
	public $httponly = false;
	protected $_set = false;

	public function __construct($name, $value){
		$this->domain = $_SERVER['SERVER_NAME'];
		$this->name = $name;
		$this->value = $value;
	}

	public function call($name, $arguments = null){
		return isset($arguments[0]) ? $this->__get($name, $arguments[0]) : $this->__get($name);
	}

	public function __set($name, $value){
		if (isset($this->$name)) {
			$this->$name = $value;
		}
		return $this;
	}

	public function __get($name){
		return isset($this->$name) ? $this->$name : null;
	}

	public function set(){
		return $this->_set = setcookie($this->name, $this->value, time() + $this->alive, $this->path, $this->domain, $this->secure, $this->httponly);
	}

	public function unset(){
		return $this->_set = !setcookie($this->name, $this->value, time() - 100, $this->path, $this->domain, $this->secure, $this->httponly);
	}

}
