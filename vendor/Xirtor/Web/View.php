<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Web;

use Xirtor\Exception;

/**
* MVC View
* @author Egor Vasyakin <egor.vasykin@itevas.ru>
* @since 1.0
*/

class View{
	
	public $app;

	public function __construct(&$app){
		$this->app = $app;
	}

	public function render($template, array $params = []){
		$filename = $this->app->viewsDir . $template;
		if (is_readable($filename)) {
			extract($params);
			unset($params);
			include $filename;
		} else {
			throw new Exception('Could not found template "' . $template . '" in folder "' . $this->app->viewsDir . '"');
		}
	}

}