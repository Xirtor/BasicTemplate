<?php
/**
* @package Xirtor Routing
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Web;

use Xirtor\Web\Router;
use Xirtor\Web\Route;

/**
* Router class represents routes manager
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Router{

	public $route;
	public $notFound;

	public $routes = [
		'GET' => [],
		'POST' => [],
		'PUT' => [],
		'PATCH' => [],
		'DELETE' => [],
		'OPTIONS' => [],
		'ALL' => []
	];

	public $patterns = [
		':num' => '[0-9]*',
		':any' => '.*'
	];

	public function set($method, $path, $handler){
		$method = strtoupper($method);
		$this->routes[$method][$path] = $handler;
	}

	public function import(array $routes){
		foreach ($routes as $method => $local) {
			foreach ($local as $path => $handler) {
				$this->set($method, $path, $handler);
			}
		}
	}

	protected function _preparePath($path){
		foreach ($this->patterns as $alias => $regExp) {
			$path = str_replace($alias, $regExp, $path);
		}
		$path = str_replace('/', '\/', $path);
		return '/^' . $path . '$/';
	}

	public function handle($url = null){
		if (!$url) $url = $_SERVER['REQUEST_URI'];
		$method = $_SERVER['REQUEST_METHOD'];
		$routes = array_merge($this->routes[$method], $this->routes['ALL']);
		if ($routes) foreach ($routes as $path => $handler) {
			if (preg_match($this->_preparePath($path), $url, $matches)) {
				return $this->route = new Route($path, $handler, $matches);
			}
		}
		return $this->route = new Route(null, $this->notFound);
	}

}