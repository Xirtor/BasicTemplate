<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Web;

use Xirtor\Object;
use Xirtor\Web\Route;

/**
* Router
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Router extends Object{

	// 404 Not Found handler
	public $notFound;

	// 403 Access Denied handler
	public $accessDenied;

	// 500 Internal Server Error handler
	public $internalServerError;
	

	protected $_routes = [
		'GET' => [],
		'POST' => []
	];

	public static $patterns = [
		':int' => '[0-9]{1,11}',
		':any' => '.+',
		':title' => '[a-zA-Z0-9_-]+'
	];

	public function __set($name, $value){
		if ($name === 'routes') $this->importRoutes($value);
	}

	public function setRoute($method, $path, $handler){
		$this->_routes[strtoupper($method)][$path] = &$handler;
	}

	public function setRoutes($method, array $routes){
		foreach ($routes as $path => $handler) {
			$this->setRoute($method, $path, $handler);
		}
	}

	public function importRoutes(array $routes){
		foreach ($routes as $method => $local) {
			$this->setRoutes($method, $local);
		}
	}

	protected static function _preparePath($path){
		foreach (static::$patterns as $alias => $regExp) {
			$path = str_replace($alias, $regExp, $path);
		}
		$path = str_replace('/', '\/', $path);
		$path = '/^' . $path . '$/';
		return $path;
	}

	public function handle($url = null, $method = null){
		if (!$url) $url = $_SERVER['REQUEST_URI'];
		if (!$method) $method = $_SERVER["REQUEST_METHOD"];
		$routes = $this->_routes[$method];
		if ($routes) foreach ($routes as $path => $handler) {
			if (preg_match(static::_preparePath($path), $url, $matches)) {
				return new Route($handler, $matches);
			}
		}
		return new Route($this->notFound, null);
	}

}