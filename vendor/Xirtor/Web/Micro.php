<?php
/**
* @package Xirtor Micro
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Web;

use Xirtor\Web\Router;
use Xirtor\Web\Route;

/**
* Micro Application
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Micro{

	public $dir;
	public $url;
	public $path;

	public $router;
	public $handlersDir;

	public function __construct(){
		$slash = strrpos($_SERVER['PHP_SELF'], '/index.php');
		$this->dir = substr($_SERVER['PHP_SELF'], 0, $slash + 1);
		$this->url = substr($_SERVER['REQUEST_URI'], $slash);
		$this->path = parse_url($this->url, PHP_URL_PATH);
		$this->router = new Router;
	}

	public function get($path, $handler){
		$this->router->set('GET', $path, $handler);
	}

	public function post($path, $handler){
		$this->router->set('POST', $path, $handler);
	}

	public function handler($handler, array $matches = []){
		$app = $this;
		$handler = require $this->handlersDir . $handler . '.php';
		if (is_callable($handler)) {
			return call_user_func_array($handler, $matches);
		}
	}

	public function handle(){
		$route = $this->router->handle($this->path);

		$handler = $route->handler;

		if (!$handler) return false;

		if ($route->matches) {
			array_shift($route->matches);
		} else {
			$route->matches = [];
		}

		$app = $this;

		if (!is_callable($handler) && !is_array($handler) && count($handler) !== 2) {
			$handler = require $this->handlersDir . $handler . '.php';
			if (!is_callable($handler)) return;
		}
		return call_user_func_array($handler, $route->matches);
	}

}