<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor;

/**
* Base object class
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Object{

	public static function className(){
		return get_called_class();
	}
	
	public function __construct(array $config = null){
		if ($config) foreach ($config as $name => $value) $this->$name = $value;
		$this->init();
	}

	public function init(){
		// 
	}

	public function __set($name, $value){
		// 
	}

	public function __get($name){
		// 
	}

}