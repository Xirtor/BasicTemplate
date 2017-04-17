<?php
/**
* @package Xirtor Routing
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Web;

/**
* Route
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Route{

	public $path;
	public $handler;
	public $matches;

	public function __construct($path = null, $handler = null, $matches = null){
		$this->path = $path;
		$this->handler = $handler;
		$this->matches = $matches;
	}

}