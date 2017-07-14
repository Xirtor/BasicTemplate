<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Web;

/**
* Route
* @author Egor Vasyakin <egor.vasykin@itevas.ru>
* @since 1.0
*/

class Route{

	public $handler;
	public $path;
	public $matches = [];

	public function __construct($handler = null, $matches = null){
		$this->handler = &$handler;
		if ($matches) {
			$this->path = array_shift($matches);
			$this->matches = $matches;
		}
	}

}